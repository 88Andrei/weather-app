<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Air pollution
        </h2>
    </x-slot>

    <div class="container pt-2">

      <div class="bg-gray-50 py-2 sm:py-2">
        <div class="mx-auto max-w-2xl px-6 lg:max-w-7xl lg:px-8">
          <p class="mx-auto mt-2 max-w-lg text-center text-4xl font-semibold tracking-tight text-balance text-gray-950 sm:text-5xl">
            Current, forecast and historical air pollution data
          </p>
          <div class="mt-4 grid gap-4 sm:mt-6 lg:grid-cols-2">

            <div class="relative ">
              <div class="absolute inset-px rounded-lg bg-white lg:rounded-l-[2rem]"></div>
              <div class="relative flex h-full flex-col overflow-hidden rounded-[calc(var(--radius-lg)+1px)] lg:rounded-l-[calc(2rem+1px)]">
                <div class="px-8 pt-2 sm:px-10 sm:pt-2 sm:pb-0">
                  <p class="mt-2 text-lg font-medium tracking-tight text-gray-950 max-lg:text-center">
                    Air pollution in a given city
                  </p>

                  <form action="{{ route('air_in_city') }}" method="post">
                    @csrf
                    <div class="mt-2 grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-2">
                      <div class="sm:col-span-2">
                        <label for="inputCity">City</label>
                        <input type="text" class="form-control" name="city" id="inputCity">
                      </div>
                      <div class="sm:col-span-1">
                        <label for="weatherType">Select date from</label>
                        <input type="date" class="form-control" name="dateFrom" value="{{date('Y-m-d')}}" />
                      </div>
                      <div class="sm:col-span-1">
                        <label for="weatherType">Select date to</label>
                        <input type="date" class="form-control" name="dateTo" value="{{date('Y-m-d')}}" />
                      </div>
                      <p class="max-w-lg text-sm/6 text-gray-600 max-lg:text-center sm:col-span-2">
                        *if the selected period is more than 48 hours, the data will be averaged to the day
                      </p>
                    </div>
                    <div class="mb-4">
                      <button type="submit" class="btn btn-primary">Enter</button>
                    </div>
                  </form>
                </div>
              </div>
              <div class="pointer-events-none absolute inset-px rounded-lg ring-1 shadow-sm ring-black/5 lg:rounded-l-[2rem]"></div>
            </div>

            <div class="relative ">
              <div class="absolute inset-px rounded-lg bg-white max-lg:rounded-b-[2rem] lg:rounded-r-[2rem]"></div>
              <div class="relative flex h-full flex-col overflow-hidden rounded-[calc(var(--radius-lg)+1px)] max-lg:rounded-b-[calc(2rem+1px)] lg:rounded-r-[calc(2rem+1px)]">
                <div class="px-8 pt-2 sm:px-10 sm:pt-2 sm:pb-0">
                  <p class="mt-2 text-lg font-medium tracking-tight text-gray-950 max-lg:text-center">
                    Comparison of air pollution in two cities
                  </p>

                  <form action="{{ route('air_in_cities') }}" method="post">
                    @csrf
                    <div class="mt-2 grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-2">
                      <div class="sm:col-span-1">
                        <label for="inputCity">City 1</label>
                        <input type="text" class="form-control" name="city1" id="inputCity">
                      </div>
                      <div class="sm:col-span-1">
                        <label for="inputCity">City 2</label>
                        <input type="text" class="form-control" name="city2" id="inputCity">
                      </div>
                      <div class="sm:col-span-1">
                        <label for="weatherType">Select date from</label>
                        <input type="date" class="form-control" name="dateFrom" value="{{date('Y-m-d')}}" />
                      </div>
                      <div class="sm:col-span-1">
                        <label for="weatherType">Select date to</label>
                        <input type="date" class="form-control" name="dateTo" value="{{date('Y-m-d')}}" />
                      </div>
                      <p class="max-w-lg text-sm/6 text-gray-600 max-lg:text-center sm:col-span-2">
                        *if the selected period is more than 48 hours, the data will be averaged to the day
                      </p>
                    </div>
                   <div class="mb-4">
                    <button type="submit" class="btn btn-primary">Enter</button>
                   </div>
                  </form>
                </div>
              </div>
              <div class="pointer-events-none absolute inset-px rounded-lg ring-1 shadow-sm ring-black/5 max-lg:rounded-b-[2rem] lg:rounded-r-[2rem]"></div>
            </div>
          </div>
        </div>
      </div>
     
      <h2>Air pollution in {{(isset($airData->cityTitle)) ? $airData->cityTitle : 'Dortmund'}}</h2>
      <div class="row">
        <x-chart>
          <x-slot name="axisX">data-axis-x ="{{json_encode($chart['x'])}}"</x-slot>
          <x-slot name="axisYs">data-axis-ys="{{json_encode($chart['Ys'])}}"</x-slot>
        </x-chart>
        <div class="overflow-x-auto">
          <table class="w-full border-collapse border border-gray-300 text-sm">
              <thead class="bg-gray-100">
                  <tr>
                      <th class="p-2 border border-gray-300">&nbsp;</th>
                      <th class="p-2 border border-gray-300">Air Quality Index</th>
                      <th class="p-2 border border-gray-300">CO (μg/m³)</th>
                      <th class="p-2 border border-gray-300">NO (μg/m³)</th>
                      <th class="p-2 border border-gray-300">NO2 (μg/m³)</th>
                      <th class="p-2 border border-gray-300">O3 (μg/m³)</th>
                      <th class="p-2 border border-gray-300">SO2 (μg/m³)</th>
                      <th class="p-2 border border-gray-300">NH3 (μg/m³)</th>
                      <th class="p-2 border border-gray-300">PM2.5</th>
                      <th class="p-2 border border-gray-300">PM10</th>
                  </tr>
              </thead>
      
              <tbody>
                  @foreach($airData as $data)
                  <tr class="odd:bg-white even:bg-gray-50">
                      <td class="p-2 border border-gray-300">
                          {{ $data ? date('H:i d.m.Y', $data->dt) : '...' }}
                      </td>
                      <td class="p-2 border border-gray-300">
                          {{ $data ? $data->main->aqi : '...' }}
                      </td>
                      <td class="p-2 border border-gray-300">
                          {{ $data ? $data->components->co : '...' }}
                      </td>
                      <td class="p-2 border border-gray-300">
                          {{ $data ? $data->components->no : '...' }}
                      </td>
                      <td class="p-2 border border-gray-300">
                          {{ $data ? $data->components->no2 : '...' }}
                      </td>
                      <td class="p-2 border border-gray-300">
                          {{ $data ? $data->components->o3 : '...' }}
                      </td>
                      <td class="p-2 border border-gray-300">
                          {{ $data ? $data->components->so2 : '...' }}
                      </td>
                      <td class="p-2 border border-gray-300">
                          {{ $data ? $data->components->nh3 : '...' }}
                      </td>
                      <td class="p-2 border border-gray-300">
                          {{ $data ? $data->components->pm2_5 : '...' }}
                      </td>
                      <td class="p-2 border border-gray-300">
                          {{ $data ? $data->components->pm10 : '...' }}
                      </td>
                  </tr>
                  @endforeach
              </tbody>
          </table>
      </div>
      </div>
    </div>
</x-app-layout>
