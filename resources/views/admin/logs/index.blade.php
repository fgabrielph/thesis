@extends('admin.master')

@section('title') Logs @endsection

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Logs</h1>
                    <p>list of logs</p>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Logs</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0" style="margin: 1%">
                            <table id="defTable" class="table table-hover">
                                <thead class="thead-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>User Name</th>
                                    <th>Action</th>
                                    <th>Date and Time</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($logs as $log)
                                    <tr>
                                        <td>{{$log->id}}</td>
                                        <td>
                                            @if($log->admin == null)
                                                {{$log->staff->name}}
                                            @else
                                                {{$log->admin->name}}
                                            @endif
                                        </td>
                                        <td>{{$log->action}}</td>
                                        <td>{{$log->created_at->format('Y M d h:i:s')}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
