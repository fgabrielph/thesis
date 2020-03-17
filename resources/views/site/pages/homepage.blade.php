@extends('site.master')

@section('title') Home @endsection

@section('others') @include('site.includes.carousel') @endsection

@section('content')


    <div class="container dark-grey-text mt-5">

        <!--Grid row-->
        <div class="row wow fadeIn">

            <!--Grid column-->
            <div class="col-md-6 mb-4">

                <img src="../assets/images/bldg.jpg" class="img-fluid" alt="">

            </div>
            <!--Grid column-->

            <!--Grid column-->
            <div class="col-md-6 mb-4">

                <!--Content-->
                <div class="p-4">

                    <p class="lead font-weight-bold">About New MJC</p>

                    <p>The firm started its operations in 1978 as a trading company with office at G. Santiago St. , Obrero in Tondo, Manila.
                        Through the years, it has developed a market-base in auto spare parts and industrial fabrications,
                        earning a niche as a major player in the industry.
                    </p> <br>

                    <p>In 1983, the company established a fabrication plant in F. Aguilar St. in the same community. To further its expansion,
                        it relocated to a bigger area in its current 400 sq. meter plant in Marulas, Valenzuela Metro Manila.
                    </p>

                </div>
                <!--Content-->

            </div>
            <!--Grid column-->

        </div>
        <!--Grid row-->


    </div>

    <hr>

    <div class="container dark-grey-text mt-5">
        <!--Grid row-->
        <div class="row d-flex justify-content-center wow fadeIn dark-grey-text">

            <!--Grid column-->
            <div class="col-md-6 text-center">

                <h4 class="my-4 h4">Services Offered</h4>

            </div>
            <!--Grid column-->

        </div>
        <!--Grid row-->

        <!--Grid row-->
        <div class="row wow fadeIn">

            <!--Grid column-->
            <div class="col-lg-4 col-md-12 mb-4">

                <img src="../assets/images/metal sheet.jpg" class="img-fluid" alt=""><br><br>
                <div class="text-center">Metal Fabrication</div>

            </div>
            <!--Grid column-->

            <!--Grid column-->
            <div class="col-lg-4 col-md-6 mb-4">

                <img src="../assets/images/mould making.jpg" class="img-fluid" alt=""><br><br>
                <div class="text-center">Mold Making</div>

            </div>
            <!--Grid column-->

            <!--Grid column-->
            <div class="col-lg-4 col-md-6 mb-4">

                <img src="../assets/images/Lathe Machine.jpg" class="img-fluid" alt=""><br><br>
                <div class="text-center">Lathe Machine Works</div>

            </div>
            <!--Grid column-->
        </div>
    </div>

@endsection

@section('footer')

    @include('site.includes.footer')

@endsection
