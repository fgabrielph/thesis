@extends('site.master')

@section('title') Inquire Form @endsection

@section('content')

    <div class="container">
        @include('site.includes.messages')
        <div class="card">
            <div class="card-header white-text" style="background: #000;">
                <div class="col-6">
                    <h3 class="page-header"><i class="fa fa-globe"></i> Inquire for Custom Order</h3>
                </div>
            </div>
            <div class="card-body">
                <form action="{{route('inquiry')}}" class="border border-light p-5" method="POST" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <label for="textInput">Name</label>
                    <input type="text" id="defaultContactFormName" class="form-control mb-4" name="name" placeholder="Name">

                    <label for="textInput">Contact Number</label>
                    <input type="text" id="textInput" name="contactnum" class="form-control mb-4">
                    <br>
                    <div class="row">
                        <div class="col-md-2">
                        </div>
                        <div class="col-md-8">
                            <img id="img" src="{{url('../assets/images/noimage.jpg')}}" class="img-fluid rounded mx-auto d-block"/>
                        </div>
                        <div class="col-md-2">
                        </div>
                    </div>
                    <br>
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Upload</span>
                        </div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="fileInput" name="image" aria-describedby="fileInput">
                            <label class="custom-file-label" for="fileInput">Choose a file</label>
                        </div>
                    </div>
                    <label for="textInput">Description <b><i style="color: red">*Please include the Quantity of your order.</i></b></label>
                    <textarea class="form-control rounded-0" id="exampleFormControlTextarea2" rows="3" name="description" placeholder="Description"></textarea>

                    <br>

                    <input name="_method" type="hidden" value="PUT">
                    <button class="btn peach-gradient btn-block" type="submit">Send</button>
                </form>

            </div>
        </div>
    </div>

@endsection

@section('footer')

    <!--Footer-->
    <footer class="page-footer text-center font-small mt-4 wow fadeIn">

        <div class="orange">
            <!--Call to action-->
            <div class="pt-3">
                <a class="btn btn-outline-white" href="#" role="button">Contacts</a>
            </div>
            <!--/.Call to action-->

            <!--Copyright-->
            <div class="footer-copyright py-3 black">
                © 2019 Copyright:
                <a href="#" target="_blank"> New MJC </a>
            </div>
            <!--/.Copyright-->

        </div>


    </footer>
    <!--/.Footer-->

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

        $("#fileInput").change(function () {
            readURL(this);
        });
    </script>
@endsection
