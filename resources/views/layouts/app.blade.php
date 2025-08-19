<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="max-w-7xl mx-auto p-4">
        <nav class="flex justify-between items-center">
            <a href="{{ route('dashboard') }}" class="text-2xl font-bold text-gray-700">Puskesmas</a>
            <div class="flex items-center space-x-4">
                <!-- Jika user sudah login, tampilkan tombol logout, jika tidak tampilkan tombol login dan register -->
                @auth
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-red-500 text-white py-2 px-4 rounded">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-500">Login</a>
                    <a href="{{ route('register') }}" class="text-white bg-blue-500 hover:bg-blue-700 px-4 py-2 rounded">Register</a>
                @endauth
            </div>
        </nav>

        <main>
            @yield('content')
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
