@include('layouts.front-navbar')
<div class="container-fluid p-5">
    <div class="row justify-content-center mx-5">
        <div class="col-sm-8">
            <div class="row page-title">
                Checkout
            </div>
            <div class="row my-2 pb-2 checkout-card-bottom-border">
                <div class="col-sm-6">
                    <div class="row mt-3 checkout-card-title-bg">
                        <i class="fas fa-house-user my-auto"></i>
                        &nbsp;&nbsp; Address
                    </div>
                    <div class="row mt-3">
                        <text class="checkout-card-highlight">{{$user->name}}</text>&nbsp;&nbsp; ({{$user->email}})
                    </div>
                    <div class="row">
                        {{$user->mobile_number}}
                    </div>
                    <div class="row">
                        {{$user->address}}
                    </div>
                    <div class="row">
                        {{$user->location->city}}, {{$user->location->province}}, {{$user->location->zip_code}}
                    </div>
                </div>
            </div>
            <div class="row justify-content-between my-2 pb-3 checkout-card-bottom-border">
                <div class="col-sm-5">
                    <div class="row py-3">
                        <div class="col-sm-1checkout-card-title text-center my-auto">
                            <i class="fas fa-store fa-2x brand-text"></i>
                        </div>
                        <div class="col-sm-6">
                            <div class="row checkout-card-title">
                                &nbsp;&nbsp; {{$product->product_owner->name}}
                            </div>
                            <div class="row ml-1">
                                {{$product->product_owner->mobile_number}}
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-start">
                        <div class="col-sm-12">
                            <div class="row justify-content-start">
                                <div class="col-sm-4">
                                    <div class="row justify-content-center ">
                                        <div class="col-sm-12">
                                            <img src="{{asset('/img/images/products/'.$product->product_thumbnail)}}" alt="product thumbnail" class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 ml-3">
                                    <div class="row checkout-card-highlight pb-1">
                                        {{$product->product_name}}
                                    </div>
                                    <div class="row pb-3">
                                        <small>
                                            {{$buy_now_qty}} ({{$buy_now_unit}}) / {{$product->weight}} (Kg)
                                        </small>
                                    </div>
                                    <div class="row checkout-card-price">
                                        <strong>Rp{{$product->price}}</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-5 pt-4">
                    <div class="row checkout-card-title-bg">
                        <i class="fas fa-truck my-auto"></i>
                        &nbsp;&nbsp; Shipment
                    </div>
                    <div class="row mt-3 ml-1">
                        Ship from {{$product->delivery_from->city}},{{$product->delivery_from->province}} to {{$product->delivery_from->city}},{{$user->location->province}}
                    </div>
                    <div class="row checkout-card-price ml-1">
                        Rp 0
                    </div>
                </div>
            </div>
            <div class="row justify-content-start">
                <div class="col-sm-12 pt-4">
                    <div class="row checkout-card-title">
                        Cost Summary
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            Product Subtotal
                        </div>
                        <div class="col-sm-6">
                            : <text class="checkout-card-highlight">Rp{{$product->price}}</text>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            Shipment Subtotal
                        </div>
                        <div class="col-sm-6">
                            : <text class="checkout-card-highlight">Rp 0</text>
                        </div>
                    </div>
                    <div class="row mt-5 py-3 checkout-card-bottom-border checkout-card-top-border justify-content-around">
                        <div class="col-sm-6">
                            <h1 class="font-weight-bold">TOTAL : Rp{{$product->price}}</h1>
                        </div>
                        <div class="col-sm-4 my-auto">
                            <a href="{{route('products.payment',$product->product_id)}}" class="btn btn-brand checkout-btn w-100">
                                Buy
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>