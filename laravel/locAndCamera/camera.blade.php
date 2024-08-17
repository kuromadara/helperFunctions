<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Camera Capture</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex justify-center items-center h-screen">
    <div class="bg-white shadow-md rounded-lg p-8 w-full max-w-md">
        <h1 class="text-2xl font-bold mb-4">Camera Capture</h1>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('camera.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label for="image" class="block font-medium text-gray-700 mb-2">Upload Image</label>
                <input type="file" name="image" id="image" accept="image/*" capture="camera" class="w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div>
                <label for="latitude" class="block font-medium text-gray-700 mb-2">Latitude</label>
                <input type="text" name="latitude" id="latitude" class="w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" readonly>
            </div>
            <div>
                <label for="longitude" class="block font-medium text-gray-700 mb-2">Longitude</label>
                <input type="text" name="longitude" id="longitude" class="w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" readonly>
            </div>
            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Upload</button>
        </form>
    </div>

    <script>
        // Get the user's location
        navigator.geolocation.getCurrentPosition(function(position) {
            document.getElementById('latitude').value = position.coords.latitude;
            document.getElementById('longitude').value = position.coords.longitude;
        });
    </script>
</body>
</html>
