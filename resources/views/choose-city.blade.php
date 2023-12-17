<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Choose a specific city
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                  <div class="jumbotron">
                    <form method="POST" action="{{ route('location') }}">
                      @csrf
                      <div class="form-group">
                          <label for="city">There are several cities with this name. Select the one you need from the list</label>
                          <select name="city" id="city" class="form-control">
                              @foreach ($cityTitels as $key => $city)
                                <option value="{{$city}}">{{$city}}</option>
                                @endforeach
                          </select>
                          <input type="hidden" name="weatherType" value="{{$weatherType}}">
                          <input type="hidden" name="units" value="{{$units}}">
                      </div>

                      <div class="form-group">
                          <button type="submit" class="btn btn-primary">Send</button>
                      </div>
                   </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
</x-app-layout>
