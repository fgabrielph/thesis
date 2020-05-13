<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{config('app.name')}} | @yield('title')</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
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
            /*background: url("/assets/images/metal.jpg")  no-repeat center center fixed;*/
            /*-webkit-background-size: cover;*/
            /*-moz-background-size: cover;*/
            /*-o-background-size: cover;*/
            /*background-size: cover;*/
            /*overflow-x: hidden;*/
        }

        #opacitybg {
            background-color: rgba(255,255,255, 0);
        }

        body::-webkit-scrollbar-track
        {
            -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
            background-color: #F5F5F5;
        }

        body::-webkit-scrollbar
        {
            width: 6px;
            background-color: #F5F5F5;
        }

        body::-webkit-scrollbar-thumb
        {
            background-color: #000000;
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

        <br><br>

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

        <script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
        <!-- Initializations -->
        <script type="text/javascript">
            // Animations initialization
            new WOW().init();
        </script>

        <script>
            $(document).ready( function () {
                $('#orderTable').DataTable(
                    {
                        "stateSave": true
                    }
                );

                $('#defTable').DataTable(
                    {
                        "order": [[0, 'desc']],
                        "stateSave": true
                    }
                );

                $('#atkTable').DataTable(
                    {
                        "order": [[0, 'desc']],
                        "stateSave": true
                    }
                );
            } );
        </script>

@yield('js')
</body>
</html>
