@props([])

<nav class="list-group sf-account-nav">
    <a
        href="{{route('account.index')}}"
        class="list-group-item list-group-item-action {{ request()->routeIs('account.index') ? 'active' : '' }}"
        >Profile</a
    >
    <a
        href="{{route('orders.index')}}"
        class="list-group-item list-group-item-action {{ request()->routeIs('orders.*') ? 'active' : '' }}"
        >Orders</a
    >
    <a
        href="{{route('custom_order.index')}}"
        class="list-group-item list-group-item-action {{ request()->routeIs('custom_order.*') ? 'active' : '' }}"
        >Custom Orders</a
    >
</nav>
