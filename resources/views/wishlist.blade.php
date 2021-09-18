@include('layouts.head')

<body class="hold-transition sidebar-mini layout-fixed sidebar-collapse">
    <div class="wrapper">
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="{{asset('asset/Navbar_logo.png')}}" alt="AdminLTELogo">
        </div>

        @include('layouts.navbar')
        @include('layouts.sidebar')

        <div class="content-wrapper">
            <div class="content-header">
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
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Wishlist</h1>
                        </div>
                        <div class="col-sm-6">
                          <ol class="breadcrumb float-sm-right">
                            @if ($user->user_type == 'customer')
                              <li class="breadcrumb-item"><a href="{{route('home.customer')}}">Home</a></li>
                            @elseif($user->user_type == 'seller')
                              <li class="breadcrumb-item"><a href="{{route('home.seller')}}">Home</a></li>
                            @elseif($user->user_type == 'admin' || $user->user_type == 'principal')
                              <li class="breadcrumb-item"><a href="{{route('home.admin')}}">Home</a></li>
                            @endif
                            <li class="breadcrumb-item active">Wishlist</li>
                          </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body p-0">
                    <table class="table table-striped projects">
                        <tbody>
                            @forelse($products as $product)
                            <tr>
                                <td>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <a href="{{route('products.details',$product->product_id)}}">
                                                <img class="img-fluid imgProp mx-auto d-block" src="{{asset($product->product_thumbnail ? 'img/images/products/'.$product->product_thumbnail : '')}}">
                                            </a>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <p class="text-secondary">{{$product->category}}</p>
                                                    {{-- <h5 class="titleProp">tester</h5> --}}
                                                    <a href="{{route('products.details',$product->product_id)}}">
                                                        <h5 class="priceProp">
                                                            <strong> {{$product->product_name}} - Rp.{{$product->price}}
                                                            </strong>
                                                        </h5>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p class="lineMarg">Quantity : {{$product->quantity}} {{$product->unit}}</p>
                                                    <p class="lineMarg">Diameter : {{$product->category == 'Wheels' ? $product->tire_diameter : $product->rim_diameter}}</p>
                                                    <p class="lineMarg">Status : {{$product->status ? $product->status : 'Available'}}</p>
                                                    <p class="lineMarg">{{$product->description}}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <a href="{{route('profile.view',$product->product_owner->user_id)}}">
                                                        <p class="pt-5">Product Owner : {{$product->product_owner->name}}</p>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 text-right">
                                            @if (!$product->is_deleted)
                                            <a class="btn btn-warning text-white btn-flat btn-edit" href="{{route('products.addToCart',$product->product_id)}}">
                                                <i class="fas fa-shopping-cart mr-2"></i>
                                                </i>
                                                Add To Cart
                                            </a>
                                            <a class="btn btn-success rounded btn-flat" href="{{route('products.buyNow',$product->product_id)}}">
                                                <i class="fas fa-shopping-basket"></i>
                                                </i>
                                                Buy Now
                                            </a>
                                            <a class="btn btn-danger rounded btn-flat" href="{{route('products.wishlistToggle',$product->product_id)}}">
                                                <i class="fas fa-trash">
                                                </i>
                                                Remove
                                            </a>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <div class="jumbotron jumbotronEmpty text-center">
                                <p>No Items Found</p>
                            </div>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <footer class="main-footer">
            <strong><a href="/">WheelsJunkie.com </a></strong>
        </footer>
    </div>

    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="plugins/jquery-ui/jquery-ui.min.js"></script>
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="plugins/chart.js/Chart.min.js"></script>
    <script src="plugins/sparklines/sparkline.js"></script>
    <script src="plugins/jqvmap/jquery.vmap.min.js"></script>
    <script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
    <script src="plugins/jquery-knob/jquery.knob.min.js"></script>
    <script src="plugins/moment/moment.min.js"></script>
    <script src="plugins/daterangepicker/daterangepicker.js"></script>
    <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <script src="plugins/summernote/summernote-bs4.min.js"></script>
    <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <script src="dist/js/adminlte.js"></script>
    <script src="dist/js/demo.js"></script>
    <script src="dist/js/pages/dashboard.js"></script>
</body>

</html>