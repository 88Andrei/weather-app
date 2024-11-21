@if (session('success'))
<div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
    {{ session('success') }}
</div>
@endif

@if (session('error'))
<div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
    {{ session('error') }}
</div>
@endif