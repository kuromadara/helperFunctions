<video id="video" width="640" height="480" autoplay></video>
<button id="snap">Capture</button>
<canvas id="canvas" width="640" height="480"></canvas>

<script>
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const context = canvas.getContext('2d');
    const snapButton = document.getElementById('snap');

    // Access the camera
    navigator.mediaDevices.getUserMedia({ video: true })
        .then(stream => {
            video.srcObject = stream;
        })
        .catch(err => {
            console.log("An error occurred: " + err);
        });

    snapButton.addEventListener('click', () => {
        // Draw the video frame to the canvas
        context.drawImage(video, 0, 0, canvas.width, canvas.height);

        // Example: Get the size of the object (manually defined region for simplicity)
        // Replace with actual object detection logic.
        const objectWidth = 200; // Example width, replace with detection logic
        const objectHeight = 100; // Example height, replace with detection logic

        // Assume we have a threshold size to determine if the object is "close"
        const thresholdSize = 150;

        if (objectWidth > thresholdSize) {
            alert("The object is closer!");
        } else {
            alert("The object is farther away.");
        }
    });
</script>
