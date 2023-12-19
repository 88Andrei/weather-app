<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Main') }}
        </h2>
    </x-slot>

  <div class="jumbotron">
    <form action="{{ route('location') }}" method="post">
      @csrf
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="city" class="form-label">Enter City</label>
          <input type="text" name="city" class="form-control" id="city" placeholder="City">
        </div>
        <div class="form-group col-md-3">
          <label for="weatherType" class="form-label">Select weather forecast type</label>
          <select name="weatherType" class="form-control">
              <option value="daily">8 day weather forecast</option>
              <option value="hourly">48 hours weather</option>
          </select>
        </div>
        <div class="form-group col-md-3">
          <label for="units" class="form-label">Select units type</label>
          <select name="units" class="form-control">
            <option value="metric">metric</option>
            <option value="imperial">imperial</option>
          </select>
        </div>
      </div>
      <button type="submit" class="btn btn-primary">Enter</button>
    </form>
  </div>

 <div class="container">
   <div class="col align-self-center">
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

</x-app-layout>
