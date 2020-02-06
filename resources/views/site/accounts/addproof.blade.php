@extends('site.master')

@section('title') Add Proof of Payment @endsection

@section('content')
    <div class="container">
        @include('site.includes.messages')
        <div class="card">
            <div class="card-header">
                <div class="col-6">
                    <h3 class="page-header"><i class="fa fa-globe"></i> Upload Image</h3>
                </div>
            </div>
            <form action="{{ route('proof.upload', $order->id) }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
                        </div>
                        <div class="col-md-8">
                            @if($order->image == null)
                                <img id="img" src="{{url('../assets/images/error-img.png')}}" class="img-fluid rounded mx-auto d-block"/>
                            @else
                                <img id="img" src="/storage/assets/images/medium_thumbnail/{{$order->image}}" class="img-fluid rounded mx-auto d-block" />
                            @endif
                        </div>
                        <div class="col-md-2">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-2">
                        </div>
                        <div class="col-md-8">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                                </div>
                                <div class="custom-file">
                                    <input name="image" type="file" class="custom-file-input" id="imgInp" aria-describedby="inputGroupFileAddon01">
                                    <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="{{route('orders.index')}}" class="btn btn-amber btn-lg">Go Back</a>
                        </div>

                        <div class="col-md-6 text-right">
                            <input name="_method" type="hidden" value="PUT">
                            <input type="submit" class="btn btn-primary btn-lg" value="Submit">
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
@endsection

@section('js')
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    document.getElementById('img').src = e.target.result;
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#imgInp").change(function () {
            readURL(this);
        });
    </script>
@endsection
