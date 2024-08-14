<nav class="bg-blue-300 border-gray-200 rounded-b-2xl" x-data="{ open: false }">
    <div class="flex flex-wrap items-center justify-between max-w-screen-xl p-2 md:p-4 mx-auto">
        <a href="{{ route('home') }}" class="flex items-center space-x-2 md:space-x-3 rtl:space-x-reverse">
            <img src="{{ asset('img/logo.jpeg') }}" class="h-10 md:h-12 rounded-full" alt="Comedor Logo" />
            <span class="self-center text-lg md:text-xl font-semibold text-white whitespace-nowrap">Comedores De la Fuente</span>
        </a>
        <button @click="open = !open" class="inline-flex items-center justify-center w-10 h-10 p-2 text-sm text-gray-400 rounded-lg md:hidden hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-gray-600" aria-controls="navbar-default" aria-expanded="false">
            <span class="sr-only">Open main menu</span>
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15" />
            </svg>
        </button>
        <div :class="{ 'block': open, 'hidden': !open }" class="hidden w-full md:block md:w-auto" id="navbar-default">
            <ul class="flex flex-col p-4 mt-4 font-medium bg-blue-300 border border-gray-700 rounded-lg md:p-0 md:flex-row md:space-x-6 rtl:space-x-reverse md:mt-0 md:border-0">
                <li>
                    <a href="{{ route('enterprises.create') }}" class="block py-2 px-3 rounded {{ request()->routeIs('enterprise') ? 'text-white bg-blue-200 md:bg-transparent md:text-blue-500' : 'text-white hover:bg-gray-400 md:hover:bg-transparent md:border-0 md:hover:text-blue-500' }}">Empresas</a>
                </li>
                <li>
                    <a href="{{ route('customers.create') }}" class="block py-2 px-3 rounded {{ request()->routeIs('customers') ? 'text-white bg-blue-200 md:bg-transparent md:text-blue-500' : 'text-white hover:bg-gray-400 md:hover:bg-transparent md:border-0 md:hover:text-blue-500' }}">Trabajadores</a>
                </li>
                <li>
                    <a href="{{ route('feedback.index') }}" class="block py-2 px-3 rounded {{ request()->routeIs('feedback') ? 'text-white bg-blue-200 md:bg-transparent md:text-blue-500' : 'text-white hover:bg-gray-400 md:hover:bg-transparent md:border-0 md:hover:text-blue-500' }}">Comentarios</a>
                </li>
                <li>
                    <a href="{{ route('sales.history') }}" class="block py-2 px-3 rounded {{ request()->routeIs('salehistory') ? 'text-white bg-blue-200 md:bg-transparent md:text-blue-500' : 'text-white hover:bg-gray-400 md:hover:bg-transparent md:border-0 md:hover:text-blue-500' }}">Historial de Ventas</a>
                </li>
                <li>
                    <a href="{{ route('inventory') }}" class="block py-2 px-3 rounded {{ request()->routeIs('inventory') ? 'text-white bg-blue-200 md:bg-transparent md:text-blue-500' : 'text-white hover:bg-gray-400 md:hover:bg-transparent md:border-0 md:hover:text-blue-500' }}" aria-current="{{ request()->routeIs('inventory') ? 'page' : '' }}">Volver</a>
                </li>
                <li>
                    <a href="{{ route('logout') }}" class="block py-2 px-3 rounded {{ request()->routeIs('logout') ? 'text-white bg-blue-200 md:bg-transparent md:text-blue-500' : 'text-white hover:bg-gray-400 md:hover:bg-transparent md:border-0 md:hover:text-blue-500' }}">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
