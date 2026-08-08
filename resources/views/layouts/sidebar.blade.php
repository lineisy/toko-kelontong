<!-- ====== SIDEBAR ====== -->
<aside class="sidebar fixed top-0 left-0 h-full flex flex-col z-50 shadow-sm" id="sidebar">
    <div class="h-16 flex items-center px-5 border-b border-[var(--gray-300)]">
         <x-application-logo class="block h-9 w-auto fill-current text-[var(--primary)]" />
        <span class="text-lg font-bold brand-text">Pet<span class="text-[var(--danger)]">Shop</span></span>
        <button id="sidebar-close" class="ml-auto md:hidden text-gray-400 hover:text-gray-700 transition">
            <i class="fas fa-times text-lg"></i>
        </button>
    </div>

    <nav class="flex-1 overflow-y-auto p-4 space-y-1" id="sidebar-nav">
        <x-nav-link :href="Auth::user()->role === 'admin' ? route('admin.dashboard') : route('kasir.dashboard')" :active="request()->routeIs('admin.dashboard') || request()->routeIs('kasir.dashboard')">
            <i class="fas fa-th-large w-5 text-center text-base"></i>
            <span>{{ __('Dashboard') }}</span>
        </x-nav-link>

        <x-nav-link :href="Auth::user()->role === 'admin' ? route('admin.produk') : route('kasir.produk')" :active="request()->routeIs('admin.produk') || request()->routeIs('kasir.produk')">
            <i class="fas fa-box w-5 text-center text-base"></i>
            <span>{{ __('Produk') }}</span>
        </x-nav-link>

        <x-nav-link :href="Auth::user()->role === 'admin' ? route('admin.kategori') : route('kasir.kategori')" :active="request()->routeIs('admin.kategori') || request()->routeIs('kasir.kategori')">
            <i class="fas fa-tags w-5 text-center text-base"></i>
            <span>{{ __('Kategori') }}</span>
        </x-nav-link>

        <x-nav-link :href="Auth::user()->role === 'admin' ? route('admin.transaksi') : route('kasir.transaksi')" :active="request()->routeIs('admin.transaksi') || request()->routeIs('kasir.transaksi')">
            <i class="fas fa-receipt w-5 text-center text-base"></i>
            <span>{{ __('Transaksi') }}</span>
        </x-nav-link>

        @if(Auth::user()->role === 'admin')
            <x-nav-link :href="route('admin.laporan.transaksi')" :active="request()->routeIs('admin.laporan.transaksi')">
                <i class="fas fa-chart-line w-5 text-center text-base"></i>
                <span>{{ __('Laporan Transaksi') }}</span>
            </x-nav-link>
        @endif
    </nav>

    <div class="p-4 border-t border-[var(--gray-300)] text-center text-xs text-[var(--gray-500)]">
        v1.0 &middot; Poin Of Sale
    </div>
</aside>

<!-- Sidebar overlay for mobile -->
<div id="sidebar-overlay" class="sidebar-overlay fixed inset-0 bg-black/30 z-40 hidden md:hidden" aria-hidden="true"></div>

<!-- ====== HEADER ====== -->
<header class="main-content sticky top-0 z-30 backdrop-blur border-b border-[var(--gray-300)] h-16 flex items-center px-4 md:px-6 shadow-sm" style="background: rgba(255,252,248,0.95);">
    <button id="sidebar-toggle" class="mr-4 text-[var(--gray-500)] hover:text-[var(--primary)] transition md:hidden">
        <i class="fas fa-bars text-xl"></i>
    </button>

    <div class="flex-1 flex items-center gap-4">
        <!-- Search bar slot -->
    </div>

    <div class="flex items-center gap-1">
        <span class="hidden sm:inline text-sm text-[var(--gray-500)]">Hi, <strong class="text-[var(--gray-700)]">{{ Auth::user()->name }}</strong></span>

        <div class="hidden sm:flex sm:items-center sm:ms-6">
            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-lg text-[var(--gray-600)] bg-[var(--gray-50)] hover:text-[var(--primary)] focus:outline-none transition ease-in-out duration-150">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-[var(--primary)] to-[var(--primary-dark)] flex items-center justify-center text-white text-xs font-bold shadow">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <div class="ms-1">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <x-dropdown-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-dropdown-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-dropdown-link>
                    </form>
                </x-slot>
            </x-dropdown>
        </div>
    </div>
</header>
