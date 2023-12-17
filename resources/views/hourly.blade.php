<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          48 hours weather in {{$cityTitle}}
        </h2>
    </x-slot>

<div class="py-12">
  <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
      <div class="p-6 bg-white border-b border-gray-200">
        <div class="container">
          <h1>48 hour weather in {{$cityTitle}}</h1>
          <div class="row">
            <div class="col-md-12">
              <div class="my-chart">
                <canvas id="myChart"> </canvas>
                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                <script src="{{ asset('js/chart.js') }}"></script>
                <div id="chartData"
                data-axis-x ="{{ json_encode($chart['x']) }}"
                data-axis-ys="{{ json_encode($chart['Ys']) }}">
              </div>
            </div>
             <table class="table table-sm">
              <thead>
                 <tr>
                   <td id="weather-day">&nbsp;</td>
                   <td id="weather-temperature">Temperature °C</td>
                   <td id="weather-feeling">Feeling like °C</td>
                   <td id="weather-probability">Probability<br>of precipitation %</td>
                   <td id="weather-pressure">Pressureмм hPa</td>
                   <td id="weather-humidity">Humidity</td>
                 </tr>
                </thead>

                <tbody>
                  @foreach($hourly as $hour)
                   <tr>
                     <td>{{date('H:i', $hour->dt)}}<br>{{date('jS \of M', $hour->dt)}}</td>
                     <td>
                       <span>
                         <img width="50" height="50" src="https://openweathermap.org/img/w/{{$hour->weather[0]->icon}}.png" title="{{$hour->weather[0]->description}}">
                         <h3>{{$hour->temp}}°</h3>
                       </span>
                     </td>
                     <td>{{$hour->feels_like}}</td>
                     <td>{{$hour->pop*100}}%</td>
                     <td>{{$hour->pressure}}</td>
                     <td>{{$hour->humidity}}%</td>
                   </tr>
                   @endforeach
                 </tbody>
               </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</x-app-layout>
