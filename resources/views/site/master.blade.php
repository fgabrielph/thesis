<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{config('app.name')}} | @yield('title')</title>
    <!-- Favicons -->
    <!-- <link href="img/favicon.png" rel="icon"> -->
    <!-- <link href="img/apple-touch-icon.png" rel="apple-touch-icon"> -->

    @include('site.includes.styles')

    <style type="text/css">
        html,
        body,
        header,
        .carousel {
            height: 60vh;
        }

        @media (max-width: 740px) {
            html,
            body,
            header,
            .carousel {
                height: 100vh;
            }
        }

        @media (min-width: 800px) and (max-width: 850px) {
            html,
            body,
            header,
            .carousel {
                height: 100vh;
            }
        }

        body {
            /*background: url("/assets/images/bg.jpg") no-repeat center center fixed;*/
            /*-webkit-background-size: cover;*/
            /*-moz-background-size: cover;*/
            /*-o-background-size: cover;*/
            /*background-size: cover;*/
            overflow-x: hidden;
        }

        #opacitybg {
            background-color: rgba(255,255,255, 1);
        }
    </style>

</head>
<body>

<div id="opacitybg">


        @include('site.includes.navbar')

        @yield('others')

        <main class="mt-5 pt-5">
            @yield('content')
        </main>
        <br>
        <!--Facebook-->
        <center><a class="btn btn-md black" type="button" role="button" style="border-radius: 100%"><i class="fab fa-facebook-f"></i></a><a class="btn btn-md black" type="button" role="button" style="border-radius: 100%"><i class="fab fa-twitter"></i></a></center>

        @yield('footer')

</div>
        <!-- SCRIPTS -->
        <!-- JQuery -->
        <script type="text/javascript" src="/assets/js/jquery-3.4.1.min.js"></script>
        <!-- Bootstrap tooltips -->
        <script type="text/javascript" src="/assets/js/popper.min.js"></script>
        <!-- Bootstrap core JavaScript -->
        <script type="text/javascript" src="/assets/js/bootstrap.min.js"></script>
        <!-- MDB core JavaScript -->
        <script type="text/javascript" src="/assets/js/mdb.min.js"></script>
        <!-- Initializations -->
        <script type="text/javascript">
            // Animations initialization
            new WOW().init();
        </script>

</body>
</html>
