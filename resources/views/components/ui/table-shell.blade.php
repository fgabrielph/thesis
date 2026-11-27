@props(['title' => null, 'empty' => false, 'emptyMessage' => 'No records found.'])

<div class="card">
    @if ($title || isset($toolbar))
        <div class="card-header d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2">
            @if ($title)
                <h2 class="card-title mb-0">{{$title}}</h2>
            @endif

            @isset($toolbar)
                <div class="card-tools">{{$toolbar}}</div>
            @endisset
        </div>
    @endif

    <div class="card-body p-0">
        <div class="table-responsive">
            {{$table}}

            @if ($empty)
                <p class="text-muted text-center py-4 mb-0">{{$emptyMessage}}</p>
            @endif
        </div>
    </div>
</div>
