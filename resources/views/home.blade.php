<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('Main') }}
      </h2>
  </x-slot>

  <!-- Description Section -->
  <div class="p-4 p-md-5 mb-4 rounded text-body-emphasis bg-body-secondary">
    <div>
      <h1 class="display-4 fst-italic text-center">Global Weather & Air Quality Monitoring 🌍☁️</h1>
      <p class="text-center">Stay informed with real-time weather updates and air quality insights powered by the OpenWeather API.</p>
      <p class="lead my-4">
        🌦 Key Features:
        <ul>
          <li><b>✅ Smart Dashboard</b> – Set up alerts and triggers to monitor specific locations and weather changes.</li>
          <li><b>✅ Live Weather & Forecasts </b>– Get accurate weather conditions and forecasts for any city worldwide.</li>
          <li><b>✅ Air Quality Insights</b> – Access historical air pollution data and analyze trends over time.</li>
          <li><b>✅ City Comparisons</b> – Compare air quality levels between two different locations in just a few clicks.</li>
          <li><b>✅ Interactive Charts</b> – Visualize data with dynamic charts for easy interpretation.</li>
        </ul>
        An intuitive interface and powerful analysis features make the application an essential tool for monitoring environmental conditions and planning.
      </p>
    </div>
  </div>

  <!-- Cards Section -->
  <div class="container mt-5">
    <div class="row">
      <!-- First block: Weather App -->
      <div class="col-md-6">
        <div class="card text-white">
          <img src="{{ asset('images/weather-app.jpg') }}" class="card-img-top" alt="Weather App Image">
          <div class="card-img-overlay d-flex flex-column justify-content-end" style="background-color: rgba(0, 0, 0, 0.5);">
            <h3 class="card-title">Weather</h3>
            <p class="card-text">
              Get the current weather in any city around the world, as well as the forecast for the coming days.
            </p>
            <a href="{{route('weather')}}" class="btn btn-primary">Weather service</a>
          </div>
        </div>
      </div>

      <!-- Second block: Air Quality App -->
      <div class="col-md-6">
        <div class="card text-white">
          <img src="{{ asset('images/air-app.jpg') }}" class="card-img-top" alt="Air Quality App Image">
          <div class="card-img-overlay d-flex flex-column justify-content-end" style="background-color: rgba(0, 0, 0, 0.5);">
            <h3 class="card-title">Air Quality</h3>
            <p class="card-text">
              Monitor the air pollution level in your region and receive notifications about air quality.
            </p>
            <a href="{{route('air')}}" class="btn btn-primary">Air Quality service</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="position-relative overflow-hidden p-3 p-md-5 m-md-3  bg-light">
      <div class="jumbotron">
        <div class="row">
          <div class="col">
            <form action="{{ route('location') }}" method="post">
              @csrf
              <div class="form-group">
                <div class="form-group col">
                  <label for="city" class="form-label">Enter City</label>
                  <input type="text" name="city" class="form-control" id="city" placeholder="City" required>
                </div>
                <div class="form-group col">
                  <label for="weatherType" class="form-label">Select weather forecast type</label>
                  <select name="weatherType" class="form-control">
                      <option value="daily">8 day weather forecast</option>
                      <option value="hourly">48 hours weather</option>
                  </select>
                </div>
                <div class="form-group col">
                  <label for="units" class="form-label">Select units type</label>
                  <select name="units" class="form-control">
                    <option value="metric">metric</option>
                    <option value="imperial">imperial</option>
                  </select>
                </div>
                <button type="submit" class="btn btn-primary">Enter</button>
              </div>
            </form>
          </div>

          <div class="col">
              <p>Weather in Dortmund now {{date('H:i', $current->dt)}}</p>
              <div class="img">
                <img width="50" height="50" src="https://openweathermap.org/img/w/{{$current->weather[0]->icon}}.png" alt="{{$current->weather[0]->description}}">
              </div>
               <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                   {{$current->temp}} °C
               </h2>
               <div class="infoDaylight">
                 Sunrise <span>{{date('H:i', $current->sunrise)}}</span>
                 Sunset <span>{{date('H:i', $current->sunset)}}</span>
               </div>
           </div>
         </div>
      </div>

       <h1>8 day weather forecast</h1>
       <div class="row">
        @foreach($forecast as $daily)
          <div class="col-sm">
            <div class="text-center">
              <span>{{date('l', $daily->dt)}}</span>
              <h4>{{date('d', $daily->dt)}}</h4>
              <span>{{date('F', $daily->dt)}}</span>
              <img class="rounded mx-auto d-block" width="50" height="50" src="https://openweathermap.org/img/w/{{$daily->weather[0]->icon}}.png" alt="{{$daily->weather[0]->description}}">
            </div>
            <ul class="list-inline">
             <li class="list-inline-item">Min: <br> {{$daily->temp->min}}°</li>
             <li class="list-inline-item">Max: <br> {{$daily->temp->max}}°</li>
            </ul>
          </div>
        @endforeach
       </div>
         <x-chart>
           <x-slot name="axisX">
             data-axis-x ="{{ json_encode($chart['x']) }}"
           </x-slot>
           <x-slot name="axisYs">
             data-axis-ys="{{ json_encode($chart['Ys']) }}"
           </x-slot>
         </x-chart>
  </div>

</x-app-layout>
