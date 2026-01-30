@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<head>
    <meta charset="UTF-8">
    <title>Dashboard Peserta</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex items-center justify-center min-h-screen bg-gradient-to-br from-blue-100 to-blue-200">

    <div class="w-full max-w-md p-8 text-center bg-white shadow-lg rounded-xl">

        <div class="mb-4">
            <div class="flex items-center justify-center w-16 h-16 mx-auto text-2xl font-bold text-white bg-blue-600 rounded-full">
                {{ strtoupper(substr(auth()->user()->username, 0, 1)) }}
            </div>
        </div>

        <h1 class="mb-1 text-2xl font-bold text-gray-800">
            Dashboard Peserta
        </h1>

        <p class="mb-6 text-gray-500">
            Selamat datang,
            <span class="font-semibold text-gray-700">
                {{ auth()->user()->username }}
            </span>
        </p>

        <div class="p-4 mb-6 text-sm text-blue-700 border border-blue-200 rounded-lg bg-blue-50">
            Kamu berhasil login sebagai <strong>Peserta</strong>.
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button
                type="submit"
                class="w-full py-2 font-semibold text-white transition bg-red-600 rounded-lg hover:bg-red-700"
            >
                Logout
            </button>
        </form>

    </div>

</body>
</html>
