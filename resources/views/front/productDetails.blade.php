@include('layouts.front-navbar')
<div class="row p-5 mx-5">
    <div class="col-lg-12">
        <div class="container-fluid">
            @if (session()->has('sukses'))
            <div class="alert alert-success alert-dismissible fade show">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <i class="icon fas fa-check"></i>
                <strong> {{ session()->get('sukses') }} </strong>
            </div>
            @endif
            @if (session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <i class="icon fas fa-exclamation-triangle"></i>
                <strong> {{ session()->get('error') }} </strong>
            </div>
            @endif
            <div class="row">
                <h2 class="text-muted font-weight-normal">
                    <strong>
                        {{$product->category}}
                    </strong>
                </h2>
            </div>
            <div class="row py-3 justify-content-between">
                <div class="col-lg-5">
                    <div class="row left-0 mr-5 my-3">
                        @foreach ($product_images as $key =>$image)
                            <a href="{{route('gallery.showGallery',$image->gallery_id)}}">
                                <img src="{{asset('img/images/products/'.$image->picture)}}" alt="" class="img-fluid imgDetail mx-auto" style="display: none;" name="slides" id={{$key}}> 
                            </a>
                        @endforeach
                    </div>
                    <div class="row left-0 mr-5 justify-content-between">
                        <input type="text" value=0 id ='index' hidden>
                        <div class="col-md-1 my-auto card py-5" onclick="slideThumbnails(-1)">
                            <div class="row mx-auto">
                                <
                            </div>
                        </div>
                        @foreach ($product_images as $key => $thumbnail)
                        <div class="col-lg-3 text-center bg-dark" style="display:none;" name="images" onclick="showImage({{$key}})">
                            <img src="{{asset('/img/images/products/'.$thumbnail->picture)}}" class="img-fluid d-block">
                        </div>
                        @endforeach
                        <div class="col-md-1 my-auto card py-5" onclick="slideThumbnails(+1)">
                            <div class="row mx-auto">
                                >
                            </div>
                        </div>
                    </div>
                    <div class="row left-0 mr-5 my-3">
                        <div class="col-lg-12 text-center">
                            <h4 class="text-muted font-weight-normal">
                                <strong id="index_of_img">
                                    1 of {{$product_images->count()}}
                                </strong>
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="row pb-3">
                        <div class="col-lg-10 p-0">
                            <h1 class="text-grey font-weight-bold">
                                {{$product->product_name}}
                            </h1>
                        </div>
                        <div class="col-lg-2 text-center pt-2">
                            <a href="{{route('products.wishlistToggle',$product->product_id)}}">
                                <h2 class="{{$product->liked ? 'text-red' : 'text-secondary'}}">
                                    <i class="fas fa-heart font-s"></i>
                                </h2>
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row pb-1">
                                <h2 class="text-grey">
                                    Rp. {{$product->price}}
                                </h2>
                            </div>
                            @if ($product->status)
                            <div class="row pb-3">
                                <h6 class="text-green">
                                    {{$product->status ? $product->status : null}} ({{$product->unit}})
                                </h6>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3">
                            @if ($product->category == "Tires")
                                <div class="row">
                                    <h5>Diameter</h5>
                                </div>
                                <div class="row">
                                    <h5>Width</h5>
                                </div>
                                <div class="row">
                                    <h5>Width Ratio</h5>
                                </div>
                            @else
                                <div class="row pb-2">
                                    <h5>Size</h5>
                                </div>
                                <div class="row pb-2">
                                    <h5>Front Width</h5>
                                </div>
                                <div class="row pb-2">
                                    <h5>Rear Width</h5>
                                </div>
                                <div class="row pb-2">
                                    <h5>Front Offset (ET)</h5>
                                </div>
                                <div class="row pb-2">
                                    <h5>Rear Offset (ET)</h5>
                                </div>
                                <div class="row pb-2">
                                    <h5>PCD</h5>
                                </div>
                                @if ($product->pcd_2)
                                <div class="row pb-2">
                                    <h5>&nbsp;</h5>
                                </div>
                                @endif
                            @endif
                            <div class="row pb-1">
                                <h5>Condition</h5>
                            </div>
                            <div class="row pb-3">
                                <h5>Quantity</h5>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            @if ($product->category == "Tires")
                                <div class="row">
                                    <h5>: {{$product->tire_diameter}} Inch</h5>
                                </div>
                                <div class="row">
                                    <h5>: {{$product->tire_width}} mm</h5>
                                </div>
                                <div class="row">
                                    <h5>: {{$product->tire_width_ratio}}</h5>
                                </div>
                            @else
                                <div class="row pb-2">
                                    <h5>: {{$product->rim_diameter}} Inch</h5>
                                </div>
                                <div class="row pb-2">
                                    <h5>: {{$product->front_rim_width}} Inch</h5>
                                </div>
                                <div class="row pb-2">
                                    <h5>: {{$product->rear_rim_width}} Inch</h5>
                                </div>
                                <div class="row pb-2">
                                    <h5>: {{$product->front_offset}}</h5>
                                </div>
                                <div class="row pb-2">
                                    <h5>: {{$product->rear_offset}}</h5>
                                </div>
                                <div class="row pb-2">
                                    <h5>: {{$product->pcd_1}}</h5>
                                </div>
                                @if ($product->pcd_2)
                                <div class="row pb-2">
                                    <h5>: {{$product->pcd_2}}</h5>
                                </div>
                                @endif
                            @endif
                            <div class="row pb-1">
                                <h5>: {{$product->condition}}</h5>
                            </div>
                            <div class="row pb-3">
                                <h5>: {{$product->quantity}} ({{$product->unit}})</h5>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card p-4 elevation-0 border border-dark rounded-0">
                                <a href="{{route('profile.view',$product->product_owner->user_id)}}">
                                <div class="row pb-3">
                                        <div class="col-lg-3">
                                            <img src="{{$product->product_owner->profile_picture ? asset('/img/images/profile/'.$product->product_owner->profile_picture) : asset('/img/images/profile/avatar.png')}}" alt="" class="img-fluid">
                                        </div>
                                        <div class="col-lg-9 my-auto">
                                            <h3 class="link-decoration-none">
                                                <strong>
                                                    {{$product->product_owner->name}}
                                                </strong>
                                            </h3>
                                        </div>
                                    </div>
                                </a>
                                <div class="row">
                                    <div class="col-lg-12">
                                            <h5>Location :</h5>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <h5><i class="fas fa-map-marker-alt" style='color:#1d1dd6;'></i> {{$product->delivery_from->city}}</h5>
                                    </div>
                                </div>
                                <div class="row my-2">
                                    <div class="col-lg-12 text-center">
                                        <a href="{{route('message.indexProduct',$product->product_id)}}" class="btn w-100 purple-brand text-light pt-3 mx-auto border-radius-front-square">
                                            <h3 class="font-weight-bold">
                                                <i class="fas fa-comment mr-2"></i>
                                                Chat
                                            </h3>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row pb-2">
                        <h5>Descriptions :</h5>
                    </div>
                    <div class="row">
                        <div class="card p-4 elevation-0 border border-dark rounded-0">
                            {{$product->description}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 mr-3">
                            <a href="{{route('products.addToCart',$product->product_id)}}" class="btn w-100 bg-white pt-3 mx-auto border-radius-front btn-brand-reverse">
                                <h4 class="font-weight-bold">
                                    <i class="fas fa-shopping-cart mr-2"></i>
                                    Add to Cart
                                </h4>
                            </a>
                        </div>
                        <div class="col-lg-4">
                            <a href="{{route('products.buyNow',$product->product_id)}}" class="btn w-100 purple-brand btn-text-color pt-3 mx-auto border-radius-front btn-brand-hover">
                                <h4 class="font-weight-bold">
                                    <i class="fas fa-shopping-basket"></i>
                                    Buy Now
                                </h4>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(window).on('load',combinedFunctions());
    function combinedFunctions(){
        slideThumbnails(0);
        showImage(0);
    }
    function slideThumbnails(move){
        var images = document.getElementsByName('images');
        var index = parseInt($('#index').val());
        if(index<=0){
            index = 0;
        }
        var newIndex = index + move;
        if(newIndex<0){
            newIndex=0;
        }
        if(newIndex>=(images.length/3)){
            newIndex = index;
        }
        var rangeR = ((newIndex+1)*3)-1;
        var rangeL = rangeR-2;
        if(images.length < 4){
            rangeR = 2;
            rangeL = 0;
            newIndex = 0;
        }
        console.log(images,index,newIndex,rangeL, rangeR, images.length);
        for(var i = 0; i<images.length; i++){
            if(i<=rangeR && i>=rangeL){
                images[i].style.display="block";
            }else{
                images[i].style.display = "none";
            }
        }
        $('#index').val(parseInt(newIndex));
    }
    function showImage(index){
        var images = document.getElementsByName('slides');
        for(var i = 0; i<images.length; i++){
            images[i].style.display = "none";
        }
        var show = document.getElementById(index);
        show.style.display="block";
        var string_idx_of = parseInt(index+1)+" of "+parseInt(images.length);
        document.getElementById('index_of_img').innerHTML = string_idx_of;
    }
</script>