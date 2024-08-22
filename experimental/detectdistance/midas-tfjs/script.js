async function loadTFLiteModel() {
    try {
        const modelUrl = 'midas.tflite'; // Replace with the actual URL or path to your TFLite model
        const wsamPath = await tflite.setWasmPath('https://cdn.jsdelivr.net/npm/@tensorflow/tfjs-tflite@0.0.1-alpha.10/wasm/');
        const model = await tflite.loadTFLiteModel(modelUrl);
        console.log('Model loaded successfully');
        return model;
    } catch (error) {
        console.error('Error loading TFLite model:', error);
    }
}

function preprocessImage(imageElement) {
    try {
        const tensor = tf.browser.fromPixels(imageElement).toFloat();
        const resized = tf.image.resizeBilinear(tensor, [256, 256]); // Resize to 256x256 as required by the model
        const normalized = resized.div(255.0).expandDims(0); // Normalize to [0,1] and add batch dimension
        return normalized;
    } catch (error) {
        console.error('Error during image preprocessing:', error);
    }
}


async function predictDepth(model, preprocessedImage) {
    try {
        const depthMap = model.predict(preprocessedImage);
        const squeezed = depthMap.squeeze(); // Remove batch dimension
        const normalizedDepthMap = squeezed.div(squeezed.max()).mul(255).toInt(); // Normalize the depth map to [0,255]
        return normalizedDepthMap;
    } catch (error) {
        console.error('Error during depth prediction:', error);
    }
}

function renderDepthMap(depthMap, canvasElement) {
    try {
        const [width, height] = [depthMap.shape[1], depthMap.shape[0]];
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
    } catch (error) {
        console.error('Error rendering depth map:', error);
    }
}

function analyzeDepth(depthMap) {
    try {
        const depthArray = depthMap.dataSync();
        const averageDepth = depthArray.reduce((a, b) => a + b, 0) / depthArray.length;
        console.log('Average Depth:', averageDepth)
        const threshold = 100;

        if (averageDepth > threshold) {
            alert("The object is closer!");
        } else {
            alert("The object is farther away.");
        }
    } catch (error) {
        console.error('Error analyzing depth:', error);
    }
}

document.getElementById('imageUpload').addEventListener('change', async (event) => {
    const file = event.target.files[0];
    const img = new Image();

    img.src = URL.createObjectURL(file);
    img.onload = async () => {
        try {
            const model = await loadTFLiteModel();
            if (model) {
                const preprocessedImage = preprocessImage(img);
                const depthMap = await predictDepth(model, preprocessedImage);
                console.log('Depth Map Values:', depthMap.dataSync());
                const canvas = document.getElementById('canvas');
                renderDepthMap(depthMap, canvas);
                analyzeDepth(depthMap);
            }
        } catch (error) {
            console.error('Error during image processing and analysis:', error);
        }
    };
});
