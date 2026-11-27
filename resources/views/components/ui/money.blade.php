@props(['amount'])

<span class="fw-semibold text-nowrap"
    >₱ {{number_format((float) str_replace(',', '', (string) $amount), 2)}}</span
>
