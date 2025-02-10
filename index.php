<?php
/* 
1. Complete web page using PHP using HTML5 Canvas - https://prnt.sc/ZEPu8JijfeHF
i. Draw a Preview (Left Side) using HTML5 Canvas.
ii. At right side there should be a selection to change preview:
- Give facility to change layers as per selection
Enter Size: As per size entered you can show Photo Preview accordingly ( For e.g. If you enter rectangle size then preview should look like this way - https://prnt.sc/HRmBD49gDobV )
Image / Photo layer: Here you can provide a few sample images to change like nature or choose a photo from a computer etc,.... On clicking the photo image layer can show the selected photo inside the preview.
Frame layer: Here you can show a few frames to choose. As per frame selection you can show the 3rd layer with the selected frame.
(As per screen shot you can see that 3 different images are with different layer options.)

Frame layer should be a one small piece / stick / pattern of frame (like this - https://prnt.sc/i8T7DBope6YX) and it should be a pattern over the canvas.

2. You can share a testing video where you can explain the feature and how it's working
3. You can also submit your code files. (GIThub url is also fine)
 */

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Photo Frame Preview</title>
    <style>
        .container {
            display: flex;
            gap: 20px;
        }

        .preview {
            flex: 1;
        }

        .controls {
            flex: 1;
        }

        .thumbnail {
            width: 100px;
            height: 70px;
            cursor: pointer;
            border: 2px solid transparent;
        }

        .thumbnail.selected {
            border-color: blue;
        }

        .frame-option {
            width: 80px;
            height: 80px;
            cursor: pointer;
            border: 2px solid transparent;
            background-color: #f5f5f5;
            padding: 5px;
            margin: 5px;
        }

        .frame-option.selected {
            border-color: blue;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="preview">
            <canvas id="previewCanvas"></canvas>
        </div>

        <div class="controls">
            <div class="size-controls">
                <h3>Step 1 - Enter your Photo Width x Height:</h3>
                <input type="number" id="width" placeholder="Width" value="600">
                x
                <input type="number" id="height" placeholder="Height" value="400">
            </div>

            <div class="photo-controls">
                <h3>Step 2 - Choose Your Photo or Upload your own Photo:</h3>
                <div id="samplePhotos">
                    <img src="samples/nature1.jpg" class="thumbnail" onclick="selectImage(this)">
                    <img src="samples/nature2.jpg" class="thumbnail" onclick="selectImage(this)">
                    <img src="samples/nature3.jpg" class="thumbnail" onclick="selectImage(this)">
                    <!--  sample images -->
                </div>
                <input type="file" id="uploadPhoto" accept="image/*" onchange="handleUpload(this)">
            </div>

            <div class="frame-controls">
                <h3>Step 3 - Choose your Photo Frame:</h3>
                <div id="frameOptions">
                    <img src="frames/frame1.png" class="frame-option" onclick="selectFrame(this)">
                    <img src="frames/frame2.png" class="frame-option" onclick="selectFrame(this)">
                    <img src="frames/frame3.png" class="frame-option" onclick="selectFrame(this)">
                    <!--  frame options -->
                </div>
            </div>
        </div>
    </div>

    <script>
        const canvas = document.getElementById('previewCanvas');
        const ctx = canvas.getContext('2d');
        let currentImage = null;
        let currentFrame = null;

        // Initialize canvas size
        function initCanvas() {
            const width = document.getElementById('width').value;
            const height = document.getElementById('height').value;
            canvas.width = parseInt(width);
            canvas.height = parseInt(height);
            drawPreview();
        }

        // Handle image selection
        function selectImage(img) {
            document.querySelectorAll('.thumbnail').forEach(el => el.classList.remove('selected'));
            img.classList.add('selected');
            currentImage = img;
            drawPreview();
        }

        // Handle frame selection
        function selectFrame(frame) {
            document.querySelectorAll('.frame-option').forEach(el => el.classList.remove('selected'));
            frame.classList.add('selected');
            currentFrame = frame;
            drawPreview();
        }

        // Handle file upload
        function handleUpload(input) {
            const file = input.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = new Image();
                    img.onload = function() {
                        currentImage = img;
                        drawPreview();
                    }
                    img.src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        }

        // Draw the preview
        function drawPreview() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);

            // Draw background
            ctx.fillStyle = '#FFF';
            ctx.fillRect(0, 0, canvas.width, canvas.height);

            // Draw image if selected
            if (currentImage) {
                ctx.drawImage(currentImage, 0, 0, canvas.width, canvas.height);
            }

            // Draw frame if selected
            if (currentFrame) {
                const framePattern = ctx.createPattern(currentFrame, 'repeat');
                ctx.strokeStyle = framePattern;
                ctx.lineWidth = 40; // Adjusted for better visibility
                ctx.strokeRect(0, 0, canvas.width, canvas.height);

                // Add inner stroke for better frame definition
                ctx.strokeStyle = 'rgba(0,0,0,0.1)';
                ctx.lineWidth = 1;
                ctx.strokeRect(20, 20, canvas.width - 40, canvas.height - 40);
            }
        }

        // Initialize canvas on load
        window.onload = initCanvas;

        // Update canvas when dimensions change
        document.getElementById('width').addEventListener('change', initCanvas);
        document.getElementById('height').addEventListener('change', initCanvas);
    </script>
</body>

</html>