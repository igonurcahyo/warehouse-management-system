<x-app-layout>
    @php
        $metrics = [
            ['label' => 'Total Produk', 'value' => '1,248', 'change' => '+8,2% dari bulan lalu', 'tone' => 'indigo', 'icon' => 'cube'],
            ['label' => 'Total Stok', 'value' => '18,540', 'change' => '+12,5% dari bulan lalu', 'tone' => 'sky', 'icon' => 'chart'],
            ['label' => 'Stok Menipis', 'value' => '24', 'change' => 'Memerlukan perhatian Anda', 'tone' => 'amber', 'icon' => 'alert'],
            ['label' => 'Total Gudang', 'value' => '6', 'change' => 'Tersebar di 3 kota', 'tone' => 'violet', 'icon' => 'warehouse'],
            ['label' => 'Permintaan Tertunda', 'value' => '12', 'change' => '4 memerlukan persetujuan hari ini', 'tone' => 'rose', 'icon' => 'clipboard'],
        ];
        $activities = [
            ['title' => 'Penyesuaian stok selesai', 'description' => 'Dudukan Laptop — Gudang Utama', 'time' => '12 menit lalu', 'tone' => 'emerald'],
            ['title' => 'Permintaan material baru diajukan', 'description' => 'MR-2026-031 oleh Tim Pengadaan', 'time' => '38 menit lalu', 'tone' => 'indigo'],
            ['title' => 'Penerimaan pembelian dikonfirmasi', 'description' => 'PO-2026-087 dari PT Nusantara', 'time' => '2 jam lalu', 'tone' => 'sky'],
            ['title' => 'Notifikasi stok menipis', 'description' => 'Tinta Printer Hitam berada di bawah stok minimum', 'time' => '3 jam lalu', 'tone' => 'amber'],
        ];
        $lowStockItems = [
            ['name' => 'Tinta Printer Hitam', 'sku' => 'PRN-INK-BLK', 'stock' => '8 / 25', 'level' => 'w-1/3'],
            ['name' => 'Selotip Kemasan 48mm', 'sku' => 'PKG-TAPE-48', 'stock' => '14 / 40', 'level' => 'w-1/3'],
            ['name' => 'Mouse Nirkabel', 'sku' => 'ACC-MSE-021', 'stock' => '6 / 20', 'level' => 'w-[30%]'],
        ];
    @endphp

    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8 lg:py-8">
        <section class="flex flex-col justify-between gap-5 sm:flex-row sm:items-end">
            <div>
                <p class="text-sm font-semibold text-indigo-600 dark:text-indigo-400">Ringkasan operasional</p>
                <h1 class="mt-1 text-2xl font-bold tracking-tight text-slate-950 dark:text-white sm:text-3xl">Selamat pagi, {{ Str::before(Auth::user()->name, ' ') }}.</h1>
                <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Berikut ringkasan terbaru operasional gudang Anda.</p>
            </div>
            <div class="flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm font-medium text-slate-600 shadow-sm dark:border-slate-800 dark:bg-slate-900 dark:text-slate-300">
                <svg class="h-4 w-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m5 12 4 4L19 6" /></svg>Data baru saja diperbarui
            </div>
        </section>

        <section class="mt-7 grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-5" aria-label="Ringkasan gudang">
            @foreach ($metrics as $metric)
                <article class="group overflow-hidden rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:shadow-md dark:border-slate-800 dark:bg-slate-900">
                    <div class="flex items-start justify-between gap-3">
                        <div><p class="text-sm font-medium text-slate-500 dark:text-slate-400">{{ $metric['label'] }}</p><p class="mt-3 text-3xl font-bold tracking-tight text-slate-950 dark:text-white">{{ $metric['value'] }}</p></div>
                        <span @class([
                            'flex h-10 w-10 items-center justify-center rounded-xl',
                            'bg-indigo-50 text-indigo-600 dark:bg-indigo-500/15 dark:text-indigo-300' => $metric['tone'] === 'indigo',
                            'bg-sky-50 text-sky-600 dark:bg-sky-500/15 dark:text-sky-300' => $metric['tone'] === 'sky',
                            'bg-amber-50 text-amber-600 dark:bg-amber-500/15 dark:text-amber-300' => $metric['tone'] === 'amber',
                            'bg-violet-50 text-violet-600 dark:bg-violet-500/15 dark:text-violet-300' => $metric['tone'] === 'violet',
                            'bg-rose-50 text-rose-600 dark:bg-rose-500/15 dark:text-rose-300' => $metric['tone'] === 'rose',
                        ])>
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8" aria-hidden="true">
                                @if ($metric['icon'] === 'cube')
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 16.5V8.25a2.25 2.25 0 0 0-1.125-1.95l-6.75-3.9a2.25 2.25 0 0 0-2.25 0l-6.75 3.9A2.25 2.25 0 0 0 3 8.25v7.5a2.25 2.25 0 0 0 1.125 1.95l6.75 3.9a2.25 2.25 0 0 0 2.25 0l6.75-3.9A2.25 2.25 0 0 0 21 16.5Z" /><path stroke-linecap="round" stroke-linejoin="round" d="m3.3 7.1 8.7 4.9 8.7-4.9M12 12v9.8" />
                                @elseif ($metric['icon'] === 'chart')
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 19.5h16.5M6.75 16.5v-5m5.25 5v-10m5.25 10V9" />
                                @elseif ($metric['icon'] === 'alert')
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9.3 3.1-7.7-13.2a1.85 1.85 0 0 0-3.2 0L2.7 15.85A1.85 1.85 0 0 0 4.3 18.6h15.4a1.85 1.85 0 0 0 1.6-2.75ZM12 15.75h.01" />
                                @elseif ($metric['icon'] === 'warehouse')
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 21h18M4.5 21V9l7.5-6 7.5 6v12M9 21v-6h6v6M8 10.5h.01M12 10.5h.01M16 10.5h.01" />
                                @else
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5.25h6M9 3h6a1.5 1.5 0 0 1 1.5 1.5V6H18a1.5 1.5 0 0 1 1.5 1.5v12A1.5 1.5 0 0 1 18 21H6a1.5 1.5 0 0 1-1.5-1.5v-12A1.5 1.5 0 0 1 6 6h1.5V4.5A1.5 1.5 0 0 1 9 3Zm0 9h6m-6 3h4.5" />
                                @endif
                            </svg>
                        </span>
                    </div>
                    <p class="mt-4 text-xs font-medium text-slate-500 dark:text-slate-400">{{ $metric['change'] }}</p>
                </article>
            @endforeach
        </section>

        <section class="mt-6 grid grid-cols-1 gap-6 xl:grid-cols-3">
            <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900 xl:col-span-2">
                <div class="flex items-start justify-between gap-4"><div><h2 class="text-base font-bold text-slate-900 dark:text-white">Pergerakan stok</h2><p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Inventaris masuk dan keluar minggu ini</p></div><span class="rounded-lg bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-300">+14.8%</span></div>
                <div class="mt-7 grid h-52 grid-cols-7 items-end gap-3 sm:gap-5" aria-label="Grafik pergerakan stok mingguan">
                    @foreach (["h-20", "h-32", "h-24", "h-40", "h-28", "h-44", "h-36"] as $index => $height)
                        <div class="flex h-full flex-col items-center justify-end gap-2"><div class="w-full rounded-t-lg bg-gradient-to-t from-indigo-600 to-indigo-400 opacity-90 transition hover:opacity-100 {{ $height }}"></div><span class="text-[11px] font-medium text-slate-400">{{ ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'][$index] }}</span></div>
                    @endforeach
                </div>
                <div class="mt-4 flex items-center gap-5 border-t border-slate-100 pt-4 text-xs text-slate-500 dark:border-slate-800 dark:text-slate-400"><span class="flex items-center gap-2"><span class="h-2 w-2 rounded-full bg-indigo-500"></span>Item dipindahkan</span><span class="font-semibold text-slate-700 dark:text-slate-200">3.462 unit minggu ini</span></div>
            </article>
            <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <div class="flex items-center justify-between gap-3"><div><h2 class="text-base font-bold text-slate-900 dark:text-white">Kapasitas gudang</h2><p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Pemakaian kapasitas penyimpanan</p></div><span class="text-lg font-bold text-slate-900 dark:text-white">72%</span></div>
                <div class="mt-7 flex justify-center"><div class="relative flex h-36 w-36 items-center justify-center rounded-full border-[18px] border-indigo-600 border-r-slate-200 border-b-slate-200 dark:border-r-slate-700 dark:border-b-slate-700"><div class="flex flex-col items-center"><span class="text-2xl font-bold text-slate-950 dark:text-white">72%</span><span class="text-[11px] font-medium text-slate-400">terpakai</span></div></div></div>
                <div class="mt-6 grid grid-cols-2 gap-3 border-t border-slate-100 pt-4 dark:border-slate-800"><div><p class="text-xs text-slate-500 dark:text-slate-400">Terpakai</p><p class="mt-1 text-sm font-bold text-slate-800 dark:text-white">13,357 bins</p></div><div><p class="text-xs text-slate-500 dark:text-slate-400">Tersedia</p><p class="mt-1 text-sm font-bold text-slate-800 dark:text-white">5,183 bins</p></div></div>
            </article>
        </section>

        <section class="mt-6 grid grid-cols-1 gap-6 xl:grid-cols-5">
            <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900 xl:col-span-3">
                <div class="flex items-center justify-between gap-4"><div><h2 class="text-base font-bold text-slate-900 dark:text-white">Aktivitas terbaru</h2><p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Pembaruan terbaru di seluruh operasional</p></div><span class="rounded-lg bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-600 dark:bg-slate-800 dark:text-slate-300">Hari ini</span></div>
                <div class="mt-5 divide-y divide-slate-100 dark:divide-slate-800">
                    @foreach ($activities as $activity)
                        <div class="flex gap-3 py-4 first:pt-0 last:pb-0"><span @class(['mt-0.5 flex h-9 w-9 shrink-0 items-center justify-center rounded-xl', 'bg-emerald-50 text-emerald-600 dark:bg-emerald-500/15 dark:text-emerald-300' => $activity['tone'] === 'emerald', 'bg-indigo-50 text-indigo-600 dark:bg-indigo-500/15 dark:text-indigo-300' => $activity['tone'] === 'indigo', 'bg-sky-50 text-sky-600 dark:bg-sky-500/15 dark:text-sky-300' => $activity['tone'] === 'sky', 'bg-amber-50 text-amber-600 dark:bg-amber-500/15 dark:text-amber-300' => $activity['tone'] === 'amber'])><svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m5 12 4 4L19 6" /></svg></span><div class="min-w-0 flex-1"><p class="text-sm font-semibold text-slate-800 dark:text-slate-100">{{ $activity['title'] }}</p><p class="mt-0.5 truncate text-sm text-slate-500 dark:text-slate-400">{{ $activity['description'] }}</p></div><time class="shrink-0 text-xs text-slate-400">{{ $activity['time'] }}</time></div>
                    @endforeach
                </div>
            </article>
            <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900 xl:col-span-2">
                <div class="flex items-center justify-between gap-4"><div><h2 class="text-base font-bold text-slate-900 dark:text-white">Peringatan stok menipis</h2><p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Produk di bawah stok minimum</p></div><span class="rounded-lg bg-rose-50 px-2.5 py-1 text-xs font-semibold text-rose-600 dark:bg-rose-500/10 dark:text-rose-300">24 items</span></div>
                <div class="mt-5 space-y-5">
                    @foreach ($lowStockItems as $item)
                        <div><div class="flex items-start justify-between gap-3"><div class="min-w-0"><p class="truncate text-sm font-semibold text-slate-800 dark:text-slate-100">{{ $item['name'] }}</p><p class="mt-0.5 text-xs text-slate-500 dark:text-slate-400">{{ $item['sku'] }}</p></div><span class="shrink-0 text-xs font-semibold text-rose-600 dark:text-rose-400">{{ $item['stock'] }}</span></div><div class="mt-2 h-1.5 overflow-hidden rounded-full bg-slate-100 dark:bg-slate-800"><div class="h-full rounded-full bg-rose-500 {{ $item['level'] }}"></div></div></div>
                    @endforeach
                </div>
            </article>
        </section>
    </div>
</x-app-layout>