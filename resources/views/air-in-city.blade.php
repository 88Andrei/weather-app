<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Air pollution
      </h2>
  </x-slot>

  <div class="container">
    <h1>Air pollution in {{$cityTitle}}</h1>
    <div class="row">
      <div class="col-md-12">
      <x-chart>
        <x-slot name="axisX">data-axis-x ="{{json_encode($chart['x'])}}"</x-slot>
        <x-slot name="axisYs">data-axis-ys="{{json_encode($chart['Ys'])}}"</x-slot>
      </x-chart>

       <table class="table">
        <thead>
           <tr>
             <th scope="col">Time</th>
             <th scope="col">Air Quality Index</th>
             <th scope="col">Carbon monoxide (CO) μg/m3</th>
             <th scope="col">Nitrogen monoxide (NO) μg/m3</th>
             <th scope="col">Nitrogen dioxide (NO2) μg/m3</th>
             <th scope="col">Ozone (O3) μg/m3</th>
             <th scope="col">Sulphur dioxide (SO2) μg/m3</th>
             <th scope="col">Ammonia (NH3) μg/m3</th>
             <th scope="col">Particulates (PM2.5) (Fine particles matter)</th>
             <th scope="col">Particulates (PM10) (Coarse particulate matter)</th>
           </tr>
          </thead>
          <tbody>
            @foreach($airDatas as $data)
             <tr>
               <td>{{date('H:i d.m.Y', $data->dt)}}</td>
               <td>{{$data->main->aqi}}</td>
               <td>{{$data->components->co}}</td>
               <td>{{$data->components->no}}</td>
               <td>{{$data->components->no2}}</td>
               <td>{{$data->components->o3}}</td>
               <td>{{$data->components->so2}}</td>
               <td>{{$data->components->nh3}}</td>
               <td>{{$data->components->pm2_5}}</td>
               <td>{{$data->components->pm10}}</td>
             </tr>
             @endforeach
           </tbody>
         </table>
    </div>
  </div>
</x-app-layout>
