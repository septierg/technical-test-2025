<div 
    class="max-w-md sm:max-w-lg lg:max-w-xl mx-auto p-4 sm:p-6"
    x-data
    x-init="
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (pos) => {
                    @this.call('setLocationFromCoords', pos.coords.latitude, pos.coords.longitude);
                },
                (err) => console.log('Geolocation blocked or unavailable:', err)
            );
        }
    "
>
    <div class="flex flex-col sm:flex-row gap-3">
        <!-- Champ de saisie -->
        <input
            type="text"
            wire:model.lazy="city"
            placeholder="Enter a city..."
            class="flex-1 px-4 py-2 rounded-xl border-gray-300 shadow-sm 
                   focus:ring-2 focus:ring-sky-400 focus:border-sky-400 
                   transition placeholder-gray-400"
        />

        <!-- Bouton de recherche -->
        <button
            type="button"
            wire:click="$refresh"
            class="px-4 py-2 rounded-xl bg-sky-600 text-white font-medium 
                   shadow hover:bg-sky-700 transition"
        >
            Search
        </button>
    </div>

    <!-- Loader -->
    <div wire:loading wire:target="city,$refresh" class="mt-4 flex items-center gap-2 text-sky-600">
        <svg class="animate-spin h-5 w-5 text-sky-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor"
                  d="M4 12a8 8 0 018-8v4l3-3-3-3v4a8 8 0 100 16v-4l-3 3 3 3v-4a8 8 0 01-8-8z">
            </path>
        </svg>
        <span class="font-medium">Chargement...</span>
    </div>

    <!-- Messages et résultats -->
    @if(blank($city))
        <div class="mt-4 flex items-center gap-2 p-3 rounded-xl bg-red-100 border border-red-300 text-red-700 shadow-sm transition duration-300 ease-in-out">
        <!-- Icône -->
        <svg class="w-5 h-5 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
             stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M12 9v2m0 4h.01M12 5a7 7 0 100 14 7 7 0 000-14z"/>
        </svg>
        <!-- Texte -->
        <span class="font-medium">You must enter a city.</span>
    </div>

    @elseif($weather)
        <!-- Résultats météo -->
        <div class="mt-6 p-4 sm:p-6 rounded-2xl shadow bg-blue-50">
            <h2 class="text-lg sm:text-xl font-semibold text-blue-700 flex items-center gap-2">
                <i class="fa-solid fa-globe text-blue-700"></i>
                {{ $weather['city'] }}
            </h2>

            <p class="text-gray-700 text-sm sm:text-base">
                Température :
                <span class="font-bold">
                    @if($unit === 'C')
                        {{ $weather['temp_c'] }} °C
                    @else
                        {{ $weather['temp_f'] }} °F
                    @endif
                </span>
            </p>

            <p class="italic text-gray-500 text-sm sm:text-base">
                {{ $weather['description'] }}
            </p>

            <button
                type="button"
                wire:click="toggleUnit"
                class="mt-3 px-3 py-1.5 rounded-lg bg-blue-600 text-white text-xs sm:text-sm 
                       font-medium shadow hover:bg-blue-700 transition"
            >
                Switch to °{{ $unit === 'C' ? 'F' : 'C' }}
            </button>
        </div>

        <!-- Prévisions -->
        @if(isset($weather['forecast']))
            <div class="mt-6 p-4 sm:p-6 rounded-2xl shadow bg-white">
                <h3 class="text-lg sm:text-xl font-semibold text-blue-700 mb-4">
                    5-Day Forecast
                </h3>
                <div class="grid grid-cols-2 sm:grid-cols-5 gap-4">
                    @foreach($weather['forecast'] as $day)
                        <div class="p-3 rounded-xl bg-blue-50 text-center">
                            <p class="font-medium text-gray-700">
                                {{ \Carbon\Carbon::parse($day['Date'])->format('D') }}
                            </p>
                            <p class="text-sm text-gray-500">
                                {{ $day['Temperature']['Minimum']['Value'] }}° - 
                                {{ $day['Temperature']['Maximum']['Value'] }}° 
                                {{ $day['Temperature']['Maximum']['Unit'] }}
                            </p>
                            <p class="italic text-gray-600 text-xs">
                                {{ $day['Day']['IconPhrase'] }}
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        @elseif(strlen($city) > 1)
            <div class="mt-4 flex items-center gap-2 p-3 rounded-xl bg-red-100 border border-red-300 text-red-700 shadow-sm transition duration-300 ease-in-out">
                <!-- Icône -->
                <svg class="w-5 h-5 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v2m0 4h.01M12 5a7 7 0 100 14 7 7 0 000-14z"/>
                </svg>
                <!-- Texte -->
                <span class="font-medium">City not found. Please try again.</span>
            </div>
        @endif




</div>
