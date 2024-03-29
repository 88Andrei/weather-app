<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Air pollution
        </h2>
    </x-slot>

    <div class="container">
      <div>
        <h2>History of air pollution in a given city</h2>
        <form action="{{ route('air-in-city') }}" method="post">
          @csrf
          <div class="form-row">
            <div class="form-group col-md-3">
              <label for="inputCity">City</label>
              <input type="text" class="form-control" name="city" id="inputCity">
            </div>
            <div class="form-group col-md-3">
              <label for="weatherType">Select date from</label>
              <input type="date" class="form-control" name="dateFrom" value="{{date('Y-m-d')}}" />
            </div>
            <div class="form-group col-md-3">
              <label for="weatherType">Select date to</label>
              <input type="date" class="form-control" name="dateTo" value="{{date('Y-m-d')}}" />
            </div>
          </div>
          <p> *if the selected period is more than 48 hours, the data will be averaged to the day</p>
          <button type="submit" class="btn btn-primary">Enter</button>
        </form>

      </div>

      <div>
        <h2>Comparing the air pollution history of two cities</h2>
        <form action="{{ route('air-in-cities') }}" method="post">
          @csrf
          <div class="form-row">
            <div class="form-group col-md-3">
              <label for="inputCity">City 1</label>
              <input type="text" class="form-control" name="city1" id="inputCity">
            </div>
            <div class="form-group col-md-3">
              <label for="inputCity">City 2</label>
              <input type="text" class="form-control" name="city2" id="inputCity">
            </div>
            <div class="form-group col-md-3">
              <label for="weatherType">Select date from</label>
              <!-- <input type="date" class="form-control" name="dateFrom" value="{{date('Y-m-d' , mktime(0, 0, 0, 11, 27, 2020))}}" /> -->
              <input type="date" class="form-control" name="dateFrom" value="{{date('Y-m-d')}}" />
            </div>
            <div class="form-group col-md-3">
              <label for="weatherType">Select date to</label>
              <input type="date" class="form-control" name="dateTo" value="{{date('Y-m-d')}}" />
              <p> *if the selected period is more than 48 hours, the data will be averaged to the day</p>
            </div>
          </div>
          <button type="submit" class="btn btn-primary">Enter</button>
        </form>
      </div>

      <h1>Air pollution in {{(isset($cityTitle)) ? $cityTitle : 'Dortmund'}}</h1>
      <div class="row">
        <x-chart>
          <x-slot name="axisX">data-axis-x ="{{json_encode($chart['x'])}}"</x-slot>
          <x-slot name="axisYs">data-axis-ys="{{json_encode($chart['Ys'])}}"</x-slot>
        </x-chart>
        <table class="table">
          <thead>
             <tr>
               <td>&nbsp;</td>
               <td>Air Quality Index</td>
               <td>Carbon monoxide (CO) μg/m3</td>
               <td>Nitrogen monoxide (NO) μg/m3</td>
               <td>Nitrogen dioxide (NO2) μg/m3</td>
               <td>Ozone (O3) μg/m3</td>
               <td>Sulphur dioxide (SO2) μg/m3</td>
               <td>Ammonia (NH3) μg/m3</td>
               <td>Particulates (PM2.5) (Fine particles matter)</td>
               <td>Particulates (PM10) (Coarse particulate matter)</td>
             </tr>
            </thead>

            <tbody>
              @foreach($airDatas as $data)
               <tr>
                 <td>{{($data) ? date('H:i d.m.Y', $data->dt) : '...'}}</td>
                 <td>{{($data) ? $data->main->aqi : '...'}}</td>
                 <td>{{($data) ? $data->components->co : '...'}}</td>
                 <td>{{($data) ? $data->components->no : '...'}}</td>
                 <td>{{($data) ? $data->components->no2 : '...'}}</td>
                 <td>{{($data) ? $data->components->o3 : '...'}}</td>
                 <td>{{($data) ? $data->components->so2 : '...'}}</td>
                 <td>{{($data) ? $data->components->nh3 : '...'}}</td>
                 <td>{{($data) ? $data->components->pm2_5 : '...'}}</td>
                 <td>{{($data) ? $data->components->pm10 : '...'}}</td>
               </tr>
               @endforeach
             </tbody>
           </table>
      </div>
    </div>
</x-app-layout>
