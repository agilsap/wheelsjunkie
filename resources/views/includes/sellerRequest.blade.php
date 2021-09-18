<div class="d-flex align-items-center justify-content-center" style="height: 350px">
    <div class="p-2 bd-highlight text-center">
        <h1 class="pb-3">You are not a seller</h1>
        @if ($user->is_seller_request)
        <p>You already requested to be a seller,</p>
        <p>please wait for admin confirmation.</p>
        @endif
        <div class="d-flex justify-content-center pt-2">
            @if($user->is_seller_request)
            <a class="btn btn-lg btn-secondary m-2" style="cursor: not-allowed;">Become a seller</a>
            @else
            <a href="{{route('home.seller.request')}}" class="btn btn-lg btn-primary m-2">Become a seller</a>
            @endif
        </div>
    </div>
</div>