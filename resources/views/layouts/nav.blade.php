<nav class="bg-blue-300 rounded-b-2xl border-gray-200" x-data="{ open: false }">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-2 md:p-4">
        <a href="{{ route('home') }}" class="flex items-center space-x-2 md:space-x-3 rtl:space-x-reverse">
            <img src="{{ asset('img/logo.jpeg') }}" class="h-10 md:h-12 rounded-full" alt="Comedor Logo" />
            <span class="self-center text-lg md:text-xl font-semibold whitespace-nowrap text-white">Comedores De la Fuente</span>
        </a>
        <button @click="open = !open" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-400 rounded-lg md:hidden hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-gray-600" aria-controls="navbar-default" aria-expanded="false">
            <span class="sr-only">Open main menu</span>
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15" />
            </svg>
        </button>
        <div :class="{ 'block': open, 'hidden': !open }" class="hidden w-full md:block md:w-auto" id="navbar-default">
            <ul class="font-medium flex flex-col p-4 md:p-0 mt-4 border border-gray-700 rounded-lg bg-blue-300 md:flex-row md:space-x-6 md:mt-0 md:border-0">
                <li>
                    <a href="{{ route('home') }}" class="block py-2 px-3 rounded {{ request()->routeIs('home') ? 'text-white bg-blue-200 md:bg-transparent md:text-blue-500' : 'text-white hover:bg-gray-400 md:hover:bg-transparent md:border-0 md:hover:text-blue-500' }}" aria-current="{{ request()->routeIs('home') ? 'page' : '' }}">Home</a>
                </li>
                <li>
                    <a href="{{ route('menu') }}" class="block py-2 px-3 rounded {{ request()->routeIs('menu') ? 'text-white bg-blue-200 md:bg-transparent md:text-blue-500' : 'text-white hover:bg-gray-400 md:hover:bg-transparent md:border-0 md:hover:text-blue-500' }}">Menu</a>
                </li>
                <li>
                    <a href="{{ route(auth()->check() ? 'inventory' : 'login') }}" 
                        class="block py-2 px-3 rounded {{ request()->routeIs('inventory') ? 'text-white bg-blue-200 md:bg-transparent md:text-blue-500' : 'text-white hover:bg-gray-400 md:hover:bg-transparent md:border-0 md:hover:text-blue-500' }}">
                        {{ auth()->check() ? 'Inventario' : 'Login' }}
                     </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
