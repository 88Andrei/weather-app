<x-dashboard>

<div class="relative overflow-x-auto shadow-md sm:rounded-lg p-5 bg-white dark:bg-gray-900 antialiased px-4 py-4">
    <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
        <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
            <div class="px-5 w-full">
                <h1>Dashboard: weather at {{ $location->name}}</h1> 
            </div>
        </div>

        <div class="flex overflow-x-auto">
            <table class="flex-grow bg-white dark:bg-black-1 sm:dark:bg-black-2 dark:text-white/70 rounded-xl sm:border-none mt-2">
                <thead>
                    <tr>
                        <th class="p-3 text-left">Time</th>
                        <th class="p-3 text-center">Weather</th>
                        <th class="p-3 text-center">Temp (°C)</th>
                        <th class="p-3 text-center">Humidity (%)</th>
                        <th class="p-3 text-center">Wind Dir (°)</th>
                        <th class="p-3 text-center">Wind Speed (m/s)</th>
                        <th class="p-3 text-center">Precip Prob (%)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sixHourlyWeather as $weather)
                        <tr>
                            <td class="p-3 text-left">{{ date('H:i', $weather->dt) }}</td>
                            <td class="p-3 text-center">
                                <img width="50" height="50" src="https://openweathermap.org/img/w/{{ $weather->weather[0]->icon }}.png" alt="{{ $weather->weather[0]->description }}">
                            </td>
                            <td class="p-3 text-center">{{ $weather->temp }}</td>
                            <td class="p-3 text-center">{{ $weather->humidity }}</td>
                            <td class="p-3 text-center">{{ $weather->wind_deg }}</td>
                            <td class="p-3 text-center">{{ $weather->wind_speed }}</td>
                            <td class="p-3 text-center">{{ $weather->pop * 100 }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>    
    </div>
</div>

</x-dashboard>
