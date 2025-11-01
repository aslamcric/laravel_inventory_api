<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Inventory & Billing System</title>
    <!-- You can include CSS here -->
    <!-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> -->
    <link rel="stylesheet" href="https://matcha.mizu.sh/matcha.css">
</head>

<body class="bg-gray-100 font-sans leading-normal tracking-normal">

    <!-- Header -->
    <header class="bg-blue-600 text-white p-4 shadow-md">
        <div class="container mx-auto">
            <h1 class="text-2xl font-bold">Smart Inventory & Billing System</h1>
            <p class="text-sm">Laravel API Backend</p>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto my-8 p-4 bg-white shadow-md rounded">
        <h2 class="text-xl font-semibold mb-4">Welcome to Smart Inventory API</h2>
        <p>This page is only for demonstration purposes of the Smart Inventory API.</p>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-200 text-gray-700 p-4 mt-8">
        <div class="container mx-auto text-center">
            &copy; {{ date('Y') }} DevAslam. All rights reserved.
        </div>
    </footer>

    <!-- Optional JS -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>