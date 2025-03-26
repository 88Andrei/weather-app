<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Choose a city for {{ $type === 'weather' ? 'weather forecast' : 'air quality' }}
        </h2>
    </x-slot>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="jumbotron">
          <form method="POST" action="{{ route($actionRoute) }}">
          @csrf
          <input type="hidden" name="dateFrom" value="{{ $dateFrom ?? null}}">
          <input type="hidden" name="dateTo" value="{{ $dateTo ?? null}}">
          <input type="hidden" name="dateTo" value="{{ $dateTo ?? null}}">
          <input type="hidden" name="weatherType" value="{{ $weatherType ?? null}}">

          <div class="form-group">
            <label for="city">There are several cities with this name. Select the one you need from the list</label>
            <select name="city" id="city" class="form-control">
                @foreach ($cityTitles as $city)
                  <option value="{{$city}}">{{$city}}</option>
                  @endforeach
            </select>
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-primary">Send</button>
          </div>
          </form>
        </div>
      </div>
    </div>
</x-app-layout>
