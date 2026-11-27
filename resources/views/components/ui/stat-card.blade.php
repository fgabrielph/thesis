@props(['label', 'value', 'href', 'icon' => 'chart-bar', 'tone' => 'primary'])

<div class="card h-100 border-0 shadow-sm">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-start gap-3">
            <div>
                <div class="text-muted small">{{$label}}</div>
                <div class="fs-3 fw-semibold">{{$value}}</div>
            </div>
            <i class="fas fa-{{$icon}} fs-3 text-{{$tone}}"></i>
        </div>

        <a href="{{$href}}" class="small text-decoration-none">View details</a>
    </div>
</div>
