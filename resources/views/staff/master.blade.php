<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>
        {{ config('app.name') }} |
        @yield ('title')
    </title>

    @vite ('resources/js/app.js')
</head>
<body class="layout-fixed sidebar-expand-lg bg-body-tertiary" data-staff-shell>
    <div class="app-wrapper">
        @include ('staff.includes.navbar')
        @include ('staff.includes.sidebar')

        <main class="app-main">
            <div class="app-content">
                @yield ('content')
            </div>
        </main>

        @include ('staff.includes.footer')
    </div>

    @yield ('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            ['orderTable', 'defTable', 'atkTable'].forEach(function (id) {
                const table = document.getElementById(id);
                if (table && window.jQuery && !window.jQuery.fn.dataTable.isDataTable('#' + id)) {
                    const options = { stateSave: true };
                    if (id !== 'orderTable') {
                        options.order = [[0, 'desc']];
                    }
                    window.jQuery('#' + id).DataTable(options);
                }
            });
        });
    </script>
</body>
</html>
