@include('layouts.head')
<nav class="navbar navbar-expand-md bg-light navbar-light">
    <div class="container">
        <a class="navbar-brand" href="/"><img src={{asset('asset/Navbar_logo.png')}} class="brand-image"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link {{ (request()->is('/')) ? 'active' : '' }}" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ (request()->is('chat')) ? 'active' : '' }}" href="{{route('message.all')}}">Chat</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ (request()->is('cart')) ? 'active' : '' }}" href="{{route('cart.index')}}">Cart</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ (request()->is('about')) ? 'active' : '' }}" href="{{route('about.index')}}">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('home.customer')}}">Profile</a>
                </li>
            </ul>
            <ul class="navbar-nav">
                @if (Route::has('login'))
                <li class="nav-item">
                    @auth
                    <a href="{{ route('logout') }}" class="nav-link btn btn-brand w-25 w-100" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">Log out</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                    @else
                    <a href="{{ route('login') }}" class="nav-link btn btn-brand">Log in</a>
                    @endauth
                </li>
                @endif
            </ul>
        </div>
    </div>
</nav>