<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <title>{{config('app.name')}} | @yield ('title')</title>

        @vite ('resources/js/storefront.js')
    </head>
    <body data-storefront>
        <x-storefront.navbar />

        @hasSection ('hero')
            <section class="sf-hero">@yield ('hero')</section>
        @endif

        <main class="sf-page py-4 py-lg-5">
            <div class="container">
                <x-storefront.flash />
                @yield ('content')
            </div>
        </main>

        <x-storefront.footer />

        @yield ('scripts')
    </body>
</html>
