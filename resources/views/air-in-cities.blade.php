<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Air pollution
      </h2>
  </x-slot>

    <div class="container pt-4">
      <h1>Air pollution in {{ $cityTitle1 }}(#1) and {{ $cityTitle2 }}(#2)</h1>
      <div class="row">
        <x-chart>
          <x-slot name="axisX">data-axis-x ="{{ json_encode($chart['x']) }}"</x-slot>
          <x-slot name="axisYs">data-axis-ys="{{ json_encode($chart['Ys']) }}"</x-slot>
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
              @foreach($airDatas as [$data1, $data2])
               <tr>
                 <th scope="row">{{date('H:i d.m.y', $data1->dt)}}</th>
                 <td>
                   <p>#1</p>
                   <p>#2</p>
                 </td>
                 <td>
                   <p>{{$data1->main->aqi}}</p>
                   <p>{{$data2->main->aqi}}</p>
                 </td>
                 <td>
                   <p>{{$data1->components->co}}</p>
                   <p>{{$data2->components->co}}</p>
                  </td>
                 <td>
                   <p>{{$data1->components->no}}</p>
                   <p>{{$data2->components->no}}</p>
                 </td>
                 <td>
                   <p>{{$data1->components->no2}}</p>
                   <p>{{$data2->components->no2}}</p>
                 </td>
                 <td>
                   <p>{{$data1->components->o3}}</p>
                   <p>{{$data2->components->o3}}</p>
                 </td>
                 <td>
                   <p>{{$data1->components->so2}}</p>
                   <p>{{$data2->components->so2}}</p>
                 </td>
                 <td>
                   <p>{{$data1->components->nh3}}</p>
                   <p>{{$data2->components->nh3}}</p>
                 </td>
                 <td>
                   <p>{{$data1->components->pm2_5}}</p>
                   <p>{{$data2->components->pm2_5}}</p>
                 </td>
                 <td>
                   <p>{{$data1->components->pm10}}</p>
                   <p>{{$data2->components->pm10}}</p>
                 </td>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
</x-app-layout>
