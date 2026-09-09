<x-app-layout>
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8 lg:py-8">
        <section class="flex flex-col justify-between gap-5 sm:flex-row sm:items-end">
            <div>
                <p class="text-sm font-semibold text-indigo-600 dark:text-indigo-400">Manajemen stok</p>
                <h1 class="mt-1 text-2xl font-bold tracking-tight text-slate-950 dark:text-white sm:text-3xl">Inventaris</h1>
                <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Stok produk per gudang.</p>
            </div>
            @can('manage inventory')
                <a href="{{ route('inventory.create') }}"
                    class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Tambah Stok
                </a>
            @endcan
        </section>

        @if (session('status'))
            <div class="mt-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700 dark:border-emerald-500/20 dark:bg-emerald-500/10 dark:text-emerald-300">
                @if (session('status') === 'inventory-created') Stok berhasil ditambahkan.
                @elseif (session('status') === 'inventory-updated') Stok berhasil diperbarui.
                @elseif (session('status') === 'inventory-deleted') Stok berhasil dihapus.
                @endif
            </div>
        @endif

        <div class="mt-6 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-800">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-800/50">
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Produk</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">SKU</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Kategori</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Gudang</th>
                            <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Stok</th>
                            <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Stok Min</th>
                            @can('manage inventory')
                                <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Aksi</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @forelse ($inventories as $inventory)
                            @php $isLow = $inventory->quantity < $inventory->product->min_stock @endphp
                            <tr class="transition hover:bg-slate-50 dark:hover:bg-slate-800/50">
                                <td class="px-4 py-3 text-sm font-medium text-slate-900 dark:text-white">{{ $inventory->product->name }}</td>
                                <td class="px-4 py-3 text-sm font-mono text-slate-500 dark:text-slate-400">{{ $inventory->product->sku }}</td>
                                <td class="px-4 py-3 text-sm text-slate-500 dark:text-slate-400">{{ $inventory->product->category->name }}</td>
                                <td class="px-4 py-3 text-sm text-slate-500 dark:text-slate-400">{{ $inventory->warehouse->name }}</td>
                                <td class="px-4 py-3 text-right">
                                    <span @class([
                                        'inline-flex items-center rounded-lg px-2 py-0.5 text-xs font-semibold',
                                        'bg-rose-50 text-rose-700 dark:bg-rose-500/10 dark:text-rose-300' => $isLow,
                                        'bg-emerald-50 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-300' => !$isLow,
                                    ])>
                                        {{ number_format($inventory->quantity) }} {{ $inventory->product->unit }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-right text-sm text-slate-500 dark:text-slate-400">
                                    {{ number_format($inventory->product->min_stock) }} {{ $inventory->product->unit }}
                                </td>
                                @can('manage inventory')
                                    <td class="px-4 py-3 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('inventory.edit', $inventory) }}"
                                                class="rounded-lg px-2.5 py-1.5 text-xs font-semibold text-indigo-600 hover:bg-indigo-50 dark:text-indigo-400 dark:hover:bg-indigo-500/10">
                                                Edit
                                            </a>
                                            <form method="POST" action="{{ route('inventory.destroy', $inventory) }}"
                                                onsubmit="return confirm('Hapus data stok ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="rounded-lg px-2.5 py-1.5 text-xs font-semibold text-rose-600 hover:bg-rose-50 dark:text-rose-400 dark:hover:bg-rose-500/10">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                @endcan
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-12 text-center text-sm text-slate-400 dark:text-slate-500">
                                    Belum ada data inventaris.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($inventories->hasPages())
                <div class="border-t border-slate-200 px-4 py-3 dark:border-slate-800">
                    {{ $inventories->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
