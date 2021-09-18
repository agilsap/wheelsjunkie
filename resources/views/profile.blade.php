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
                            <h1 class="m-0">Profile</h1>
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
                            <li class="breadcrumb-item active">Profile</li>
                          </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card m-3">
                <div class="card-body pb-5 px-5">
                    <div class="card-header">
                        <div class="row">
                            <form action="{{route('profile.changePicture',$user->user_id)}}" method="POST" id="picture_form" enctype="multipart/form-data">
                                @csrf
                                <input type="file" id="imgupload" name="profile_picture" style="display:none" onchange="sendData()"/> 
                                <button type="submit" style="display: none;" id="sendPicture"></button>
                            </form>
                            <div class="col-sm-2">
                                <img src="{{$user->profile_picture ? asset('/img/images/profile/'.$user->profile_picture) : asset('/img/images/profile/avatar.png')}}" alt="" class="img-fluid rounded-circle img-profile-dashboard" onclick="openUploadImage()">
                            </div>
                            <div class="col-sm-6 my-auto">
                                <h1>{{$user->name}}</h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 my-5">
                        <form method="POST" action="{{ route('profile.update',$user->user_id) }}" class="row">
                            @csrf
                            <div class="col-md-5 mx-auto">
                                <div class="form-group row">
                                    <label for="name"
                                        class="col-md-4 col-form-label text-md-left">{{ __('Name') }}</label>

                                    <div class="col-md-8 mx-auto">
                                        <input id="name" type="text" placeholder="Name"
                                            class="form-control auth-input @error('name') is-invalid @enderror"
                                            name="name" value="{{ old('name') ?? $user->name }}" autocomplete="name"
                                            autofocus>

                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="email"
                                        class="col-md-4 col-form-label text-md-left">{{ __('E-Mail Address') }}</label>

                                    <div class="col-md-8 mx-auto">
                                        <input id="email" type="email"
                                            class="form-control auth-input @error('email') is-invalid @enderror"
                                            placeholder="E-mail Address" name="email"
                                            value="{{ old('email') ?? $user->email }}" autocomplete="email">

                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="mobile_number"
                                        class="col-md-4 col-form-label text-md-left">{{ __('Mobile Number') }}</label>

                                    <div class="col-md-8 mx-auto">
                                        <input id="mobile_number" type="text" placeholder="Mobile Number"
                                            class="form-control auth-input @error('mobile_number') is-invalid @enderror"
                                            name="mobile_number"
                                            value="{{ old('mobile_number') ?? $user->mobile_number }}"
                                            autocomplete="mobile_number" autofocus>

                                        @error('mobile_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password"
                                        class="col-md-4 col-form-label text-md-left">{{ __('Password') }}<strong
                                            class="required_red">*</strong></label>

                                    <div class="col-md-8 mx-auto">
                                        <input id="password" type="password" placeholder="Password"
                                            class="form-control auth-input @error('password') is-invalid @enderror"
                                            name="password" required autocomplete="new-password"">
                    
                                        @error('password')
                                        <span class=" invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password-confirm"
                                        class="col-md-4 col-form-label text-md-left">{{ __('Confirm Password') }}<strong
                                            class="required_red">*</strong></label>

                                    <div class="col-md-8 mx-auto">
                                        <input id="password-confirm" type="password" class="form-control auth-input"
                                            placeholder="Confirm Password" name="password_confirmation" required
                                            autocomplete="new-password">
                                    </div>
                                </div>
                            </div>
                            <div class="register-separator"></div>
                            <div class="col-md-5 mx-auto right-forms">
                                <div class="form-group row">
                                    <label for="province"
                                        class="col-md-4 col-form-label text-md-left">{{ __('Province') }}</label>

                                    <div class="col-md-8 mx-auto">
                                        <select id="province" name="province"
                                            class="form-control auth-input select2 @error('province') is-invalid @enderror dependentOn"
                                            style="width: 100%;">
                                            <option selected disabled>Province</option>
                                        </select>
                                        @error('province')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="city"
                                        class="col-md-4 col-form-label text-md-left">{{ __('City') }}</label>
                                    <div class="col-md-8 mx-auto">
                                        <select id="city" name="city"
                                            class="form-control auth-input select2 @error('city') is-invalid @enderror"
                                            style="width: 100%;">
                                            <option selected disabled>City</option>
                                        </select>
                                        @error('city')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="district"
                                        class="col-md-4 col-form-label text-md-left">{{ __('District') }}</label>

                                    <div class="col-md-8 mx-auto">
                                        <select id="district" name="district"
                                            class="form-control auth-input select2 @error('district') is-invalid @enderror"
                                            style="width: 100%;">
                                            <option selected disabled>District</option>
                                        </select>
                                        @error('district')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="sub_district"
                                        class="col-md-4 col-form-label text-md-left">{{ __('Sub District') }}</label>

                                    <div class="col-md-8 mx-auto">
                                        <select id="sub_district" name="sub_district"
                                            class="form-control auth-input select2 @error('sub_district') is-invalid @enderror"
                                            style="width: 100%;">
                                            <option selected disabled>Sub District</option>
                                        </select>
                                        @error('sub_district')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="zip_code"
                                        class="col-md-4 col-form-label text-md-left">{{ __('Zip Code') }}</label>

                                    <div class="col-md-8 mx-auto">
                                        <select id="zip_code" name="zip_code"
                                            class="form-control auth-input select2 @error('zip_code') is-invalid @enderror"
                                            style="width: 100%;" disabled>
                                            <option selected disabled>Zip Code</option>
                                        </select>
                                        @error('zip_code')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="address"
                                        class="col-md-4 col-form-label text-md-left">{{ __('Address') }}</label>

                                    <div class="col-md-8 mx-auto">
                                        <textarea id="address" type="text" placeholder="Address"
                                            class="form-control auth-input @error('address') is-invalid @enderror"
                                            name="address" value="{{ old('address') }}" required autocomplete="address"
                                            autofocus rows="3">{{$user->address}}</textarea>
                                        @error('address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mx-auto">
                                <button type="submit" class="auth-btn">
                                    {{ __('Update Profile') }}
                                </button>
                            </div>
                        </form>
                    </div>
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
    <script>
        $(window).on('load',populateSelectedLocation);
        function populateSelectedLocation(){
            $.ajax({
                url:"{{route('populateLocation')}}",
                method:"POST",
                data:{
                    "_token":"{{ csrf_token() }}"
                },
                success:function (data){
                    $('#province').html(data['province']);
                    $('#city').html(data['city']);
                    $('#district').html(data['district']);
                    $('#sub_district').html(data['sub_district']);
                    $('#zip_code').html(data['zip_code']);
                }
            })
        }
        $(document).ready(function () {
            $('#province').on('focus',function(e) {
                $.ajax({
                        url:"{{ route('province') }}",
                        method:"POST",
                        data: {
                            "_token":"{{ csrf_token() }}"
                    },
                    success:function (data) {
                        $('#province').html(data);
                    }
                })
            });
        });
        $(document).ready(function () {
            $('#province').on('change',function(e) {
                var val = $(this).val();
                $.ajax({
                        url:"{{ route('city') }}",
                        method:"POST",
                        data: {
                            "_token":"{{ csrf_token() }}",
                            selected:val
                    },
                    success:function (data) {
                        $('#city').empty();
                        $('#city').html(data);
                    }
                })
            });
        });
        $(document).ready(function () {
            $('#city').on('change',function(e) {
                var val = $(this).val();
                $.ajax({
                        url:"{{ route('district') }}",
                        method:"POST",
                        data: {
                            "_token":"{{ csrf_token() }}",
                            selected:val
                    },
                    success:function (data) {
                        $('#district').empty();
                        $('#district').html(data);
                    }
                })
            });
        });
        $(document).ready(function () {
            $('#district').on('change',function(e) {
                var val = $(this).val();
                $.ajax({
                        url:"{{ route('sub_district') }}",
                        method:"POST",
                        data: {
                            "_token":"{{ csrf_token() }}",
                            selected:val
                    },
                    success:function (data) {
                        $('#sub_district').empty();
                        $('#sub_district').html(data);
                    }
                })
            });
        });
        $(document).ready(function () {
            $('#sub_district').on('change',function(e) {
                var val = $(this).val();
                $.ajax({
                        url:"{{ route('zip_code') }}",
                        method:"POST",
                        data: {
                            "_token":"{{ csrf_token() }}",
                            selected:val
                    },
                    success:function (data) {
                        $('#zip_code').empty();
                        $('#zip_code').html(data);
                        console.log(data);
                    }
                })
            });
        });
        function openUploadImage(){
            $('#imgupload').trigger('click');
        }
        function sendData(){
            document.getElementById("picture_form").submit();
        }
    </script>
</body>

</html>