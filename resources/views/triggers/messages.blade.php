<x-dashboard>
    
<div class="relative overflow-x-auto shadow-md sm:rounded-lg p-5 bg-white dark:bg-gray-900 antialiased px-4 py-4">
        <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
            <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                <div class="w-full md:w-1/2">
                    <h1 class="text-3xl font-bold dark:text-white"> Messages </h1>
                </div>
            </div>
            <div class="overflow-x-auto">
                @if ($notifications->isEmpty())
                <div class="sm:col-span-2 p-4">
                    <h3 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">
                        Here you will find the list of all your triggers messages.
                    </h3>
                </div>
                @else
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-4 py-4">Date</th>
                            <th scope="col" class="px-4 py-4">Title</th>
                            <th scope="col" class="px-4 py-3">Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($notifications as $notification)
                        <tr class="border-b dark:border-gray-700 hover:bg-gray-100">
                            <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $notification->data['date'] ?? "2000-12-12 12:00" }}
                            </th>
                            <td class="px-4 py-3">
                                {{ $notification->data['messages']['title'] }}
                            </th>
                            <td class="px-4 py-3">
                                {{ $notification->data['messages']['description'] }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
        </div>
</div>
<!-- End block -->


</x-dashboard>