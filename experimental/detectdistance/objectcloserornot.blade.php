@extends('layouts.auth')

@section('pageCss')
<link rel="stylesheet" href="{{ asset('assets/css/bootstrap2.min.css') }}">
<style>
    #camera-box {
        margin-top: 20px;
    }
    #preview-image {
        width: 100%;
        max-height: 300px;
        object-fit: cover;
        margin-top: 10px;
    }
    #camera-container {
        position: relative;
        margin-bottom: 20px;
    }
    #video {
        width: 100%;
        height: auto;
        border: 2px solid #007bff;
        border-radius: 5px;
    }
    #capture-button {
        background-color: #007bff;
        color: white;
        border: none;
        padding: 10px 15px;
        border-radius: 5px;
        cursor: pointer;
        margin-top: 10px;
    }
    #capture-button:hover {
        background-color: #0056b3;
    }
</style>
@endsection

@section("page-title", "Capture Image and Location")

@section('content')
<div class="container">
    <div class="col-md-6 col-md-offset-3">
        @if (Session::has("error"))
            <div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{Session::get("error")}}
            </div>
        @endif
        @if (Session::has("success"))
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{Session::get("success")}}
            </div>
        @endif
        <div class="panel panel-primary" id="camera-box">
            <div class="panel-heading">
                <h3 class="panel-title">Capture Image and Location</h3>
            </div>
            <div class="panel-body">
                <p><strong>Consumer No:</strong> {{ $consumer_no }}</p>
                <p><strong>Phone Number:</strong> {{ $phone_number }}</p>
                <p><strong>Year-Month:</strong> {{ $yearMonth }}</p>

                <!-- Form to submit image and location data -->
                {!! Form::open(['route' => 'camera-store', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'imageForm']) !!}
                    <!-- Hidden inputs -->
                    <input type="hidden" name="consumer_no" value="{{ $consumer_no }}">
                    <input type="hidden" name="phone_number" value="{{ $phone_number }}">
                    <input type="hidden" name="yearMonth" value="{{ $yearMonth }}">
                    <input type="file" name="image" id="imageFile" style="display:none;">

                    <!-- Camera and Image Capture -->
                    <div class="form-group">
                        <label for="camera">Capture Image</label>
                        <div id="camera-container">
                            <video id="video" autoplay></video>
                            <canvas id="canvas" style="display:none;"></canvas>
                            <img id="preview-image" src="" alt="Image Preview" style="display:none;">
                        </div>
                        <!-- Capture Button Moved Outside -->
                        <button type="button" id="capture-button">Capture</button>
                    </div>

                    <!-- Longitude and Latitude -->
                    <div class="form-group">
                        <label for="longitude">Longitude</label>
                        <input type="text" name="longitude" id="longitude" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="latitude">Latitude</label>
                        <input type="text" name="latitude" id="latitude" class="form-control" readonly>
                    </div>

                    <!-- Capture Location Button -->
                    <div class="form-group">
                        <button type="button" class="btn btn-sm btn-primary" id="captureLocationButton">Capture Location</button>
                    </div>

                    <!-- Submit Button -->
                    <div class="form-group">
                        <button type="submit" class="btn btn-sm btn-success" id="submitButton">Submit</button>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection

@section('pageScript')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Show the SweetAlert2 popup with instructions
        Swal.fire({
            title: 'How to Scan the Meter',
            html: `
                <p>1. Point your camera at the meter.</p>
                <p>2. Ensure the entire meter is visible in the frame.</p>
                <p>3. Tap the <strong>Capture</strong> button to take a picture.</p>
                <p>4. Optionally, tap the <strong>Capture Location</strong> button to save your location.</p>
                <p><em>Ensure the meter reading is clearly visible for an accurate scan.</em></p>
            `,
            imageUrl: 'https://media2.giphy.com/media/v1.Y2lkPTc5MGI3NjExNXlncWtpMnNoaWtxOGZqZzZxN3p0dW55YXhrN3Blc2x0aDEzcXVjayZlcD12MV9pbnRlcm5hbF9naWZfYnlfaWQmY3Q9Zw/taVCVuunNzQjBKTrYn/giphy.webp', // Default animation
            imageWidth: '100%',
            imageHeight: 'auto',
            imageAlt: 'Animation',
            confirmButtonText: 'Got It!',
            confirmButtonColor: '#007bff',
            // Responsive styles
            customClass: {
                container: 'swal2-container',
                popup: 'swal2-popup',
                title: 'swal2-title',
                content: 'swal2-content',
                confirmButton: 'swal2-confirm'
            },
            width: '90%', // Responsive width
            padding: '1.25rem'
        });

        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const previewImage = document.getElementById('preview-image');
        const captureButton = document.getElementById('capture-button');
        const captureLocationButton = document.getElementById('captureLocationButton');
        const longitudeInput = document.getElementById('longitude');
        const latitudeInput = document.getElementById('latitude');
        const imageFileInput = document.getElementById('imageFile');
        const imageForm = document.getElementById('imageForm');

        // Function to check if the device is mobile
        function isMobileDevice() {
            return /Mobi|Android/i.test(navigator.userAgent);
        }

        // Access the device camera
        navigator.mediaDevices.getUserMedia({
            video: {
                facingMode: isMobileDevice() ? { exact: "environment" } : "user"
            }
        })
        .then(stream => {
            video.srcObject = stream;
        })
        .catch(error => {
            alert('Error accessing the camera: ' + error.message);
        });

        // Function to check if the meter is too far based on image size
        function isMeterTooFar(canvas, threshold = 100) { // Lowered the threshold
            const width = canvas.width;
            const height = canvas.height;
            const context = canvas.getContext('2d');
            const imageDataArray = context.getImageData(0, 0, width, height).data;

            let totalBrightness = 0;
            for (let i = 0; i < imageDataArray.length; i += 4) {
                const r = imageDataArray[i];
                const g = imageDataArray[i + 1];
                const b = imageDataArray[i + 2];
                const brightness = 0.299 * r + 0.587 * g + 0.114 * b;
                totalBrightness += brightness;
            }

            const averageBrightness = totalBrightness / (width * height);

            console.log("Average Brightness:", averageBrightness); // Log the brightness value for debugging

            return averageBrightness < threshold;
        }

        // Capture the image from the video stream
        captureButton.addEventListener('click', function () {
            const context = canvas.getContext('2d');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            context.drawImage(video, 0, 0, canvas.width, canvas.height);

            // Check if the image might be too far
            if (isMeterTooFar(canvas)) {
                Swal.fire({
                    title: 'Warning',
                    text: 'The meter might be too far away. Please move closer and try again.',
                    icon: 'warning',
                    confirmButtonColor: '#007bff',
                    confirmButtonText: 'OK'
                });
            } else {
                previewImage.src = canvas.toDataURL('image/png');
                previewImage.style.display = 'block';

                // Convert canvas to Blob and create a file
                canvas.toBlob(function(blob) {
                    const file = new File([blob], "captured_image.png", { type: "image/png" });
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    imageFileInput.files = dataTransfer.files; // Set the file input's files
                }, 'image/png');
            }
        });

        // Capture location using geolocation API
        captureLocationButton.addEventListener('click', function () {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    latitudeInput.value = position.coords.latitude;
                    longitudeInput.value = position.coords.longitude;
                    Swal.fire({
                        title: 'Location Captured',
                        text: `Latitude: ${position.coords.latitude}, Longitude: ${position.coords.longitude}`,
                        icon: 'success',
                        confirmButtonColor: '#007bff',
                        confirmButtonText: 'OK'
                    });
                }, function (error) {
                    Swal.fire({
                        title: 'Error',
                        text: `Failed to capture location: ${error.message}`,
                        icon: 'error',
                        confirmButtonColor: '#007bff',
                        confirmButtonText: 'OK'
                    });
                });
            } else {
                Swal.fire({
                    title: 'Error',
                    text: 'Geolocation is not supported by this browser.',
                    icon: 'error',
                    confirmButtonColor: '#007bff',
                    confirmButtonText: 'OK'
                });
            }
        });

        // Form submission validation
        imageForm.addEventListener('submit', function (e) {
            if (!imageFileInput.files.length || !latitudeInput.value || !longitudeInput.value) {
                e.preventDefault();
                Swal.fire({
                    title: 'Incomplete Form',
                    text: 'Please capture both an image and location before submitting.',
                    icon: 'warning',
                    confirmButtonColor: '#007bff',
                    confirmButtonText: 'OK'
                });
            }
        });
    });
</script>
@endsection
