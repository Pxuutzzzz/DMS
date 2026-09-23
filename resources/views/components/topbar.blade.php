<header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6 shrink-0 shadow-sm z-10">
    
    <!-- Left: Global Search -->
    <div class="flex-1 flex">
        <form class="w-full max-w-lg relative" action="{{ route('documents.index') }}" method="GET">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <input name="search" type="search" value="{{ request('search') }}" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg leading-5 bg-gray-50 placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-shadow" placeholder="Cari dokumen, kategori, atau kata kunci...">
        </form>
    </div>

    <!-- Right: Notif & User Menu -->
    <div class="ml-4 flex items-center space-x-4">
        
        <!-- Notifications -->
        <button class="p-1.5 rounded-full text-gray-500 hover:text-blue-500 hover:bg-blue-50 focus:outline-none transition-colors relative">
            <span class="sr-only">View notifications</span>
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
            </svg>
            <!-- Badge (Dummy for now) -->
            <span class="absolute top-1 right-1 block h-2 w-2 rounded-full bg-red-500 ring-2 ring-white"></span>
        </button>

        <!-- User Dropdown (Alpine.js) -->
        <div class="relative" x-data="{ open: false }" @click.outside="open = false">
            <button @click="open = !open" class="flex items-center space-x-3 focus:outline-none">
                <!-- Avatar -->
                <div class="h-9 w-9 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold overflow-hidden shadow-sm">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <!-- Info -->
                <div class="hidden md:block text-left">
                    <div class="text-sm font-semibold text-gray-700 leading-tight">{{ auth()->user()->name }}</div>
                    <div class="text-xs text-gray-500 leading-tight mt-0.5">{{ auth()->user()->role_label }}</div>
                </div>
                <svg class="h-4 w-4 text-gray-400 hidden md:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>

            <!-- Dropdown Menu -->
            <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50" style="display: none;">
                
                <div class="px-4 py-2 border-b border-gray-100 md:hidden">
                    <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                </div>

                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-blue-600">Profile Settings</a>
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 hover:text-red-700">
                        Sign out
                    </button>
                </form>
            </div>
        </div>

    </div>
</header>
