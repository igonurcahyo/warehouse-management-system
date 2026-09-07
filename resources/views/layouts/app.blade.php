<!DOCTYPE html>
<html lang="id"
    x-data="{ sidebarOpen: false, profileOpen: false, darkMode: false }"
    x-init="darkMode = localStorage.getItem('wms-theme') === 'dark'; $watch('darkMode', value => localStorage.setItem('wms-theme', value ? 'dark' : 'light'))"
    :class="{ 'dark': darkMode }">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Sistem Manajemen Gudang') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
        <script>if (localStorage.getItem('wms-theme') === 'dark') document.documentElement.classList.add('dark');</script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-slate-50 text-slate-900 transition-colors dark:bg-slate-950 dark:text-slate-100">
            @include('layouts.navigation')
            <main class="min-h-screen pt-16 lg:pl-72">
                {{ $slot }}
            </main>
        </div>
    </body>
</html>