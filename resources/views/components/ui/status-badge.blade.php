@props(['status'])

@php
    $tone = match (true) {
        in_array($status, ['Completed', 'Paid', 'Delivered', 'Accepted'], true) => 'success',
        in_array($status, ['Pending'], true) => 'warning',
        in_array($status, ['Confirmed'], true) => 'info',
        in_array($status, ['On Delivery', 'Processing'], true) => 'info',
        in_array($status, ['Canceled', 'Declined', 'Unpaid', 'Not yet Paid', 'Not yet paid'], true) => 'danger',
        in_array($status, ['Waiting for Approval'], true) => 'warning',
        in_array($status, ['Return', 'Returned'], true) => 'secondary',
        default => 'secondary',
    };
@endphp

<span class="status-badge badge text-bg-{{$tone}}">{{$status}}</span>
