<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'My Laravel App')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/heroicons@2.0.11/outline/index.min.js"></script>
</head>

<body class="bg-gray-100">
    <nav class="bg-indigo-600 p-4 text-white">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <a href="{{ route('posts.index') }}" class="text-xl font-semibold">Blog</a>

            <div class="space-x-4 flex items-center">
                <a href="{{ route('posts.create') }}" class="text-white hover:text-gray-300">Post Blog</a>
                <a href="{{ route('posts.index') }}" class="text-white hover:text-gray-300">Show Blogs</a>

                @auth
                    <div class="flex justify-end items-center">
                        <span class="text-white cursor-pointer" id="user-name" onclick="toggleLogout()">Hi,
                            {{ Auth::user()->name }}</span>

                        <div id="logout-form" class="hidden ml-4">
                            <form action="{{ route('logout') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-white hover:text-gray-300">Logout</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-white hover:text-gray-300">Login</a>
                    <a href="{{ route('register') }}" class="text-white hover:text-gray-300">Register</a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="container mx-auto py-8">
        @yield('content')
    </div>
</body>
<script>
    function toggleLogout() {
        var logoutForm = document.getElementById('logout-form');
        logoutForm.classList.toggle('hidden');
    }
</script>

</html>
