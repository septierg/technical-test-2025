<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
    @vite('resources/css/app.css')
    @livewireStyles
</head>
<body class="bg-gray-50 text-gray-800 antialiased">

    <!-- Navbar -->
    <header class="flex items-center justify-between px-8 py-4 bg-white shadow">
        <h1 class="text-xl font-bold text-indigo-600">{{ config('app.name') }}</h1>
        <nav class="flex gap-6">
            <a href="#" class="text-gray-600 hover:text-indigo-600">Accueil</a>
            <a href="#" class="text-gray-600 hover:text-indigo-600">À propos</a>
            <a href="#" class="text-gray-600 hover:text-indigo-600">Contact</a>
        </nav>
        <a href="#"
           class="px-4 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 transition">
           Se connecter
        </a>
    </header>

    <!-- Hero Section -->
    <section class="text-center py-20 px-6 bg-gradient-to-r from-indigo-500 to-indigo-700 text-white">
        <h2 class="text-5xl font-extrabold mb-6">Bienvenue sur {{ config('app.name') }}</h2>
        <p class="text-lg mb-8 max-w-2xl mx-auto">
            Une application moderne construite avec <span class="font-semibold">Laravel</span>, 
            <span class="font-semibold">Livewire</span> et <span class="font-semibold">TailwindCSS</span>.
        </p>
        <div class="flex justify-center gap-4">
            <a href="#weather"
               class="px-6 py-3 bg-white text-indigo-600 font-semibold rounded-lg shadow hover:bg-gray-100 transition">
               Essayer la météo
            </a>
            <a href="#features"
               class="px-6 py-3 border border-white text-white rounded-lg hover:bg-indigo-600 transition">
               En savoir plus
            </a>
        </div>
    </section>

    <!-- Features -->
    <section id="features" class="py-16 px-8 max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-10">
        <div class="bg-white p-8 rounded-2xl shadow transform hover:scale-105 hover:shadow-xl transition duration-300">
            <div class="text-indigo-600 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M13 16h-1v-4h-1m1-4h.01M12 6a9 9 0 100 18 9 9 0 000-18z" />
                </svg>
            </div>
            <h3 class="text-xl font-semibold mb-2">Performance</h3>
            <p class="text-gray-600">Un code optimisé pour des applications rapides et fluides.</p>
        </div>

        <div class="bg-white p-8 rounded-2xl shadow transform hover:scale-105 hover:shadow-xl transition duration-300">
            <div class="text-indigo-600 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 8c-1.657 0-3 .843-3 1.875S10.343 11.75 12 11.75s3-.843 3-1.875S13.657 8 12 8z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4.5 12a9.5 9.5 0 0115 0M12 17v.01" />
                </svg>
            </div>
            <h3 class="text-xl font-semibold mb-2">Sécurité</h3>
            <p class="text-gray-600">Des bonnes pratiques intégrées pour protéger vos données.</p>
        </div>

        <div class="bg-white p-8 rounded-2xl shadow transform hover:scale-105 hover:shadow-xl transition duration-300">
            <div class="text-indigo-600 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 7h18M3 12h18M3 17h18" />
                </svg>
            </div>
            <h3 class="text-xl font-semibold mb-2">Simplicité</h3>
            <p class="text-gray-600">Un code clair et une UI intuitive pour vos utilisateurs.</p>
        </div>
    </section>

    <!-- Livewire Weather Search -->
    <section id="weather" class="py-16 px-8 bg-gray-100 text-center">
        <h3 class="text-3xl font-bold mb-4 text-gray-800">Recherche météo</h3>
        <p class="text-gray-600 mb-8">Entrez une ville pour obtenir la météo en direct.</p>

        <div class="max-w-md mx-auto bg-white p-6 rounded-xl shadow-lg">
            <livewire:weather-search />
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-400 py-8 text-center">
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. Tous droits réservés.</p>
    </footer>

    @livewireScripts
</body>
</html>
