<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">

    <div class="p-6 bg-white rounded shadow">
        <h1 class="mb-4 text-2xl font-bold">Dashboard Admin</h1>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="px-4 py-2 bg-red-600 rounded text-red">
                Logout
            </button>
        </form>
    </div>

</body>
</html>
