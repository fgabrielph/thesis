@extends ('site.layouts.storefront')

@section ('title') Home @endsection

@section ('hero')
    <div id="storefrontHero" class="carousel slide carousel-fade" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button
                type="button"
                data-bs-target="#storefrontHero"
                data-bs-slide-to="0"
                class="active"
                aria-current="true"
                aria-label="Slide 1"
            ></button>
            <button type="button" data-bs-target="#storefrontHero" data-bs-slide-to="1" aria-label="Slide 2"></button>
        </div>

        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="/assets/images/factory.jpg" class="d-block w-100" alt="New MJC fabrication floor" />
            </div>
            <div class="carousel-item">
                <img src="/assets/images/factory2.jpg" class="d-block w-100" alt="New MJC workshop" />
            </div>
        </div>

        <button
            class="carousel-control-prev"
            type="button"
            data-bs-target="#storefrontHero"
            data-bs-slide="prev"
        >
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button
            class="carousel-control-next"
            type="button"
            data-bs-target="#storefrontHero"
            data-bs-slide="next"
        >
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
@endsection

@section ('content')
    <div class="row align-items-center g-4">
        <div class="col-md-6">
            <img src="/assets/images/bldg.jpg" class="img-fluid rounded" alt="New MJC building" />
        </div>
        <div class="col-md-6">
            <h1 class="h3 mb-3">About New MJC</h1>

            <p>
                The firm started its operations in 1978 as a trading company with office at G. Santiago St. , Obrero in
                Tondo, Manila. Through the years, it has developed a market-base in auto spare parts and industrial
                fabrications, earning a niche as a major player in the industry.
            </p>

            <p class="mb-0">
                In 1983, the company established a fabrication plant in F. Aguilar St. in the same community. To further
                its expansion, it relocated to a bigger area in its current 400 sq. meter plant in Marulas, Valenzuela
                Metro Manila.
            </p>
        </div>
    </div>

    <hr class="my-5" />

    <h2 class="h4 text-center mb-4">Services Offered</h2>

    <div class="row g-4">
        <div class="col-lg-4 col-md-6">
            <img src="/assets/images/metal sheet.jpg" class="img-fluid rounded sf-service-image" alt="Metal fabrication" />
            <p class="text-center mt-3 mb-0">Metal Fabrication</p>
        </div>
        <div class="col-lg-4 col-md-6">
            <img src="/assets/images/mould making.jpg" class="img-fluid rounded sf-service-image" alt="Mold making" />
            <p class="text-center mt-3 mb-0">Mold Making</p>
        </div>
        <div class="col-lg-4 col-md-6">
            <img src="/assets/images/Lathe Machine.jpg" class="img-fluid rounded sf-service-image" alt="Lathe machine works" />
            <p class="text-center mt-3 mb-0">Lathe Machine Works</p>
        </div>
    </div>
@endsection
