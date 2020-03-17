@extends('site.master')

@section('title') About @endsection

@section('others') @include('site.includes.carousel') @endsection

@section('content')

    <div class="container dark-grey-text mt-5">

        <!--Grid row-->
        <div class="row wow fadeIn">

            <!--Grid column-->
            <div class="col-md-6 mb-4">

                <img src="../assets/images/tool and dye making.jpg" class="img-fluid" alt="">

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

                    <br>

                </div>
                <!--Content-->

            </div>
            <!--Grid column-->

        </div>
        <!--Grid row-->
        <!--Grid row-->
        <div class="row wow fadeIn">

            <!--Grid column-->
            <div class="col-md-6 mb-4">

                <p class="lead font-weight-bold">Location</p>

                <p>- 1101, D. Gomez Street, Barrio Obrero, Tondo, City of Manila, Metro Manila
                </p> <br>


                <pre>
                Sunday:         closed <br>
                Monday:         08:00am - 05:00pm <br>
                Tuesday:        08:00am - 05:00pm <br>
                Wednesday:      08:00am - 05:00pm <br>
                Thursday:       08:00am - 05:00pm <br>
                Friday:         08:00am - 05:00pm <br>
                Saturday:       08:00am - 05:00pm <br>
                </pre><br>

                <p>
                    At this point of time, the company’s continuous development made way to opening a plant for spring production along A C. Herrera St. in Manila.

                    Currently, the company is one of the well known distributors and manufacturers of wide range automotive and industrial supplies. Covering a vast clientele from various businesses and handling numerous projects nationwide.

                    “Here at New MJC, we make things EASIER FOR YOU by offering INNOVATIVE IDEAS , SOLUTIONS and TECHNICAL ASSITANCE for you Product Development accompanied with FAST Delivery and EFFICIENT Service.”
                </p>



            </div>
            <!--Grid column-->

            <!--Grid column-->
            <div class="col-md-6 mb-4">

                <!--Content-->
                <div class="p-4">

                    <img src="../assets/images/bldg.jpg" class="img-fluid" alt="">

                </div>
                <!--Content-->

            </div>
            <!--Grid column-->

        </div>
        <!--Grid row-->


    </div>

    <hr>

{{--    <div class="container dark-grey-text mt-5">--}}
{{--        <!--Grid row-->--}}
{{--        <div class="row d-flex justify-content-center wow fadeIn dark-grey-text">--}}

{{--            <!--Grid column-->--}}
{{--            <div class="col-md-6 text-center">--}}

{{--                <h4 class="my-4 h4">Services Offered</h4>--}}

{{--                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Natus suscipit modi sapiente illo soluta odit--}}
{{--                    voluptates,--}}
{{--                    quibusdam officia. Neque quibusdam quas a quis porro? Molestias illo neque eum in laborum.</p>--}}

{{--            </div>--}}
{{--            <!--Grid column-->--}}

{{--        </div>--}}
{{--        <!--Grid row-->--}}

{{--        <!--Grid row-->--}}
{{--        <div class="row wow fadeIn">--}}

{{--            <!--Grid column-->--}}
{{--            <div class="col-lg-4 col-md-12 mb-4">--}}

{{--                <img src="../assets/images/metal sheet.jpg" class="img-fluid" alt="">--}}

{{--            </div>--}}
{{--            <!--Grid column-->--}}

{{--            <!--Grid column-->--}}
{{--            <div class="col-lg-4 col-md-6 mb-4">--}}

{{--                <img src="../assets/images/mould making.jpg" class="img-fluid" alt="">--}}

{{--            </div>--}}
{{--            <!--Grid column-->--}}

{{--            <!--Grid column-->--}}
{{--            <div class="col-lg-4 col-md-6 mb-4">--}}

{{--                <img src="../assets/images/Lathe Machine.jpg" class="img-fluid" alt="">--}}

{{--            </div>--}}
{{--            <!--Grid column-->--}}
{{--        </div>--}}
{{--    </div>--}}

@endsection

@section('footer')

    @include('site.includes.footer')

@endsection

