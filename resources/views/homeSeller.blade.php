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
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Dashboard</h1>
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
                <li class="breadcrumb-item active">Seller</li>
              </ol>
            </div>
          </div>
        </div>
      </div>
      <section class="content">
        @if($user->user_type === 'customer' && request()->is('seller'))
        @include('includes.sellerRequest')
        @elseif($user->user_type === 'seller')
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-3 col-6">
              <div class="small-box bg-info">
                <div class="inner">
                  <h3>{{$products_count}}</h3>
                  <p>Products</p>
                </div>
                <div class="icon">
                  <i class="ion ion-bag"></i>
                </div>
                @foreach ($products_preview as $item)
                <div class="small-box-footer text-left pl-2">{{$item->product_name}}</div>
                @endforeach
                <a href="{{route('products.index')}}" class="small-box-footer">More Products <i
                    class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <div class="col-lg-3 col-6">
              <div class="small-box bg-success">
                <div class="inner">
                  <h3>{{$new_orders_count}}</h3>
                  <p>New Orders</p>
                </div>
                <div class="icon">
                  <i class="fas fa-file-invoice"></i>
                </div>
                @foreach ($new_orders_preview as $item)
                <div class="small-box-footer">{{$item->buyer->name}} {{$item->product->product_name}}<i
                    class="fas fa-arrow-circle-right"></i></div>
                @endforeach
                <a href="{{route('transactions.index')}}" class="small-box-footer">More Transactions <i
                    class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <div class="col-lg-3 col-6">
              <div class="small-box bg-warning">
                <div class="inner">
                  <h3>{{$delivery_needed_count}}</h3>
                  <p>Deliver Now</p>
                </div>
                <div class="icon">
                  <i class="fas fa-truck"></i>
                </div>
                @foreach ($delivery_needed_preview as $item)
                <div class="small-box-footer">{{$item->buyer->name}} {{$item->product->product_name}}<i
                    class="fas fa-arrow-circle-right"></i></div>
                @endforeach
                <a href="{{route('transactions.index')}}" class="small-box-footer">More Delivery Needed <i
                    class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <div class="col-lg-3 col-6">
              <div class="small-box bg-primary">
                <div class="inner">
                  <h3>{{$all_transactions_count}}</h3>
                  <p>Total Transactions</p>
                </div>
                <div class="icon">
                  <i class="fas fa-shopping-cart"></i>
                </div>
                @foreach ($all_transactions_preview as $item)
                <div class="small-box-footer">{{$item->buyer->name}} {{$item->product->product_name}}<i
                    class="fas fa-arrow-circle-right"></i></div>
                @endforeach
                <a href="{{route('transactions.index')}}" class="small-box-footer">See All Transactions<i
                    class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
          </div>
        </div>
        @endif
      </section>
    </div>
    <footer class="main-footer">
      <strong><a href="/">WheelsJunkie.com </a></strong>
    </footer>
    <aside class="control-sidebar control-sidebar-dark">
    </aside>
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