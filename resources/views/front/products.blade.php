@include('layouts.front-navbar')
<div class="search-modal-container" id="search_modal">
    <div class="search-modal">
        <div class="row">
            <div class="col-sm-10">
                <h3 class="auth-text font-weight-bold">
                    Sort
                </h3>
            </div>
            <div class="col-sm-2 text-right" style="cursor:pointer;" onclick="toggleModal('none')">
                <h5 class="auth-text font-weight-bold">
                    X
                </h5>
            </div>
        </div>
        <form action="{{route('front.product.index',substr(url()->current(),-1))}}" method="GET">
            <div class="row my-3">
                {{-- @if (app('request')->input('price_sort') == 'desc') --}}
                <input type="radio" name="price_sort" id="price_sort_asc" value="desc" class="my-auto mx-3" {{app('request')->input('price_sort') == 'desc' ? "checked" : ''}}>
                <h4 class="auth-text my-auto">
                    Price: High - Low
                </h4>
            </div>
            <div class="row my-3">
                <input type="radio" name="price_sort" id="price_sort_desc" value="asc" class="my-auto mx-3" {{app('request')->input('price_sort') == 'asc' ? "checked" : ''}}>
                <h4 class="auth-text my-auto">
                    Price: Low - High
                </h4>
            </div>
            <div class="row">
                <h3 class="auth-text font-weight-bold">
                    Filter
                </h3>
            </div>
            <div class="row my-3">
                <div class="col-sm-5 text-left">
                    <h4 class="auth-text my-auto">
                        Size (Inch)
                    </h4>
                </div>
                <div class="col-sm-7 text-right">
                    <input type="text" name="size" id="size" class="search-input pl-2" value="{{app('request')->input('size')}}">
                </div>
            </div>
            @if ($category == 'Tires')
            <div class="row my-3">
                <div class="col-sm-5 text-left">
                    <h4 class="auth-text my-auto">
                        Width (mm)
                    </h4>
                </div>
                <div class="col-sm-7 text-right">
                    <input type="text" name="width" id="width" class="search-input pl-2" value={{app('request')->input('width')}}>
                </div>
            </div>
            @endif
            @if ($category != 'Tires')
            <div class="row my-3">
                <div class="col-sm-5 text-left">
                    <h4 class="auth-text my-auto">
                        Front Width (Inch)
                    </h4>
                </div>
                <div class="col-sm-7 text-right">
                    <input type="text" name="front_width" id="front_width" class="search-input pl-2" value={{app('request')->input('front_width')}}>
                </div>
            </div>
            <div class="row my-3">
                <div class="col-sm-5 text-left">
                    <h4 class="auth-text my-auto">
                        Rear Width (Inch)
                    </h4>
                </div>
                <div class="col-sm-7 text-right">
                    <input type="text" name="rear_width" id="rear_width" class="search-input pl-2" value={{app('request')->input('rear_width')}}>
                </div>
            </div>
            <div class="row my-3">
                <div class="col-sm-5 text-left">
                    <h4 class="auth-text my-auto">
                        Front Offset (ET)
                    </h4>
                </div>
                <div class="col-sm-3 text-right">
                    <input type="text" name="front_offset_low" id="front_offset_low" class="search-input pl-2" value={{app('request')->input('front_offset_low')}}>
                </div>
                <div class="col-sm-1 text-center">
                    -
                </div>
                <div class="col-sm-3 text-right">
                    <input type="text" name="front_offset_high" id="front_offset_high" class="search-input pl-2" value={{app('request')->input('front_offset_high')}}>
                </div>
            </div>
            <div class="row my-3">
                <div class="col-sm-5 text-left">
                    <h4 class="auth-text my-auto">
                        Rear Offset (ET)
                    </h4>
                </div>
                <div class="col-sm-3 text-right">
                    <input type="text" name="rear_offset_low" id="rear_offset_low" class="search-input pl-2" value={{app('request')->input('rear_offset_low')}}>
                </div>
                <div class="col-sm-1 text-center">
                    -
                </div>
                <div class="col-sm-3 text-right">
                    <input type="text" name="rear_offset_high" id="rear_offset_high" class="search-input pl-2" value={{app('request')->input('rear_offset_high')}}>
                </div>
            </div>
            <div class="row my-3">
                <div class="col-sm-5 text-left">
                    <h4 class="auth-text my-auto">
                        PCD
                    </h4>
                </div>
                <div class="col-sm-7 text-right">
                    <select
                        class="custom-select search-input pl-2"
                        name="pcd" id="pcd">
                        <option value="" {{(app('request')->input('pcd') == '') ? 'selected' : ''}}
                            disabled>
                            Choose One
                        </option>
                        <option value="0" {{(app('request')->input('pcd') == '0') ? 'selected' : ''}}>
                            4 x 100 mm</option>
                        <option value="1" {{(app('request')->input('pcd') == '1') ? 'selected' : ''}}>
                            4 x 108 mm</option>
                        <option value="2" {{(app('request')->input('pcd') == '2') ? 'selected' : ''}}>
                            4 x 114,3 mm</option>
                        <option value="3" {{(app('request')->input('pcd') == '3') ? 'selected' : ''}}>
                            5 x 100 mm</option>
                        <option value="4" {{(app('request')->input('pcd') == '4') ? 'selected' : ''}}>
                            5 x 108 mm</option>
                        <option value="5" {{(app('request')->input('pcd') == '5') ? 'selected' : ''}}>
                            5 x 112 mm</option>
                        <option value="6" {{(app('request')->input('pcd') == '6') ? 'selected' : ''}}>
                            5 x 114,3 mm</option>
                        <option value="7" {{(app('request')->input('pcd') == '7') ? 'selected' : ''}}>
                            5 x 120 mm</option>
                        <option value="8" {{(app('request')->input('pcd') == '8') ? 'selected' : ''}}>
                            5 x 127 mm</option>
                        <option value="9" {{(app('request')->input('pcd') == '9') ? 'selected' : ''}}>
                            5 x 130 mm</option>
                        <option value="10" {{(app('request')->input('pcd') == '10') ? 'selected' : ''}}>
                            5 x 139,7 mm</option>
                        <option value="11" {{(app('request')->input('pcd') == '11') ? 'selected' : ''}}>
                            5 x 165,1 mm</option>
                        <option value="12" {{(app('request')->input('pcd') == '12') ? 'selected' : ''}}>
                            6 x 114,3 mm</option>
                        <option value="13" {{(app('request')->input('pcd') == '13') ? 'selected' : ''}}>
                            6 x 139,7 mm</option>
                    </select>
                </div>
            </div>
            @endif
            <div class="row my-3 mt-5">
                <div class="col-sm-5 text-left">
                    <input type="text" name="price_low" id="price_low" class="search-input pl-2" placeholder="Price : Low" value={{app('request')->input('price_low')}}>
                </div>
                <div class="col-sm-2">
                    <h4 class="auth-text my-auto text-center">
                        -
                    </h4>
                </div>
                <div class="col-sm-5 text-right">
                    <input type="text" name="price_high" id="price_high" class="search-input pl-2" placeholder="Price : High" value={{app('request')->input('price_high')}}>
                </div>
            </div>
            <div class="row justify-content-center mt-5">
                <div class="col-sm-4">
                    <button class="btn btn-brand w-100">
                        <h3 class="my-auto">
                            Search
                        </h3>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="container-fluid pt-5">
    <div class="row text-center">
        <div class="col-sm-12">
            <h1 class="display-3">{{$category ? $category : 'Products'}}</h1>
        </div>
    </div>
    <div class="row justify-content-end mx-5 pr-5">
        <div class="col-sm-6">
            <form action="{{route('front.product.index',substr(url()->current(),-1))}}" method="GET">
                <div class="input-group inputgrupSmall">
                  <input value="" type="text" name="search_title" id="search_title" class="form-control " placeholder="Search Products" required>
                  <div class="input-group-append">
                    <span class="input-group-text">
                        <button style="border: none; padding: 0;">
                            <i class="fas fa-search"></i>
                        </button>
                    </span>
                  </div>
                </div>
            </form>
        </div>
        <div class="col-sm-3">
            <div class="row justify-content-end">
                <div class="col-sm-3">
                    <h4 class="text-right" style="color:grey; cursor:pointer;" onclick="toggleModal('block')">
                        <i class="fas fa-filter brand-text"></i>
                        filter
                    </h4>
                </div>
            </div>
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
                        <img class="img-fluid card-img-top" src="{{asset('img/images/products/'.$product->product_thumbnail)}}">
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
<script>
    function toggleModal(display){
        document.getElementById('search_modal').style.display = display;
    }
</script>