<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('Weather') }}
      </h2>
  </x-slot>

  <div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 bg-light">
      <div class="jumbotron">
          <div class="row">
              <!-- Form Column -->
              <div class="col-md-6">
                  <form action="{{ route('location') }}" method="post">
                      @csrf
                      <div class="form-group">
                          <label for="city" class="form-label">Enter City</label>
                          <input type="text" name="city" class="form-control" id="city" placeholder="City" required>
                      </div>
                      <div class="form-group">
                          <label for="weatherType" class="form-label">Select Weather Forecast Type</label>
                          <select name="weatherType" class="form-control" id="weatherType">
                              <option value="daily">8 Day Weather Forecast</option>
                              <option value="hourly">48 Hours Weather</option>
                          </select>
                      </div>
                      <div class="form-group">
                          <label for="units" class="form-label">Select Units Type</label>
                          <select name="units" class="form-control" id="units">
                              <option value="metric">Metric</option>
                              <option value="imperial">Imperial</option>
                          </select>
                      </div>
                      <button type="submit" class="btn btn-primary">Enter</button>
                  </form>
              </div>

              <!-- Weather Info Column -->
              <div class="col-md-6">
                  <p>Weather in Dortmund now: {{ date('H:i', $current->dt) }}</p>
                  <div class="img">
                      <img width="50" height="50" src="https://openweathermap.org/img/w/{{ $current->weather[0]->icon }}.png" alt="{{ $current->weather[0]->description }}">
                  </div>
                  <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                      {{ $current->temp }} °C
                  </h2>
                  <div class="infoDaylight">
                      Sunrise: <span>{{ date('H:i', $current->sunrise) }}</span><br>
                      Sunset: <span>{{ date('H:i', $current->sunset) }}</span>
                  </div>
              </div>
          </div>
      </div>

      <h1 class="mt-4">8 Day Weather Forecast</h1>
      <div class="row">
          @foreach($forecast as $daily)
              <div class="col-sm">
                  <div class="text-center">
                      <span>{{ date('l', $daily->dt) }}</span><br>
                      <h4>{{ date('d', $daily->dt) }}</h4>
                      <span>{{ date('F', $daily->dt) }}</span>
                      <img class="rounded mx-auto d-block" width="50" height="50" src="https://openweathermap.org/img/w/{{ $daily->weather[0]->icon }}.png" alt="{{ $daily->weather[0]->description }}">
                  </div>
                  <ul class="list-inline text-center mt-2">
                      <li class="list-inline-item">Min: <br> {{ $daily->temp->min }}°</li>
                      <li class="list-inline-item">Max: <br> {{ $daily->temp->max }}°</li>
                  </ul>
              </div>
          @endforeach
      </div>

      <x-chart>
          <x-slot name="axisX">
              data-axis-x="{{ json_encode($chart['x']) }}"
          </x-slot>
          <x-slot name="axisYs">
              data-axis-ys="{{ json_encode($chart['Ys']) }}"
          </x-slot>
      </x-chart>
  </div>
</x-app-layout>
