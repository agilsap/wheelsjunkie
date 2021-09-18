@include('layouts.front-navbar')
<div class="container-fluid pt-5">
    <div class="row text-center mx-5">
        <div class="col-sm-3">
            <img src="{{$user->profile_picture ? asset('img/images/profile/'.$user->profile_picture) : asset('/img/images/profile/avatar.png')}}" alt="" class="img-fluid rounded-circle img-profile">
        </div>
        <div class="col-sm-8 my-auto text-left">
            <h1 class="display-3 ml-3 auth-text font-weight-normal">{{$user->name}}</h1>
            <h3 class="auth-text ml-3">{{$user->location->city}}</h3>
            @if ($editable)
            <button class="btn btn-edit-profile">
                Edit Profile
            </button>
            @endif
        </div>
    </div>
</div>
<div class="container-fluid pt-5 pl-5 pr-5 ">
    <div class="row">
        @forelse ($products as $product)
        <div class="col-lg-4 col-xl-3 col-sm-6 text-center">
            <a href="{{route('front.product.details',$product->product_id)}}" class="bg-light">
                <div class="property cus-card card mx-auto">
                    <div class="placeholder-item thumbnail-card">
                        <img class="card-img-top img-fluid" src="{{asset('img/images/products/'.$product->product_thumbnail)}}">
                    </div>
                    <div class="card-body my-auto">
                        <div class="cus-h row p-2">
                            <div class="col-md-12">
                                <div class="text-center">
                                    <h2 class="font-weight-bold">
                                        {{$product->product_name}}
                                    </h2>
                                </div>
                            </div>
                        </div>
                        <div class="cus-h row">
                            <div class="col-md-12">
                                <div class="text-center">
                                    <div class="loc_text">
                                        <h5 class="">
                                            Rp {{$product->price}}
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="cus-h row">
                            <div class="col-md-12">
                                <div class="text-center">
                                    <div class="loc_text">
                                        <a href="">
                                            <h5>
                                                {{$product->product_owner->name}}
                                            </h5>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-white">
                        <div class="col-12">
                            <p class="font-anot text-center text-capitalize">
                            </p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @empty
        <div class="col-12 text-center">
            <p>
                No products found
            </p>
        </div>
        @endforelse
    </div>
    <div class="container-fluid py-3">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="d-flex justify-content-center">{{$products->links()}}</div>
            </div>
        </div>
    </div>
</div>