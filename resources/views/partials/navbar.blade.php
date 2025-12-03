<nav class="bg-gradient-to-r from-blue-600 to-indigo-700 shadow-lg fixed top-0 w-full z-50">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center h-16">
            <a href="{{ route('home') }}" class="text-white font-bold text-xl">MyBank</a>

            <div class="flex items-center space-x-6">
                @auth
                    <a href="{{ route('dashboard.index') }}" class="text-white hover:text-blue-200">Dashboard</a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-white hover:text-red-300">Chiqish</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-white hover:text-blue-200">Kirish</a>
                    <a href="{{ route('register') }}" class="bg-white text-blue-600 px-4 py-2 rounded-lg hover:bg-gray-100">Ro'yxatdan o'tish</a>
                @endauth
            </div>
        </div>
    </div>
</nav>
<div class="h-16"></div> <!-- navbar bo'sh joyi -->
