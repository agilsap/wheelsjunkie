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
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Users</h1>
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
                            <li class="breadcrumb-item active">Users</li>
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
                                    Name
                                </th>
                                <th>
                                    Type
                                </th>
                                <th>
                                    Email
                                </th>
                                <th>
                                    Phone Number
                                </th>
                                <th>
                                    Location
                                </th>
                                <th>
                                    Status
                                </th>
                                <th>
                                    Join Date
                                </th>
                                @if (request()->is('user/customer'))
                                <th>
                                    Seller request
                                </th>
                                @endif
                                <th>
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $key => $item)
                            <tr>
                                <td>
                                    {{$item->name}}
                                </td>
                                <td>
                                    {{$item->user_type}}
                                </td>
                                <td>
                                    {{$item->email}}
                                </td>
                                <td>
                                    {{$item->mobile_number}}
                                </td>
                                <td>
                                    {{$item->location->province}}
                                </td>
                                <td>
                                    {{$item->is_deleted ? 'Deactivated' : 'Active'}}
                                </td>
                                <td>
                                    {{$item->created_at}}
                                </td>
                                @if (request()->is('user/customer'))
                                <td>
                                    @if ($item->is_seller_request)
                                    <div class="row justify-content-center">
                                        <a href="{{route('profile.approveSellerRequest',$item->user_id)}}"
                                            class="btn-brand">
                                            Approve
                                        </a>
                                    </div>
                                    @else
                                    <div class="row justify-content-center">
                                        <button class="btn-brand btn-secondary" disabled>
                                            Approve
                                        </button>
                                    </div>
                                    @endif
                                </td>
                                @endif
                                <td>
                                    <div class="row justify-content-center">
                                        <a href="{{route('profile.delete',$item->user_id)}}" class="btn-brand">
                                            {{$item->is_deleted ? 'Activate' : 'Deactivate'}}
                                        </a>
                                    </div>
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