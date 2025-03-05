<x-dashboard>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <div class="grid grid-cols-2 gap-2 mb-4 p-2">
        <div class="border-2 p-4 rounded-lg border-gray-300 dark:border-gray-600">
            <p class="dark:text-white/90 text-2xl">Add location</p>
            Please enter coordinates of the required location or click on the map
            <form method="POST" action="{{route('locations.store')}}">
                @csrf
                <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                    {{-- Name --}}
                    <div class="sm:col-span-2">
                        <x-label for="name" :value="__('Name')" />
                        <x-input id="name" name="name" type="text" class="block mt-1 w-full" :value="old('name')" required autofocus autocomplete="name" placeholder="Enter name"/>
                        <x-input-error :messages="$errors->get('name')"/>
                    </div>
                    {{-- lat --}}
                    <div class="sm:col-span-2">
                        <x-label for="value" :value="__('Latitude')" />
                        <x-input id="latitude" name="lat" type="text" class="block mt-1 w-full" :value="old('lat')" required autofocus autocomplete="lat" placeholder="0"/>
                        <x-input-error :messages="$errors->get('lat')"/>
                    </div>
                    {{-- lng --}}
                    <div class="sm:col-span-2">
                        <x-label for="value" :value="__('Longitude')" />
                        <x-input id="longitude" name="lng" type="text" class="block mt-1 w-full" :value="old('lng')" required autofocus autocomplete="lng" placeholder="0"/>
                        <x-input-error :messages="$errors->get('lng')"/>
                    </div>
                </div>
                <button type="submit" class="inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
                    <svg class="mr-1 -ml-1 w-6 h-6" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Add location
                </button>
            </form>
        </div>
        <div id="map" class="border-2 border-dashed rounded-lg border-gray-300 dark:border-gray-600"></div>
    </div>
<!-- End block -->

<script>
    // Initializing the map
    var map = L.map('map').setView([52.523742, 13.404694], 13); // Center of the map
    // Adding a map layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 10,
        minZoom: 2,
    }).addTo(map);
    

    // Add a marker
    var marker = L.marker([52.523742, 13.404694], { draggable: true }).addTo(map);

    // Update form fields when moving marker
    marker.on('dragend', function (event) {
        var position = marker.getLatLng();
        document.getElementById('latitude').value = position.lat.toFixed(6);
        document.getElementById('longitude').value = position.lng.toFixed(6);
    });

    // Set coordinates for click
    map.on('click', function (event) {
        var position = event.latlng;
        marker.setLatLng(position);
        document.getElementById('latitude').value = position.lat.toFixed(6);
        document.getElementById('longitude').value = position.lng.toFixed(6);
    });
</script>
</x-dashboard>
