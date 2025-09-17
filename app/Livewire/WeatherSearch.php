<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Http;
use Livewire\Component;

class WeatherSearch extends Component
{
    public string $city = '';
    public ?array $weather = null;
    public string $unit = 'C';

    public function updatedCity()
    {
    
        if (blank($this->city)) {
            $this->weather = null;
            return;
        }

        if (strlen($this->city) < 3) {
            return $this->resetWeather();
        }

        $location = $this->getLocationKey($this->city);

        if (! $location) {
            return $this->resetWeather();
        }

        $conditions = $this->getWeather($location['key']);
        $forecast   = $this->getForecast($location['key']);

        $this->weather = $conditions
            ? [
                'city'        => $location['name'],
                'temp_c'      => data_get($conditions, 'Temperature.Metric.Value'),
                'temp_f'      => data_get($conditions, 'Temperature.Imperial.Value'),
                'description' => data_get($conditions, 'WeatherText'),
                'forecast'    => $forecast,
            ]
            : null;
    }

    private function getLocationKey(string $city): ?array
    {
        $response = Http::get("https://dataservice.accuweather.com/locations/v1/cities/search", [
            'apikey' => config('services.accuweather.key'),
            'q'      => $city,
        ]);

        if (! $response->successful()) {
            return null;
        }

        $first = $response->json()[0] ?? null;

        if (! $first) {
            return null;
        }

        return [
            'key'  => $first['Key'],
            'name' => $first['LocalizedName'],
        ];
    }

    private function getWeather(string $locationKey): ?array
    {
        $response = Http::get("https://dataservice.accuweather.com/currentconditions/v1/{$locationKey}", [
            'apikey'  => config('services.accuweather.key'),
            'details' => 'true',
        ]);

        return $response->successful() ? $response->json()[0] ?? null : null;
       
    }

    private function resetWeather(): void
    {
        $this->weather = null;
    }

     public function toggleUnit(): void
    {
        $this->unit = $this->unit === 'C' ? 'F' : 'C';
    }

    private function getForecast(string $locationKey): ?array
    {
        $apiKey = config('services.accuweather.key');

        $response = Http::get("https://dataservice.accuweather.com/forecasts/v1/daily/5day/{$locationKey}", [
            'apikey'  => $apiKey,
            'metric'  => true, // use Celsius; false gives Fahrenheit
        ]);

        if (! $response->successful()) {
            return null;
        }

        $json = $response->json();

        return $json['DailyForecasts'] ?? null;
    }


    public function setLocationFromCoords(float $lat, float $lon): void
    {
        $apiKey = config('services.accuweather.key');

        $response = Http::get("https://dataservice.accuweather.com/locations/v1/cities/geoposition/search", [
            'apikey' => $apiKey,
            'q'      => "{$lat},{$lon}",
        ]);

        if ($response->successful() && $response->json()) {
            $data = $response->json();

            $this->city = $data['LocalizedName'] ?? '';
            $this->updatedCity(); // trigger weather + forecast fetching
        }
    }



    public function render()
    {
        return view('livewire.weather-search');
    }
}
