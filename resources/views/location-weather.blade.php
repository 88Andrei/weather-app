<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Weather in {{$cityTitle}}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                   <div class="container">
                     <h1>8 day weather forecast in {{$cityTitle}}</h1>
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

                        </div>
                     </div>
                   </div>
                </div>
              </div>
            </div>
          </div>
</x-app-layout>
