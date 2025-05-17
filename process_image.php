<?php
header('Content-Type: application/json');

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Function to validate uploaded file
function validateUpload($file) {
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    $max_size = 10 * 1024 * 1024; // 10MB

    $errors = [];

    if (!isset($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) {
        $errors[] = 'No file was uploaded';
    } else {
        // Check file type
        if (!in_array($file['type'], $allowed_types)) {
            $errors[] = 'Invalid file type. Only JPG, PNG and GIF files are allowed';
        }

        // Check file size
        if ($file['size'] > $max_size) {
            $errors[] = 'File is too large. Maximum size is 10MB';
        }
    }

    return $errors;
}

// Function to process the image
function processImage($file, $settings) {
    try {
        // Create image resource based on file type
        $source = null;
        switch ($file['type']) {
            case 'image/jpeg':
                $source = imagecreatefromjpeg($file['tmp_name']);
                break;
            case 'image/png':
                $source = imagecreatefrompng($file['tmp_name']);
                break;
            case 'image/gif':
                $source = imagecreatefromgif($file['tmp_name']);
                break;
            default:
                throw new Exception('Unsupported image type');
        }

        if (!$source) {
            throw new Exception('Failed to create image resource');
        }

        // Get original dimensions
        $orig_width = imagesx($source);
        $orig_height = imagesy($source);

        // Calculate new dimensions based on scale
        $scale = isset($settings['scale']) ? floatval($settings['scale']) : 100;
        $new_width = $orig_width * ($scale / 100);
        $new_height = $orig_height * ($scale / 100);

        // Create new image with new dimensions
        $processed = imagecreatetruecolor($new_width, $new_height);

        // Preserve transparency for PNG images
        if ($file['type'] === 'image/png') {
            imagealphablending($processed, false);
            imagesavealpha($processed, true);
        }

        // Resize the image
        imagecopyresampled(
            $processed, $source,
            0, 0, 0, 0,
            $new_width, $new_height,
            $orig_width, $orig_height
        );

        // Apply additional processing based on settings
        if (isset($settings['brightness'])) {
            imagefilter($processed, IMG_FILTER_BRIGHTNESS, $settings['brightness']);
        }

        if (isset($settings['contrast'])) {
            imagefilter($processed, IMG_FILTER_CONTRAST, $settings['contrast']);
        }

        // Create temporary file for output
        $output_file = tempnam(sys_get_temp_dir(), 'img_');
        
        // Save processed image
        switch ($file['type']) {
            case 'image/jpeg':
                imagejpeg($processed, $output_file, 90);
                break;
            case 'image/png':
                imagepng($processed, $output_file, 9);
                break;
            case 'image/gif':
                imagegif($processed, $output_file);
                break;
        }

        // Clean up
        imagedestroy($source);
        imagedestroy($processed);

        // Read the processed image and encode as base64
        $processed_data = base64_encode(file_get_contents($output_file));
        unlink($output_file); // Delete temporary file

        return [
            'success' => true,
            'data' => [
                'image' => 'data:' . $file['type'] . ';base64,' . $processed_data,
                'width' => $new_width,
                'height' => $new_height
            ]
        ];

    } catch (Exception $e) {
        return [
            'success' => false,
            'error' => $e->getMessage()
        ];
    }
}

// Main execution
try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method');
    }

    if (!isset($_FILES['image'])) {
        throw new Exception('No image file received');
    }

    // Validate upload
    $validation_errors = validateUpload($_FILES['image']);
    if (!empty($validation_errors)) {
        throw new Exception(implode(', ', $validation_errors));
    }

    // Get processing settings from POST data
    $settings = isset($_POST['settings']) ? json_decode($_POST['settings'], true) : [];

    // Process the image
    $result = processImage($_FILES['image'], $settings);

    // Output the result
    echo json_encode($result);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?>
