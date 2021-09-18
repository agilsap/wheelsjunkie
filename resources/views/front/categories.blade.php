@include('layouts.front-navbar')
<div class="container-fluid d-flex justify-content-center">
    <div class="row h-100 my-5">
        @if ($type == "index")
            <div class="col-md-5 my-auto mx-auto pt-5">
                <a href="{{route('front.categories',10)}}">
                    <img class="img-fluid" src="{{asset('asset/rims_category.png')}}" alt="rims">
                </a>
            </div>
            <div class="col-md-5 my-auto mx-auto pt-5">
                <a href="{{route('front.categories',3)}}">
                    <img class="img-fluid" src="{{asset('asset/tires_category.png')}}" alt="tires">
                </a>
            </div>
        @else
            <a href="{{route('front.categories',0)}}" class="col-md-3 card border border-dark justify-content-center m-5 category-card bg-light">
                    <div class="row">
                        <div class="col-md-12 my-auto text-center">
                            <h1 class="display-1 font-weight-bold">
                                Replica
                            </h1>
                        </div>
                    </div>
            </a>
            <a href="{{route('front.categories',1)}}" class="col-md-3 card border border-dark justify-content-center m-5 category-card bg-light">
                    <div class="row">
                        <div class="col-md-12 my-auto text-center">
                            <h1 class="display-1 font-weight-bold">
                                Original
                            </h1>
                        </div>
                    </div>
                </a>
            <a href="{{route('front.categories',2)}}" class="col-md-3 card border border-dark justify-content-center m-5 category-card bg-light">
                    <div class="row">
                        <div class="col-md-12 my-auto text-center">
                            <h1 class="display-1 font-weight-bold">
                                OEM
                            </h1>
                        </div>
                    </div>
                </a>
        @endif
    </div>
</div>