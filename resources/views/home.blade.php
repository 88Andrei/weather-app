<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('Main') }}
      </h2>
  </x-slot>

  <!-- Description Section -->
  <div class="px-4 p-md-5 mb-4 rounded text-body-emphasis bg-body-secondary">
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
  <div class="container mb-5">
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
</x-app-layout>
