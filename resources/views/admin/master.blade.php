
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>{{config('app.name')}} | @yield('title')</title>

    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

    @include('admin.includes.navbar')
    @include('admin.includes.sidebar')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        @yield('content')
    </div>
    <!-- /.content-wrapper -->

    @include('admin.includes.footer')

</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<script src="{{asset('js/app.js')}}"></script>
@yield('scripts')
<script>
    $(document).ready( function () {
        $('#orderTable').DataTable();

        $('#defTable').DataTable(
            {
                "order": [[0, 'desc']]
            }
        );

        $('#atkTable').DataTable(
            {
                "order": [[0, 'desc']]
            }
        );
    } );

</script>



</body>
</html>
