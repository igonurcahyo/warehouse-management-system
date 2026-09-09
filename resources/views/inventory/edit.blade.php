<x-app-layout>
    <div class="mx-auto max-w-2xl px-4 py-6 sm:px-6 lg:px-8 lg:py-8">
        <section class="mb-6">
            <p class="text-sm font-semibold text-indigo-600 dark:text-indigo-400">Inventaris</p>
            <h1 class="mt-1 text-2xl font-bold tracking-tight text-slate-950 dark:text-white">Edit Stok</h1>
        </section>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <form method="POST" action="{{ route('inventory.update', $inventory) }}" class="space-y-5">
                @csrf
                @method('PATCH')

                <div>
                    <x-input-label for="product_id" value="Produk" />
                    <select id="product_id" name="product_id" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">
                        <option value="">-- Pilih Produk --</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}" @selected(old('product_id', $inventory->product_id) == $product->id)>
                                {{ $product->name }} ({{ $product->sku }})
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('product_id')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="warehouse_id" value="Gudang" />
                    <select id="warehouse_id" name="warehouse_id" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">
                        <option value="">-- Pilih Gudang --</option>
                        @foreach ($warehouses as $warehouse)
                            <option value="{{ $warehouse->id }}" @selected(old('warehouse_id', $inventory->warehouse_id) == $warehouse->id)>
                                {{ $warehouse->name }} — {{ $warehouse->location }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('warehouse_id')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="quantity" value="Jumlah Stok" />
                    <x-text-input id="quantity" name="quantity" type="number" min="0" class="mt-1 block w-full"
                        :value="old('quantity', $inventory->quantity)" required />
                    <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <x-primary-button>Perbarui</x-primary-button>
                    <a href="{{ route('inventory.index') }}"
                        class="text-sm font-medium text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
