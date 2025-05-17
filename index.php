<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ScreenTone Eternal 2.2.0: FreeSeps Edition</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="dark-theme">
    <noscript>
        ScreenTone Eternal 2.2.0: FreeSeps Edition requires JavaScript to run. Please enable JavaScript in your browser settings and reload this page.
    </noscript>

    <header class="header">
        <div class="header-content">
            <h1>ScreenTone Eternal 2.2.0: FreeSeps Edition</h1>
            <nav class="top-nav">
                <a href="#" class="nav-link">Dithermark Source Code</a>
                <a href="#" class="nav-link">ScreenTo</a>
                <a href="#" class="nav-link">Max Chroma Youtube</a>
            </nav>
        </div>
    </header>

    <main class="main-content">
        <nav class="tab-navigation">
            <button class="tab-btn active">Load Image</button>
            <button class="tab-btn">Image Size</button>
            <button class="tab-btn">Image Processing Settings</button>
            <button class="tab-btn">Preferences & Presets</button>
            <button class="tab-btn">Save & Export</button>
        </nav>

        <div class="content-area">
            <div id="load-image-section" class="section active">
                <h2 class="section-title">Load an Image to Start</h2>
                <div class="upload-area" id="dropZone">
                    <div class="upload-content">
                        <h3>Load Images</h3>
                        <div class="button-group">
                            <button class="btn primary" id="loadImageBtn">Load Image</button>
                            <button class="btn secondary">Load Custom Pattern</button>
                            <button class="btn secondary">Browse Image Packs</button>
                        </div>
                        <button class="btn text">Show Art Generator</button>
                    </div>
                </div>
                <input type="file" id="fileInput" accept="image/*" style="display: none;">
            </div>

            <div id="image-size-section" class="section">
                <div class="size-controls">
                    <div class="scale-control">
                        <h3>Image Scale:</h3>
                        <div class="scale-buttons">
                            <button class="btn icon-btn">-</button>
                            <span class="scale-value">100%</span>
                            <button class="btn icon-btn">+</button>
                        </div>
                    </div>

                    <div class="dimensions-control">
                        <h3>Physical Dimensions</h3>
                        <div class="unit-selector">
                            <label>Unit:</label>
                            <select class="select-control">
                                <option>Inches</option>
                                <option>Centimeters</option>
                            </select>
                        </div>
                        <div class="input-group">
                            <label>Width (inches):</label>
                            <input type="number" class="number-input" step="0.1" min="0">
                        </div>
                        <div class="input-group">
                            <label>Height (inches):</label>
                            <input type="number" class="number-input" step="0.1" min="0">
                        </div>
                        <div class="input-group">
                            <label>Resolution (DPI):</label>
                            <input type="number" class="number-input" min="1">
                        </div>
                    </div>

                    <div class="pixel-dimensions">
                        <h3>Pixel Dimensions</h3>
                        <div class="input-group">
                            <label>Width (px):</label>
                            <input type="number" class="number-input" min="1">
                        </div>
                        <div class="input-group">
                            <label>Height (px):</label>
                            <input type="number" class="number-input" min="1">
                        </div>
                    </div>

                    <div class="lock-mode">
                        <h3>Lock Mode:</h3>
                        <div class="radio-group">
                            <label class="radio-label">
                                <input type="radio" name="lock-mode" value="pixel">
                                Lock Pixel Dimensions
                            </label>
                            <label class="radio-label">
                                <input type="radio" name="lock-mode" value="physical">
                                Lock Physical Size
                            </label>
                            <label class="radio-label">
                                <input type="radio" name="lock-mode" value="dpi">
                                Lock DPI
                            </label>
                            <label class="radio-label">
                                <input type="radio" name="lock-mode" value="none" checked>
                                No Locks
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="assets/js/script.js"></script>
</body>
</html>
