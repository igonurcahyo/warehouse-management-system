<x-app-layout>
    <div class="mx-auto max-w-2xl px-4 py-6 sm:px-6 lg:px-8 lg:py-8">
        <section class="mb-6">
            <p class="text-sm font-semibold text-indigo-600 dark:text-indigo-400">Master data</p>
            <h1 class="mt-1 text-2xl font-bold tracking-tight text-slate-950 dark:text-white">Edit Kategori</h1>
        </section>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <form method="POST" action="{{ route('categories.update', $category) }}" class="space-y-5">
                @csrf
                @method('PATCH')

                <div>
                    <x-input-label for="name" value="Nama Kategori" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                        :value="old('name', $category->name)" required autofocus />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="description" value="Deskripsi (Opsional)" />
                    <textarea id="description" name="description" rows="3"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">{{ old('description', $category->description) }}</textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <x-primary-button>Perbarui</x-primary-button>
                    <a href="{{ route('categories.index') }}"
                        class="text-sm font-medium text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
