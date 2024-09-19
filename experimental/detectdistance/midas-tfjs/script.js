async function loadTFLiteModel() {
    try {
        const modelUrl = 'midas.tflite'; // Replace with the actual URL or path to your TFLite model
        await tflite.setWasmPath('https://cdn.jsdelivr.net/npm/@tensorflow/tfjs-tflite@0.0.1-alpha.10/wasm/');
        const model = await tflite.loadTFLiteModel(modelUrl);
        console.log('Model loaded successfully');
        return model;
    } catch (error) {
        console.error('Error loading TFLite model:', error);
    }
}

function preprocessImage(imageElement) {
    const tensor = tf.browser.fromPixels(imageElement).toFloat();
    const resized = tf.image.resizeBilinear(tensor, [256, 256]); // Resize to 256x256 as required by the model
    const normalized = resized.div(255.0).expandDims(0); // Normalize to [0,1] and add batch dimension
    return normalized;
}

async function predictDepth(model, preprocessedImage) {
    const depthMap = model.predict(preprocessedImage);
    const squeezed = depthMap.squeeze(); // Remove batch dimension
    const normalizedDepthMap = squeezed.div(squeezed.max()).mul(255).toInt(); // Normalize the depth map to [0,255]
    return normalizedDepthMap;
}

function renderDepthMap(depthMap, canvasElement) {
    const [height, width] = [depthMap.shape[0], depthMap.shape[1]];
    const imageData = new ImageData(width, height);
    const data = depthMap.dataSync();

    for (let i = 0; i < data.length; i++) {
        const value = data[i];
        imageData.data[4 * i] = value; // R
        imageData.data[4 * i + 1] = value; // G
        imageData.data[4 * i + 2] = value; // B
        imageData.data[4 * i + 3] = 255; // A
    }

    const ctx = canvasElement.getContext('2d');
    canvasElement.width = width;
    canvasElement.height = height;
    ctx.putImageData(imageData, 0, 0);
}

function analyzeDepth(depthMap) {
    const depthArray = depthMap.dataSync();
    const averageDepth = depthArray.reduce((a, b) => a + b, 0) / depthArray.length;
    document.getElementById('averageDepth').innerText = 'Average Depth: ' + averageDepth.toFixed(2);
    return averageDepth;
}

async function startCamera() {
    const video = document.getElementById('video');
    const stream = await navigator.mediaDevices.getUserMedia({ video: true });
    video.srcObject = stream;

    const model = await loadTFLiteModel();
    const canvas = document.getElementById('canvas');

    const processFrame = async () => {
        const preprocessedImage = preprocessImage(video);
        const depthMap = await predictDepth(model, preprocessedImage);
        renderDepthMap(depthMap, canvas);
        analyzeDepth(depthMap);
        requestAnimationFrame(processFrame);
    };

    video.addEventListener('loadeddata', processFrame);
}

startCamera();
