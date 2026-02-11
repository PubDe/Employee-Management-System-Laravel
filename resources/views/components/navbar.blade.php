<nav class="bg-blue-300 p-2 container mx-auto flex items-center justify-between">
    <div>
        <div class="hidden md:block text-xl font-bold text-gray-800 mb-1">
            Employee Managment System
        </div>
    </div>
    <div class="flex px-1">
        @auth
            <!-- Home Link -->
            @if (!Request::is('dashboard'))
            <a href="/dashboard"
            class="bg-white text-gray hover:bg-blue-600 hover:text-white px-3 py-1 rounded transition mx-1 font-medium">
                Goto Home
            </a>
            @endif

            <!-- Logout Form -->
            <form method="POST" action="/logout" class="inline">
                @csrf
                <button type="submit"
                        class="bg-blue-600 text-white hover:bg-blue-700 px-3 py-1 rounded transition mx-1 font-medium">
                    Logout
                </button>
            </form>
        @endauth
    </div>
</nav>
