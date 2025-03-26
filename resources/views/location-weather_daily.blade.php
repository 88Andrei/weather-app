<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Weather in {{$cityTitle}}
      </h2>
  </x-slot>

  <div class="container tp-4">
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
      <x-chart>
        <x-slot name="axisX">data-axis-x ="{{json_encode($chart['x'])}}"</x-slot>
        <x-slot name="axisYs">data-axis-ys="{{json_encode($chart['Ys'])}}"</x-slot>
      </x-chart>
   </div>
 </div>
</x-app-layout>
