<x-dashboard>
  <section class="bg-white dark:bg-gray-900">
    <div class="py-8 px-4 mx-auto max-w-2xl lg:py-16">
        <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Add a new trigger</h2>
        <form action="{{route('triggers.store')}}" method="POST">
            @csrf
            <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                <div class="sm:col-span-2">
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                    <input type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Enter name" required="">
                </div>
                <div class="sm:col-span-2">
                    <label for="city" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Please choose the location:</label>
                    <select id="city" name="city" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                        <option value="Berlin">Berlin</option>
                        <option value="Dortmund">Dortmund</option>
                    </select>
                </div>
                <div class="sm:col-span-2">
                    <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Trigger condition</h2>
                </div>
                <div class="w-full">
                    <label for="parameter" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Weather parameter</label>
                    <select id="parameter" name="parameter" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                        <option value="temp">Air temperature</option>
                        <option value="wind">Wind speed</option>
                        <option value="prec">Precipitation</option>
                    </select>
                </div>
                <div class="w-full">
                    <label for="condition" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Condition</label>
                    <select id="condition" name="condition" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                        <option value=">"> > </option>
                        <option value="<"> < </option>

                    </select>
                </div>
                <div class="w-full">
                    <label for="value" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Level</label>
                    <input type="number" name="value" id="value" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="0" required="">
                </div>
                <div class="sm:col-span-2">
                    <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Notifications</h2>
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
                Add trigger
            </button>
        </form>
    </div>
  </section> 
</x-dashboard>