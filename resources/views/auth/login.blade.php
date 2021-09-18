@extends('layouts.auth-navbar')

@section('content')
<div class="container justify-content-center">
    <div class="row">
        <div class="col-md-12 text-center my-5">
            <h1 class="display-1">
                <strong class="font-weight-bold auth-text">
                    Log In
                </strong>
            </h1>
        </div>
    </div>
    <div class="row justify-content-center text-center">
        <div class="container-fluid">
            <div class="col-md-6 align-self-center float mx-auto">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group row">
                        <div class="col-md-12">
                            <input id="email" type="email" class="form-control auth-input @error('email') is-invalid @enderror"
                                placeholder="Email" name="email" value="{{ old('email') }}" required
                                autocomplete="email" autofocus>

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-12">
                            <input id="password" type="password" placeholder="Password"
                                class="form-control auth-input @error('password') is-invalid @enderror" name="password" required
                                autocomplete="current-password">

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-9 offset-md-4 mx-auto">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember" name="remember"
                                    {{ old('terms') ? 'checked' : '' }}>
                                <label class="form-check-label" for="terms">
                                    {{ __('Remember me') }}
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
                        {{ __('Login') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
    @if (Route::has('register'))
        <div class="row justify-content-center text-center mt-5">
            Don't have an account yet? &nbsp;
            <a href="{{ route('register') }}">
                {{ __('Register Now') }}
            </a>
        </div>
    @endif
    @if (Route::has('register'))
        <div class="row justify-content-center text-center">
            <a href="{{ route('password.request') }}">
                {{ __('Forgot Your Password?') }}
            </a>
        </div>
    @endif
</div>
@endsection