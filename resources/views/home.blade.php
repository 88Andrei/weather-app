<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Главная') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                  <div class="jumbotron">
                    <p>Введите координаты точки</p>
                    <form action="{{ route('location') }}" method="post">
                      @csrf
                      <input type="number"  min="-90" max="90" step="0.01" name="lat" placeholder="lat">
                      <input type="number" min="-180" max="180" step="0.01" name="lon" placeholder="lon">
                      <select name="units">
                          <option>metric</option>
                          <option>imperial</option>
                      </select>
                      <x-button class="ml-3">
                          {{ __('Enter') }}
                      </x-button>
                    </form>
                  </div>


                  <div class="jumbotron">
                      <p>Погода в Киеве сегодня в {{date('H:m', $current->dt)}}</p>

                      <div class="img">
                        <img width="50" height="50" src="https://openweathermap.org/img/w/{{$current->weather[0]->icon}}.png" alt="{{$current->weather[0]->description}}">
                      </div>
                       <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                           {{$current->temp}} °C
                       </h2>
                       <div class="infoDaylight">
                         Восход <span>{{date('H:m', $current->sunrise)}}</span>
                         Закат <span>{{date('H:m', $current->sunset)}}</span>
                       </div>
                   </div>
                   <div class="container">
                     <div class="row">
                         @foreach($forecast as $daily)
                           <div class="col-sm">
                             <h3>Погода {{date('l jS \of F Y', $daily->dt)}}</h3>
                             <div>
                               <img width="50" height="50" src="https://openweathermap.org/img/w/{{$daily->weather[0]->icon}}.png" alt="{{$daily->weather[0]->description}}">
                             </div>
                              <h2 class="font-semibold text-xl text-gray-800 leading-tight"> Температура</h2>
                                 <p> Min: {{$daily->temp->min}}°C</p>
                                 <p>Max: {{$daily->temp->max}}°C</p>
                                 <p> Day: {{$daily->temp->day}}°C</p>
                                 <p>Night: {{$daily->temp->night}}°C</p>
                              <div>
                                Восход <span>{{date('H:m', $daily->sunrise)}}</span>
                                Закат <span>{{date('H:m', $daily->sunset)}}</span>
                              </div>
                           </div>
                         @endforeach
                     </div>
                   </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
