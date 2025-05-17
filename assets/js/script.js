document.addEventListener('DOMContentLoaded', () => {
    // Tab Navigation
    const tabs = document.querySelectorAll('.tab-btn');
    const sections = document.querySelectorAll('.section');

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            // Remove active class from all tabs and sections
            tabs.forEach(t => t.classList.remove('active'));
            sections.forEach(s => s.classList.remove('active'));

            // Add active class to clicked tab
            tab.classList.add('active');

            // Show corresponding section
            const index = Array.from(tabs).indexOf(tab);
            sections[index].classList.add('active');
        });
    });

    // File Upload Handling
    const dropZone = document.getElementById('dropZone');
    const fileInput = document.getElementById('fileInput');
    const loadImageBtn = document.getElementById('loadImageBtn');

    // Trigger file input when load image button is clicked
    loadImageBtn.addEventListener('click', () => {
        fileInput.click();
    });

    // Handle file selection
    fileInput.addEventListener('change', handleFileSelect);

    // Drag and drop handlers
    dropZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        e.stopPropagation();
        dropZone.classList.add('drag-over');
    });

    dropZone.addEventListener('dragleave', (e) => {
        e.preventDefault();
        e.stopPropagation();
        dropZone.classList.remove('drag-over');
    });

    dropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        e.stopPropagation();
        dropZone.classList.remove('drag-over');

        const files = e.dataTransfer.files;
        if (files.length > 0) {
            handleFile(files[0]);
        }
    });

    function handleFileSelect(e) {
        const file = e.target.files[0];
        if (file) {
            handleFile(file);
        }
    }

    function handleFile(file) {
        // Validate file type
        if (!file.type.startsWith('image/')) {
            alert('Please upload an image file');
            return;
        }

        // Create preview if needed
        const reader = new FileReader();
        reader.onload = (e) => {
            // Here we would typically:
            // 1. Display the image preview
            // 2. Enable image processing controls
            // 3. Update UI to show image is loaded
            console.log('Image loaded:', file.name);
            
            // Move to Image Size tab automatically
            tabs[1].click(); // Activate the second tab (Image Size)
        };
        reader.readAsDataURL(file);
    }

    // Image Scale Controls
    const scaleButtons = document.querySelectorAll('.scale-buttons button');
    let currentScale = 100;

    scaleButtons.forEach(button => {
        button.addEventListener('click', () => {
            const isIncrease = button.textContent === '+';
            if (isIncrease && currentScale < 400) {
                currentScale += 25;
            } else if (!isIncrease && currentScale > 25) {
                currentScale -= 25;
            }
            updateScale();
        });
    });

    function updateScale() {
        const scaleDisplay = document.querySelector('.scale-buttons span');
        if (scaleDisplay) {
            scaleDisplay.textContent = `${currentScale}%`;
        }
    }

    // Input validation for numeric fields
    const numericInputs = document.querySelectorAll('input[type="number"]');
    numericInputs.forEach(input => {
        input.addEventListener('input', (e) => {
            const value = parseFloat(e.target.value);
            if (value < 0) {
                e.target.value = 0;
            }
        });
    });

    // Unit conversion (inches to centimeters and vice versa)
    const unitSelector = document.querySelector('.unit-selector select');
    const widthInput = document.querySelector('input[placeholder="Width"]');
    const heightInput = document.querySelector('input[placeholder="Height"]');

    unitSelector?.addEventListener('change', () => {
        const isCentimeters = unitSelector.value === 'Centimeters';
        const widthLabel = document.querySelector('label[for="width"]');
        const heightLabel = document.querySelector('label[for="height"]');

        if (widthLabel && heightLabel) {
            widthLabel.textContent = `Width (${isCentimeters ? 'cm' : 'inches'}):`;
            heightLabel.textContent = `Height (${isCentimeters ? 'cm' : 'inches'}):`;
        }

        // Convert values if they exist
        if (widthInput?.value) {
            widthInput.value = isCentimeters 
                ? (parseFloat(widthInput.value) * 2.54).toFixed(2)
                : (parseFloat(widthInput.value) / 2.54).toFixed(2);
        }
        if (heightInput?.value) {
            heightInput.value = isCentimeters
                ? (parseFloat(heightInput.value) * 2.54).toFixed(2)
                : (parseFloat(heightInput.value) / 2.54).toFixed(2);
        }
    });
});
