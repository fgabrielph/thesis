@props(['amount'])

<span class="sf-money"
    >₱ {{number_format((float) str_replace(',', '', (string) $amount), 2)}}</span
>
