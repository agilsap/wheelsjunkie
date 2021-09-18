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
                            <h1 class="m-0">Deliveries</h1>
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
                            <li class="breadcrumb-item active">Deliveries</li>
                          </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card m-3">
                <div class="card-body p-5">
                    <table class="table table-bordered table-striped w-100">
                        <thead>
                            <tr>
                                <th>
                                    Transaction ID
                                </th>
                                <th>
                                    Seller
                                </th>
                                <th>
                                    Product
                                </th>
                                <th>
                                    Courier
                                </th>
                                <th>
                                    Receipt Number
                                </th>
                                <th>
                                    Delivery Status
                                </th>
                                <th>
                                    Checkout Time
                                </th>
                                <th>
                                    Status Update Time
                                </th>
                                <th>
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($transactions as $key => $transaction)
                            <tr>
                                <td>
                                    {{$transaction->transaction_id}}
                                </td>
                                <td>
                                    {{$transaction->seller->name}}
                                </td>
                                <td>
                                    {{$transaction->product->product_name}}
                                </td>
                                <td>
                                    {{$transaction->delivery->courier_name}}
                                </td>
                                <td>
                                    {{$transaction->delivery->receipt_number}}
                                </td>
                                <td>
                                    {{$transaction->delivery->status}}
                                </td>
                                <td>
                                    {{$transaction->created_at}}
                                </td>
                                <td>
                                    {{$transaction->updated_at}}
                                </td>
                                <td>
                                    <a class="btn btn-brand {{$transaction->can_receive ? '':'bg-danger'}}" href="{{$transaction->can_receive ? route('transaction.received',$transaction->transaction_id):null}}"
                                        style="{{$transaction->can_receive ? '' : 'cursor:not-allowed;'}}">
                                        Product Received
                                    </a>
                                </td>
                            </tr>
                            @empty
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
    <script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('plugins/chart.js/Chart.min.js')}}"></script>
    <script src="{{asset('plugins/sparklines/sparkline.js')}}"></script>
    <script src="{{asset('plugins/jqvmap/jquery.vmap.min.js')}}"></script>
    <script src="{{asset('plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
    <script src="{{asset('plugins/jquery-knob/jquery.knob.min.js')}}"></script>
    <script src="{{asset('plugins/moment/moment.min.js')}}"></script>
    <script src="{{asset('plugins/daterangepicker/daterangepicker.js')}}"></script>
    <script src="{{asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
    <script src="{{asset('plugins/summernote/summernote-bs4.min.js')}}"></script>
    <script src="{{asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
    <script src="{{asset('dist/js/adminlte.js')}}"></script>
    <script src="{{asset('dist/js/demo.js')}}"></script>
    <script src="{{asset('dist/js/pages/dashboard.js')}}"></script>
</body>

</html>