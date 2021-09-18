@include('layouts.head')
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <ul class="navbar-nav">
    <li class="nav-item my-auto">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item d-none d-sm-inline-block ml-5 pl-5">
      <a class="navbar-brand" href="/"><img src={{asset('asset/Navbar_logo.png')}} class="brand-image ml-5"></a>
    </li>
  </ul>
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
    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-bell"></i>
        <span class="badge badge-warning navbar-badge">{{$notifications_count}}</span>
      </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <span class="dropdown-item dropdown-header">{{$notifications_count}} Notifications</span>
        <div class="dropdown-divider"></div>
        @forelse ($notification_preview as $item)
        <a href="{{$item->notification_link}}" class="dropdown-item">
          <div class="row justify-content-center align-items-center">
            <div class="col-md-2">
              <i class="fas fa-box"></i>
            </div>
            <div class="col-md-10 pr-2">
              <p class="text-sm">{{ $item->notification }}</p>
              <span class="text-muted text-sm"> {{ $item->created_at }}</span>
            </div>
          </div>
        </a>
        <div class="dropdown-divider"></div>
        @empty
        @endforelse
        <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
      </div>
    </li>
    <li class="nav-item dropdown">
      <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false" v-pre>
        {{ $user->name }}
      </a>
      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
        @if ($user->user_type == 'seller' || $user->user_type == 'customer')
        <a class="dropdown-item" href="{{ route('home.customer') }}">
          {{ __('Customer') }}
        </a>
        <a class="dropdown-item" href="{{ route('home.seller') }}">
          {{ __('Seller') }}
        </a>
        @endif
        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
          {{ __('Logout') }}
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
          @csrf
        </form>
      </div>
    </li>
  </ul>
</nav>