@props(['message'])

<div class="text-center text-muted py-5">
    <i class="fas fa-inbox fs-2 mb-3"></i>
    <p class="mb-3">{{$message}}</p>
    {{$slot}}
</div>
