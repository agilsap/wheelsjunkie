@include('layouts.front-navbar')
<div class="container-fluid d-flex justify-content-center">
    <div class="row">
        <div class="col-md-4 text-center my-auto mx-auto">
            <img class="img-fluid pt-5" src="{{asset('asset/landing_icon.png')}}" alt="">
        </div>
        <div class="col-md-6 my-auto mx-auto">
            <div class="row text-center">
                <h1 class="landing-primary-text"><strong>Bored with your rims?</strong></h1>
            </div>
            <div class="row">
                <p class="landing-secondary-text">
                    Wheels Junkie helps people buy or sell rims or tires
                </p>
            </div>
            <div class="row justify-content-center">
                <a href="{{ route('front.categories',-1) }}" class="nav-link btn btn-brand landing-btn">Shop Now</a>
                <a href="{{ route('products.index') }}" class="nav-link btn btn-brand landing-btn">Sell Now</a>
            </div>
        </div>
    </div>
</div>