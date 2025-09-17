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
        <input
            type="text"
            wire:model.lazy="city"
            placeholder="Enter a city..."
            class="flex-1 px-4 py-2 rounded-xl border-gray-300 shadow-sm 
                   focus:ring-2 focus:ring-sky-400 focus:border-sky-400 
                   transition placeholder-gray-400"
        />

        <button
            type="button"
            wire:click="$refresh"
            class="px-4 py-2 rounded-xl bg-sky-600 text-white font-medium 
                   shadow hover:bg-sky-700 transition"
        >
            Search
        </button>
    </div>

    @if(blank($city))
        <p class="mt-4 text-red-500 text-sm sm:text-base">You must enter a city.</p>

    @elseif($weather)
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

   
    @elseif(strlen($city) > 2)
        <p class="mt-4 text-red-500 text-sm sm:text-base">City not found.</p>
    @endif
</div>
