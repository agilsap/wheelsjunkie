@extends('layouts.auth-navbar')
@section('content')
<div class="container justify-content-center">
    <div class="row">
        <div class="col-md-12 text-center my-5">
            <h1 class="display-1">
                <strong class="font-weight-bold auth-text">
                    Sign Up
                </strong>
            </h1>
        </div>
    </div>
    <form method="POST" action="{{ route('register') }}" class="row">
        @csrf
        <div class="col-md-5 mx-auto">
            <div class="form-group row">
                <div class="col-md-10 mx-auto">
                    <input id="name" type="text" placeholder="Name"
                        class="form-control auth-input @error('name') is-invalid @enderror" name="name"
                        value="{{ old('name') }}" required autocomplete="name" autofocus>
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-10 mx-auto">
                    <input id="email" type="email" class="form-control auth-input @error('email') is-invalid @enderror"
                        placeholder="E-mail Address" name="email" value="{{ old('email') }}" required
                        autocomplete="email">
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-10 mx-auto">
                    <input id="mobile_number" type="text" placeholder="Mobile Number"
                        class="form-control auth-input @error('mobile_number') is-invalid @enderror"
                        name="mobile_number" value="{{ old('mobile_number') }}" required autocomplete="mobile_number"
                        autofocus>
                    @error('mobile_number')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-10 mx-auto">
                    <input id="password" type="password" placeholder="Password"
                        class="form-control auth-input @error('password') is-invalid @enderror" name="password" required
                        autocomplete="new-password">

                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-10 mx-auto">
                    <input id="password-confirm" type="password" class="form-control auth-input"
                        placeholder="Confirm Password" name="password_confirmation" required
                        autocomplete="new-password">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-10 mx-auto">
                    <input id="no_ktp" type="text" placeholder="ID Number(KTP)"
                        class="form-control auth-input @error('no_ktp') is-invalid @enderror"
                        name="no_ktp" value="{{ old('no_ktp') }}" required autocomplete="no_ktp"
                        autofocus>
                    @error('no_ktp')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="register-separator"></div>
        <div class="col-md-5 mx-auto right-forms">
            <div class="form-group row">
                <div class="col-md-10 mx-auto">
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
                <div class="col-md-10 mx-auto">
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
                <div class="col-md-10 mx-auto">
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
                <div class="col-md-10 mx-auto">
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
                <div class="col-md-10 mx-auto">
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
                <div class="col-md-10 mx-auto">
                    <textarea id="address" type="text" placeholder="Address"
                        class="form-control auth-input @error('address') is-invalid @enderror" name="address"
                        value="{{ old('address') }}" required autocomplete="address" autofocus rows="3"></textarea>
                    @error('address')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="col-md-6 mx-auto">
            <div class="form-group row">
                <div class="col-md-9 offset-md-4 mx-auto">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="terms" id="terms"
                            {{ old('terms') ? 'checked' : '' }}>
                        <label class="form-check-label" for="terms">
                            {{ __('I agree to the terms and conditions and the privacy policy') }}
                        </label>
                        @error('terms')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
            </div>
            <button type="submit" class="auth-btn">
                {{ __('Register') }}
            </button>
        </div>
    </form>
</div>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
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
                }
            })
        });
    });
</script>
@endsection