<x-dashboard>
    
<div class="relative overflow-x-auto shadow-md sm:rounded-lg p-5 bg-white dark:bg-gray-900 antialiased px-4 py-4">
        <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
            <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                <div class="w-full md:w-1/2">
                    <h1 class="text-3xl font-bold dark:text-white"> Triggers </h1>
                </div>
                <div class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
                    <button type="button" id="createTriggerModalButton" data-modal-target="createTriggerModal" data-modal-toggle="createTriggerModal" class="flex items-center justify-center text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">
                        <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                        </svg>
                        Add trigger
                    </button>
                </div>
            </div>
            <div class="overflow-x-auto">
                @if (!isset($triggers))
                <div class="sm:col-span-2">
                    <h3 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">
                        Here you will find the list of all your created triggers. To create a trigger, please follow to the New trigger section.
                    </h3>
                </div>
                @else
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-4 py-4">Name</th>
                            <th scope="col" class="px-4 py-3">Condition</th>
                            <th scope="col" class="px-4 py-3">Location</th>
                            <th scope="col" class="px-4 py-3">Notify</th>
                            <th scope="col" class="px-4 py-3">Status</th>
                            <th scope="col" class="px-4 py-3">
                                <span class="sr-only">Actions</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($triggers as $trigger)
                        <tr class="border-b dark:border-gray-700 hover:bg-gray-100">
                            <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $trigger->name }}
                            </th>
                            <td class="px-4 py-3">
                                {{ $trigger->parameter }} falls {{ $trigger->condition }} {{ $trigger->value }}
                            </td>
                            <td class="px-4 py-3 max-w-[12rem] truncate">
                                {{ $trigger->city }}
                            </td>
                            <td class="px-4 py-3 max-w-[12rem] truncate">
                                {{ $trigger->period }}
                            </td>
                            <td class="px-4 py-3 max-w-[12rem] truncate">
                                {{ $trigger->status }}
                            </td>

                            <td class="px-4 py-3 flex items-center justify-end">
                                <button id="{{ $trigger->id }}-dropdown-button" data-dropdown-toggle="{{ $trigger->id }}-dropdown" class="inline-flex items-center text-sm font-medium hover:bg-gray-100 dark:hover:bg-gray-700 p-1.5 dark:hover-bg-gray-800 text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100" type="button">
                                    <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                    </svg>
                                </button>
                                <div id="{{ $trigger->id }}-dropdown" class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                                    <ul class="py-1 text-sm" aria-labelledby="{{ $trigger->id }}-dropdown-button">
                                        <li>
                                            <button type="button" onclick="openEditModal({{ $trigger->id }}, '{{ $trigger->name }}', '{{ $trigger->status }}')" data-modal-target="updateTriggerModal" data-modal-toggle="updateTriggerModal" class="flex w-full items-center py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white text-gray-700 dark:text-gray-200">
                                                <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewbox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" />
                                                </svg>
                                                Edit
                                            </button>
                                        </li>  
                                        <li>
                                            <button type="button" onclick="openDeleteModal({{ $trigger->id }})" data-modal-target="deleteModal" data-modal-toggle="deleteModal" class="flex w-full items-center py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 text-red-500 dark:hover:text-red-400">
                                                <svg class="w-4 h-4 mr-2" viewbox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" fill="currentColor" d="M6.09922 0.300781C5.93212 0.30087 5.76835 0.347476 5.62625 0.435378C5.48414 0.523281 5.36931 0.649009 5.29462 0.798481L4.64302 2.10078H1.59922C1.36052 2.10078 1.13161 2.1956 0.962823 2.36439C0.79404 2.53317 0.699219 2.76209 0.699219 3.00078C0.699219 3.23948 0.79404 3.46839 0.962823 3.63718C1.13161 3.80596 1.36052 3.90078 1.59922 3.90078V12.9008C1.59922 13.3782 1.78886 13.836 2.12643 14.1736C2.46399 14.5111 2.92183 14.7008 3.39922 14.7008H10.5992C11.0766 14.7008 11.5344 14.5111 11.872 14.1736C12.2096 13.836 12.3992 13.3782 12.3992 12.9008V3.90078C12.6379 3.90078 12.8668 3.80596 13.0356 3.63718C13.2044 3.46839 13.2992 3.23948 13.2992 3.00078C13.2992 2.76209 13.2044 2.53317 13.0356 2.36439C12.8668 2.1956 12.6379 2.10078 12.3992 2.10078H9.35542L8.70382 0.798481C8.62913 0.649009 8.5143 0.523281 8.37219 0.435378C8.23009 0.347476 8.06631 0.30087 7.89922 0.300781H6.09922ZM4.29922 5.70078C4.29922 5.46209 4.39404 5.23317 4.56282 5.06439C4.73161 4.8956 4.96052 4.80078 5.19922 4.80078C5.43791 4.80078 5.66683 4.8956 5.83561 5.06439C6.0044 5.23317 6.09922 5.46209 6.09922 5.70078V11.1008C6.09922 11.3395 6.0044 11.5684 5.83561 11.7372C5.66683 11.906 5.43791 12.0008 5.19922 12.0008C4.96052 12.0008 4.73161 11.906 4.56282 11.7372C4.39404 11.5684 4.29922 11.3395 4.29922 11.1008V5.70078ZM8.79922 4.80078C8.56052 4.80078 8.33161 4.8956 8.16282 5.06439C7.99404 5.23317 7.89922 5.46209 7.89922 5.70078V11.1008C7.89922 11.3395 7.99404 11.5684 8.16282 11.7372C8.33161 11.906 8.56052 12.0008 8.79922 12.0008C9.03791 12.0008 9.26683 11.906 9.43561 11.7372C9.6044 11.5684 9.69922 11.3395 9.69922 11.1008V5.70078C9.69922 5.46209 9.6044 5.23317 9.43561 5.06439C9.26683 4.8956 9.03791 4.80078 8.79922 4.80078Z" />
                                                </svg>
                                                Delete
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
        </div>
        {{-- Pagination --}}
        <div class="pagination">
            {{ $triggers->links() }}
        </div>
</div>
<!-- End block -->

<!-- Create modal -->
<x-modal-flowbite id="createTriggerModal" modalTitle="Add trigger">
    <!-- Modal body -->
    <form action="{{ route('triggers.store') }}" method="POST">
        @csrf
        <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
            {{-- Name --}}
            <div class="sm:col-span-2">
                <x-label for="name" :value="__('Name')" />
                <x-input id="name" name="name" type="text" class="block mt-1 w-full" :value="old('name')" required autofocus autocomplete="name" placeholder="Enter name"/>
                <x-input-error :messages="$errors->get('name')"/>
            </div>
            {{-- Location --}}
            <div class="sm:col-span-2">
                <x-label for="city" :value="__('Please choose the location:')" />
                <select id="city" name="city" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    <option value="Berlin">Berlin</option>
                    <option value="Dortmund">Dortmund</option>
                </select>
                <x-input-error :messages="$errors->get('city')"/>
            </div>
            <div class="sm:col-span-2">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Trigger condition</h3>
            </div>
            {{-- Weather paramete --}}
            <div class="w-full">
                <x-label for="parameter" :value="__('Weather parameter')" />
                <select id="parameter" name="parameter" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    <option value="temp">Air temperature</option>
                    <option value="wind_speed">Wind speed</option>
                    <option value="humidity">Humidity</option>
                </select>
                <x-input-error :messages="$errors->get('parameter')"/>
            </div>
            {{-- Condition --}}
            <div class="w-full">
                <x-label for="condition" :value="__('Condition')" />           
                <select id="condition" name="condition" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    <option value="above"> > </option>
                    <option value="below"> < </option>
                </select>
                <x-input-error :messages="$errors->get('value')"/>
            </div>
            {{-- Level --}}
            <div class="w-full">
                <x-label for="value" :value="__('Level')" />
                <x-input id="value" name="value" type="number" class="block mt-1 w-full" :value="old('value')" required autofocus autocomplete="value" placeholder="0"/>
                <x-input-error :messages="$errors->get('value')"/>
            </div>
            {{-- Notifications --}}
            <div class="sm:col-span-2">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Notifications</h3>
            </div>
            <div class="sm:col-span-2">
                <select id="period" name="period" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    <option value="0">0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                </select>
            </div>
        </div>
        <button type="submit" class="inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
            <svg class="mr-1 -ml-1 w-6 h-6" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
            </svg>
            Add trigger
        </button>
    </form>
</x-modal-flowbite>

<!-- Update modal -->
<x-modal-flowbite id="updateTriggerModal" modalTitle="Update triger">
    <!-- Modal body -->
    <form id="editTriggerForm" method="POST">
        @csrf
        @method('PUT')
        <div class="grid gap-4 mb-4 ">
            <input type="hidden" id="old-status" name="oldStatus">
            {{-- Name --}}
            <div>
                <x-label for="modal-name" :value="__('Name')" />
                <x-input id="modal-name" name="name" type="text" class="block mt-1 w-full"/>
                <x-input-error :messages="$errors->get('name')"/>
            </div>
            <!-- Toggle Switch -->
            <div>
                <label for="status-toggle" class="flex items-center cursor-pointer">
                    <div class="relative">
                        <input type="checkbox" id="status-toggle" name="status" class="sr-only peer" value="active" onchange="toggleStatus()">
                        <div class="block bg-gray-600 peer-checked:bg-blue-600 w-14 h-8 rounded-full"></div>
                        <div class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition peer-checked:translate-x-full peer-checked:bg-blue-600"></div>
                    </div>
                    <span id="status-label" class="ml-3 text-gray-700 dark:text-gray-400">Active</span>
                </label>
            </div>   
        </div>
        <div class="flex items-center space-x-4">
            <button type="submit" class="text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Update trigger</button>
        </div>
    </form>
</x-modal-flowbite>

<!-- Delete modal -->
<x-modal-flowbite id="deleteModal">
    <div class="relative p-4 text-center bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
    <svg class="text-gray-400 dark:text-gray-500 w-11 h-11 mb-3.5 mx-auto" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
    </svg>
    <p class="mb-4 text-gray-500 dark:text-gray-300">Are you sure you want to delete this trigger?</p>
    <div class="flex justify-center items-center space-x-4">
        <x-primary-button data-modal-toggle="deleteModal"> No, cancel</x-primary-button>
        <form id="deleteTriggerForm" method="POST">
            @csrf
            @method('DELETE')
            <x-danger-button>
                {{ __('Yes, I am sure') }}
            </x-danger-button>
        </form>
</x-modal-flowbite>


<script>
    function openEditModal(triggerId, name, status) {
        // Setting data in modal window fields
        document.getElementById('modal-name').value = name;
        document.getElementById('old-status').value = status;
        const toggle = document.getElementById('status-toggle'); 
        toggle.checked = (status === 'active'); 
        // Update status text
        const statusLabel = document.getElementById('status-label'); 
        statusLabel.textContent = toggle.checked ? 'Active' : 'Inactive';

        // Update the form action URL to send a request to update a specific trigger
        document.getElementById('editTriggerForm').action = `/dashboard/triggers/${triggerId}`;
    }

    function openDeleteModal(triggerId) {
        // Update the form action URL to send a request to delete a specific trigger
        document.getElementById('deleteTriggerForm').action = `/dashboard/triggers/${triggerId}`;
    }
    
    function toggleStatus() {
        const toggle = document.getElementById('status-toggle');
        const statusLabel = document.getElementById('status-label');
        if (toggle.checked) {
            statusLabel.textContent = 'Active';
        } else {
            statusLabel.textContent = 'Inactive';
        }
    }
</script>

</x-dashboard>