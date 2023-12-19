<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Air pollution
      </h2>
  </x-slot>

    <div class="container">
      <h1>Air pollution in {{$cityTitle1}}(#1) and {{$cityTitle2}}(#2)</h1>
      <div class="row">
        <x-chart>
          <x-slot name="axisX">data-axis-x ="{{json_encode($chart['x'])}}"</x-slot>
          <x-slot name="axisYs">data-axis-ys="{{json_encode($chart['Ys'])}}"</x-slot>
        </x-chart>
        <table class="table table-striped table-hover table-bordered">
          <thead class="thead-light">
             <tr>
               <th scope="col">Time</th>
               <th scope="col">City</th>
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
                 <th scope="row">{{date('H:i d.m.y', $data->dt)}}</th>
                 <td>
                   <p>#1</p>
                   <p>#2</p>
                 </td>
                 <td>
                   <p>{{$data->main->aqi}}</p>
                   <p>{{$data->main1->aqi}}</p>
                 </td>
                 <td>
                   <p>{{$data->components->co}}</p>
                   <p>{{$data->components1->co}}</p>
                  </td>
                 <td>
                   <p>{{$data->components->no}}</p>
                   <p>{{$data->components1->no}}</p>
                 </td>
                 <td>
                   <p>{{$data->components->no2}}</p>
                   <p>{{$data->components1->no2}}</p>
                 </td>
                 <td>
                   <p>{{$data->components->o3}}</p>
                   <p>{{$data->components1->o3}}</p>
                 </td>
                 <td>
                   <p>{{$data->components->so2}}</p>
                   <p>{{$data->components1->so2}}</p>
                 </td>
                 <td>
                   <p>{{$data->components->nh3}}</p>
                   <p>{{$data->components1->nh3}}</p>
                 </td>
                 <td>
                   <p>{{$data->components->pm2_5}}</p>
                   <p>{{$data->components1->pm2_5}}</p>
                 </td>
                 <td>
                   <p>{{$data->components->pm10}}</p>
                   <p>{{$data->components1->pm10}}</p>
                 </td>
               </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
</x-app-layout>
