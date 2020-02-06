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
                <form class="border border-light p-5">

                    <input type="text" id="defaultContactFormName" class="form-control mb-4" placeholder="Name">

                    <input type="email" id="defaultContactFormEmail" class="form-control mb-4" placeholder="E-mail">

                    <label for="textInput">Item Name</label>
                    <input type="text" id="textInput" class="form-control mb-4">

                    <input class="form-control input-md" placeholder="0" name="quantity" type="number" value="">
                    <br>
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Upload</span>
                        </div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="fileInput" aria-describedby="fileInput">
                            <label class="custom-file-label" for="fileInput">File Label</label>
                        </div>
                    </div>

                    <textarea class="form-control rounded-0" id="exampleFormControlTextarea2" rows="3" placeholder="Message"></textarea>

                    <div class="custom-control custom-checkbox mb-4">
                        <input type="checkbox" class="custom-control-input" id="defaultContactFormCopy">
                        <label class="custom-control-label" for="defaultContactFormCopy">Send me a copy of this message</label>
                    </div>

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
