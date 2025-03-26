<x-app-layout>

@section('title', 'API Weather error')


@section('content')
<div class="container text-center mt-5">
    <h1 class="text-danger">Error while receiving data</h1>
    <p class="text-muted">{{ $message }}</p>
    <a href="{{ url()->previous() }}" class="btn btn-primary mt-3">Back</a>
</div>
</x-app-layout>
