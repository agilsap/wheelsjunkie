<head>
    <style>
    .bg-brand {
      background-color: #1d1dd6;
    }
    </style>
</head>
<aside class="main-sidebar elevation-4 border-right" style="background-color: rgba(255, 255, 255, 100)">
    <div class="brand-link">
    </div>
    <div class="sidebar">
        <div class="user-panel mt-3 py-3 mb-3 d-flex rounded" style="background-color:#1d1dd6;">
            <div class="image">
                <img src="{{asset($user->profile_picture ? 'img/images/profile/'.$user->profile_picture : 'img/images/profile/avatar.png')}}"
                    class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info text-white">
                <text class="d-block">{{$user->name}}</text>
            </div>
        </div>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{request()->is('seller') ? route('home.seller') : route('home.customer')}}" class="nav-link {{ (request()->is('customer')) || request()->is('seller') ? 'active' : '' }}" 
                        style="{{ (request()->is('customer')) || request()->is('seller') ? 'background-color:#1d1dd6;' :  '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                @if($user->user_type=='admin' || $user->user_type=='principal'|| $user->user_type=='seller')
                <li class="nav-item {{ (request()->is('shipments')) || request()->is('transactions') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="fa fa-chart-line nav-icon"></i>
                        <p>
                            Sales
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item {{ (request()->is('transactions')) ? 'active' : '' }}">
                            <a href="{{route('transactions.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Transactions</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('shipments.index')}}" class="nav-link {{ (request()->is('shipments')) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Shipments</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{route('products.index')}}" class="nav-link {{ (request()->is('products/*')) || request()->is('products') ? 'active' : '' }}">
                        <i class="fas fa-shopping-bag nav-icon"></i>
                        <p>
                            Products
                        </p>
                    </a>
                </li>
                @endif
                @if($user->user_type=='admin' || $user->user_type=='principal')
                <li class="nav-item">
                    <a href="" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Users
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('user.seller')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Sellers</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('user.customer')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Customers</p>
                            </a>
                        </li>
                        @if ($user->user_type=='principal')
                        <li class="nav-item">
                            <a href="{{route('user.admin')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Admin</p>
                            </a>
                        </li>
                        @endif
                    </ul>
                </li>
                @endif
                @if($user->user_type=='customer' || $user->user_type=='seller')
                <li class="nav-item {{ (request()->is('cart')) || request()->is('wishlist') || request()->is('payments') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ (request()->is('cart')) || request()->is('wishlist') || request()->is('payments') || request()->is('deliveries') ? 'text-white' : 'text-dark'}}"
                    style="{{ (request()->is('cart')) || request()->is('wishlist') || request()->is('payments') || request()->is('deliveries') ? 'background-color:#1d1dd6;' :  '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Purchases
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('cart.index')}}" class="nav-link  {{ (request()->is('cart')) ? 'active text-white' : 'text-dark' }}"
                                style="{{request()->is('cart') ? 'background-color:#1d1dd680;' :  '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Cart</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('wishlist.index')}}" class="nav-link  {{ (request()->is('wishlist')) ? 'active' : '' }}"
                                style="{{request()->is('wishlist') ? 'background-color:#1d1dd680;' :  '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Wishlist</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('payments.index')}}" class="nav-link  {{ (request()->is('payments')) ? 'active' : '' }}"
                                style="{{request()->is('payments') ? 'background-color:#1d1dd680;' :  '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Payments</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('deliveries.index')}}" class="nav-link  {{ (request()->is('deliveries')) ? 'active' : ''}}"
                                style="{{request()->is('deliveries') ? 'background-color:#1d1dd680;' :  '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Deliveries</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif
                <li class="nav-item">
                    <a href="{{route('profile.index')}}" class="nav-link">
                        <i class="fas fa-user-alt nav-icon"></i>
                        <p>
                            Profile
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>