<x-app-layout>
    <div class="mx-auto max-w-2xl px-4 py-6 sm:px-6 lg:px-8 lg:py-8">
        <section class="mb-6">
            <p class="text-sm font-semibold text-indigo-600 dark:text-indigo-400">Master data</p>
            <h1 class="mt-1 text-2xl font-bold tracking-tight text-slate-950 dark:text-white">Tambah Gudang</h1>
        </section>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <form method="POST" action="{{ route('warehouses.store') }}" class="space-y-5">
                @csrf

                <div>
                    <x-input-label for="name" value="Nama Gudang" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                        :value="old('name')" required autofocus />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="location" value="Lokasi" />
                    <x-text-input id="location" name="location" type="text" class="mt-1 block w-full"
                        :value="old('location')" required />
                    <x-input-error :messages="$errors->get('location')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="capacity" value="Kapasitas (Unit)" />
                    <x-text-input id="capacity" name="capacity" type="number" min="0" class="mt-1 block w-full"
                        :value="old('capacity')" required />
                    <x-input-error :messages="$errors->get('capacity')" class="mt-2" />
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <x-primary-button>Simpan</x-primary-button>
                    <a href="{{ route('warehouses.index') }}"
                        class="text-sm font-medium text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
