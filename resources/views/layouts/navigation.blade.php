@php
    $user = Auth::user();
    $isAdmin = $user?->hasRole('Admin') ?? false;
    $menuItems = [
        ['label' => 'Dasbor', 'permission' => 'view dashboard', 'route' => 'dashboard', 'icon' => 'grid'],
        ['label' => 'Inventaris', 'permission' => 'view inventory', 'route' => 'inventory.index', 'icon' => 'box'],
        ['label' => 'Produk', 'permission' => 'view products', 'icon' => 'tag'],
        ['label' => 'Kategori', 'permission' => 'view categories', 'route' => 'categories.index', 'icon' => 'layers'],
        ['label' => 'Pemasok', 'permission' => 'view suppliers', 'icon' => 'building'],
        ['label' => 'Satuan', 'permission' => 'view units', 'icon' => 'scale'],
        ['label' => 'Gudang', 'permission' => 'view warehouses', 'route' => 'warehouses.index', 'icon' => 'home'],
        ['label' => 'Transaksi', 'permission' => 'view transactions', 'icon' => 'arrows'],
        ['label' => 'Permintaan Material', 'permission' => 'view requests', 'icon' => 'clipboard'],
        ['label' => 'Laporan', 'permission' => 'view reports', 'icon' => 'chart'],
        ['label' => 'Pengguna & Peran', 'permission' => 'view users', 'icon' => 'users'],
        ['label' => 'Log Aktivitas', 'permission' => 'view activity logs', 'icon' => 'clock'],
    ];
@endphp

<div x-cloak x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 z-40 bg-slate-950/50 backdrop-blur-sm lg:hidden" @click="sidebarOpen = false"></div>

<aside class="fixed inset-y-0 left-0 z-50 flex w-72 -translate-x-full flex-col border-r border-slate-200 bg-white transition-transform duration-300 dark:border-slate-800 dark:bg-slate-900 lg:translate-x-0"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
    <div class="flex h-16 items-center justify-between border-b border-slate-200 px-5 dark:border-slate-800">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3" @click="sidebarOpen = false">
            <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-indigo-600 text-white shadow-lg shadow-indigo-600/25">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3 7.5 12 3l9 4.5M4.5 9.5V18l7.5 3 7.5-3V9.5M12 12l7.5-3.75M12 12 4.5 8.25M12 12v9" /></svg>
            </span>
            <span><span class="block text-sm font-bold tracking-tight text-slate-900 dark:text-white">Gudang</span><span class="block text-xs font-medium text-slate-500 dark:text-slate-400">Sistem Manajemen</span></span>
        </a>
        <button type="button" @click="sidebarOpen = false" class="rounded-lg p-2 text-slate-500 hover:bg-slate-100 dark:text-slate-400 dark:hover:bg-slate-800 lg:hidden" aria-label="Tutup sidebar">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m6 6 12 12M18 6 6 18" /></svg>
        </button>
    </div>

    <nav class="flex-1 overflow-y-auto px-3 py-5" aria-label="Navigasi utama">
        <p class="px-3 pb-2 text-[11px] font-bold uppercase tracking-[0.14em] text-slate-400">Menu utama</p>
        <div class="space-y-1">
            @foreach ($menuItems as $item)
                @if ($isAdmin || $user->can($item['permission']))
                    <a href="{{ isset($item['route']) ? route($item['route']) : '#' }}" @click="sidebarOpen = false"
                        @class([
                            'group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition',
                            'bg-indigo-50 text-indigo-700 shadow-sm dark:bg-indigo-500/10 dark:text-indigo-300' => isset($item['route']) && request()->routeIs($item['route']),
                            'text-slate-600 hover:bg-slate-100 hover:text-slate-950 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-white' => ! isset($item['route']) || ! request()->routeIs($item['route']),
                        ])>
                        <span class="flex h-5 w-5 shrink-0 items-center justify-center">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8" aria-hidden="true">
                                @if ($item['icon'] === 'grid')
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 4h6v6H4zm10 0h6v6h-6zM4 14h6v6H4zm10 0h6v6h-6z" />
                                @elseif ($item['icon'] === 'box' || $item['icon'] === 'tag')
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 7.5 12 3l8 4.5v9L12 21l-8-4.5v-9ZM12 12l8-4.5M12 12 4 7.5M12 12v9" />
                                @elseif ($item['icon'] === 'building' || $item['icon'] === 'home')
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 21h18M4.5 21V9l7.5-6 7.5 6v12M9 21v-6h6v6M8 10.5h.01M12 10.5h.01M16 10.5h.01" />
                                @elseif ($item['icon'] === 'arrows')
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h12m0 0-3-3m3 3-3 3m0 6H7m0 0 3 3m-3-3 3-3" />
                                @elseif ($item['icon'] === 'users')
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6.75a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.25a7.5 7.5 0 0 1 15 0" />
                                @elseif ($item['icon'] === 'chart')
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5v-6m5 6v-15m5 15v-9m5 9v-12" />
                                @elseif ($item['icon'] === 'clock')
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75v5.5l3.5 2.25M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                @else
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5.25h6M9 3h6a1.5 1.5 0 0 1 1.5 1.5V6H18a1.5 1.5 0 0 1 1.5 1.5v12A1.5 1.5 0 0 1 18 21H6a1.5 1.5 0 0 1-1.5-1.5v-12A1.5 1.5 0 0 1 6 6h1.5V4.5A1.5 1.5 0 0 1 9 3Z" />
                                @endif
                            </svg>
                        </span>
                        <span>{{ $item['label'] }}</span>
                    </a>
                @endif
            @endforeach
        </div>
    </nav>

    <div class="m-3 rounded-2xl bg-slate-50 p-3 dark:bg-slate-800/80">
        <div class="flex items-center gap-3"><span class="flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-100 text-emerald-600 dark:bg-emerald-500/15 dark:text-emerald-300"><svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m9 12 2 2 4-4m5.4 2a9 9 0 1 1-2.7-6.4" /></svg></span><div><p class="text-xs font-semibold text-slate-800 dark:text-white">Sistem beroperasi normal</p><p class="text-xs text-slate-500 dark:text-slate-400">Semua layanan berjalan</p></div></div>
    </div>
</aside>

<header class="fixed inset-x-0 top-0 z-30 h-16 border-b border-slate-200 bg-white/90 backdrop-blur-xl dark:border-slate-800 dark:bg-slate-950/90 lg:left-72">
    <div class="flex h-full items-center justify-between gap-4 px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-3">
            <button type="button" @click="sidebarOpen = true" class="rounded-lg p-2 text-slate-500 hover:bg-slate-100 dark:text-slate-400 dark:hover:bg-slate-800 lg:hidden" aria-label="Buka sidebar"><svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" /></svg></button>
            <div><p class="text-sm font-semibold text-slate-900 dark:text-white">Dasbor</p><p class="hidden text-xs text-slate-500 sm:block">{{ now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</p></div>
        </div>
        <div class="flex items-center gap-2 sm:gap-3">
            <button type="button" @click="darkMode = !darkMode" class="rounded-xl border border-slate-200 p-2 text-slate-500 hover:bg-slate-100 dark:border-slate-700 dark:text-slate-400 dark:hover:bg-slate-800" aria-label="Ubah mode gelap">
                <svg x-show="!darkMode" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1.5m0 15V21m9-9h-1.5M4.5 12H3m15.4 6.4-1.1-1.1M6.7 6.7 5.6 5.6m12.8 0-1.1 1.1M6.7 17.3l-1.1 1.1M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" /></svg>
                <svg x-cloak x-show="darkMode" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 15.75A9 9 0 0 1 8.25 2.25 9 9 0 1 0 21.75 15.75Z" /></svg>
            </button>
            <div class="relative" @click.outside="profileOpen = false">
                <button type="button" @click="profileOpen = !profileOpen" class="flex items-center gap-2 rounded-xl py-1 pl-1 pr-2 text-left hover:bg-slate-100 dark:hover:bg-slate-800 sm:gap-3 sm:pr-3" :aria-expanded="profileOpen.toString()">
                    <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-indigo-100 text-xs font-bold text-indigo-700 dark:bg-indigo-500/20 dark:text-indigo-300">{{ mb_strtoupper(mb_substr($user->name, 0, 1)) }}</span>
                    <span class="hidden sm:block"><span class="block max-w-32 truncate text-sm font-semibold text-slate-700 dark:text-slate-200">{{ $user->name }}</span><span class="block text-xs text-slate-500 dark:text-slate-400">{{ $user->getRoleNames()->first() ?? 'Anggota tim' }}</span></span>
                    <svg class="hidden h-4 w-4 text-slate-400 sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6" /></svg>
                </button>
                <div x-cloak x-show="profileOpen" x-transition.origin.top.right class="absolute right-0 mt-2 w-56 overflow-hidden rounded-2xl border border-slate-200 bg-white p-1 shadow-xl shadow-slate-900/10 dark:border-slate-700 dark:bg-slate-800 dark:shadow-black/30">
                    <div class="border-b border-slate-100 px-3 py-2.5 dark:border-slate-700"><p class="truncate text-sm font-semibold text-slate-800 dark:text-white">{{ $user->name }}</p><p class="truncate text-xs text-slate-500 dark:text-slate-400">{{ $user->email }}</p></div>
                    <a href="{{ route('profile.edit') }}" class="mt-1 flex items-center gap-2 rounded-xl px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-950 dark:text-slate-300 dark:hover:bg-slate-700 dark:hover:text-white"><svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6.75a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.25a7.5 7.5 0 0 1 15 0" /></svg>Pengaturan profil</a>
                    <form method="POST" action="{{ route('logout') }}">@csrf <button type="submit" class="flex w-full items-center gap-2 rounded-xl px-3 py-2 text-sm font-medium text-rose-600 hover:bg-rose-50 dark:text-rose-400 dark:hover:bg-rose-500/10"><svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6A2.25 2.25 0 0 0 5.25 5.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m-3-3h8.25m0 0-3-3m3 3-3 3" /></svg>Keluar</button></form>
                </div>
            </div>
        </div>
    </div>
</header>