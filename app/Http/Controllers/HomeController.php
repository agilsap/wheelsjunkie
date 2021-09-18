<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Delivery;
use App\Models\Gallery;
use App\Models\User;
use App\Models\Indo_Province;
use App\Http\Controllers\ProductController;
use App\Utils\Utils;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
     
    private  $category_list = [
        'Rims - Replica', //0
        'Rims - Original', //1
        'Rims - OEM', //2
        'Wheels' //3
    ];
    private $unit_list = [
        'Piece',
        'Unit'
    ];
    private $transaction_status_list = [
        'Waiting Payment', //0
        'Paid',//1
        'Approved', //2
        'Delivered', //3
        'Received', //4
        'Done', //5
        'Canceled', //6
        'Rejected' //7
    ];

    public function productsExtractor($productIDs){
        $products = [];
        foreach ($productIDs as $productID) {
            if($productID != ""){
                $product = Product::where('product_id',$productID)->first();
                if(!$product->is_deleted){
                    array_push($products,$product);
                }
            }
        };
        foreach ($products as $product) {
            $product_owner = User::where('user_id',$product->user_id)->first();
            $product->setAttribute('product_owner',$product_owner);
            $category = $product->category;
            $product->category = Utils::maskNumberedList($category,$this->category_list);
            $price = $product->price;
            $product->price = Utils::formatPrice($price);
            $unit = $product->unit;
            $product->unit = Utils::formatPlural($product->quantity,Utils::maskNumberedList($unit,$this->unit_list));
            $transactionDetail = TransactionDetail::where('product_id',$product->product_id)->get();
            if($transactionDetail->count() > 0){
                $total_qty_sold = 0;
                foreach ($transactionDetail as $detail) {
                    $total_qty_sold += $detail->quantity;
                }
                $product->setAttribute('status','Sold '.$total_qty_sold);
            }
            $gallery = Gallery::where('product_id',$product->product_id)->first();
            if($gallery){
                $product->setAttribute('product_thumbnail',$gallery->picture);
            }
        }
        return $products;
    }

    public function homeRedirect(){
        $user = Auth::user();
        if($user->user_type == 'customer'){
            return redirect()->route('home.customer');
        }elseif ($user->user_type == 'seller'){
            return redirect()->route('home.seller');
        }elseif($user->user_type == 'admin' || $user->user_type == 'principal'){
            return redirect()->route('home.admin');
        }
    }

    public function index(Request $request){
        $user = Auth::user();
        if($user->user_type == 'admin' || $user->user_type == 'principal'){
            return redirect()->route('home.admin');
        }
        $transactions = Transaction::where('buyer_user_id',$user->user_id)->get();
        $transaction_count = $transactions->count();
        $transaction_waiting_payment = Transaction::where('buyer_user_id',$user->user_id)->where('transaction_status',0)->get();
        $waiting_payment_count = $transaction_waiting_payment->count();
        $transaction_in_delivery = Transaction::where('buyer_user_id',$user->user_id)->where('transaction_status',3)->get();
        $in_delivery_count = $transaction_in_delivery->count();
        $deliveries_count = 0;
        foreach ($transactions as $transaction) {
            $details = TransactionDetail::where('transaction_detail_id',$transaction->transaction_detail_id)->first();
            $delivery = Delivery::where('transaction_id',$transaction->transaction_id)->first();
            if($delivery){
                $deliveries_count++;
            }
        }
        $cart_count = 0;
        foreach (explode(',',$user->cart_list) as $item) {
            if($item != ''){
                $cart_count++;
            }
        }
        $transaction_preview = Transaction::where('buyer_user_id',$user->user_id)->take(5)->get();
        foreach ($transaction_preview as $key => $item) {
            $seller = User::where('user_id',$item->seller_user_id)->first();
            $item->setAttribute('seller',$seller);
            $details = TransactionDetail::where('transaction_detail_id',$item->transaction_detail_id)->first();
            $product = Product::where('product_id',$details->product_id)->first();
            $item->setAttribute('product',$product);
            $item->transaction_status = Utils::maskNumberedList($item->transaction_status,$this->transaction_status_list);
        }
        $transaction_waiting_payment_preview = Transaction::where('buyer_user_id',$user->user_id)->where('transaction_status',0)->take(5)->get();
        foreach ($transaction_waiting_payment_preview as $key => $item) {
            $seller = User::where('user_id',$item->seller_user_id)->first();
            $item->setAttribute('seller',$seller);
            $details = TransactionDetail::where('transaction_detail_id',$item->transaction_detail_id)->first();
            $product = Product::where('product_id',$details->product_id)->first();
            $item->setAttribute('product',$product);
            $item->transaction_status = Utils::maskNumberedList($item->transaction_status,$this->transaction_status_list);
        }
        return view('home')->with([
            'user'=>$user,
            'transaction_count'=>$transaction_count,
            'waiting_payment_count'=>$waiting_payment_count,
            'deliveries_count'=>$deliveries_count,
            'in_delivery_count'=>$in_delivery_count,
            'in_cart'=>$cart_count,
            'transaction_preview'=>$transaction_preview,
            'waiting_payment_preview'=>$transaction_waiting_payment_preview
        ]);
    }

    public function sellerIndex(){
        $user = Auth::user();
        $products = Product::where('user_id',$user->user_id)->get();
        $products_count = $products->count();
        $products_preview = Product::where('user_id',$user->user_id)->take(5)->get();
        $new_orders = Transaction::where('seller_user_id',$user->user_id)->where('transaction_status','<',2)->get();
        $new_orders_count = $new_orders->count();
        $new_orders_preview = Transaction::where('seller_user_id',$user->user_id)->where('transaction_status','<',2)->take(5)->get();
        foreach ($new_orders_preview as $item) {
            $buyer = User::where('user_id',$item->buyer_user_id)->first();
            $item->setAttribute('buyer',$buyer);
            $details = TransactionDetail::where('transaction_detail_id',$item->transaction_detail_id)->first();
            $product = Product::where('product_id',$details->product_id)->first();
            $item->setAttribute('product',$product);
            $item->transaction_status = Utils::maskNumberedList($item->transaction_status,$this->transaction_status_list);
        }
        $delivery_needed = Transaction::where('seller_user_id',$user->user_id)->where('transaction_status',2)->get();
        $delivery_needed_count = $delivery_needed->count();
        $delivery_needed_preview = Transaction::where('seller_user_id',$user->user_id)->where('transaction_status',2)->take(5)->get();
        foreach ($delivery_needed_preview as $key => $item) {
            $buyer = User::where('user_id',$item->buyer_user_id)->first();
            $item->setAttribute('buyer',$buyer);
            $details = TransactionDetail::where('transaction_detail_id',$item->transaction_detail_id)->first();
            $product = Product::where('product_id',$details->product_id)->first();
            $item->setAttribute('product',$product);
            $item->transaction_status = Utils::maskNumberedList($item->transaction_status,$this->transaction_status_list);
        }
        $all_transactions = Transaction::where('seller_user_id',$user->user_id)->get();
        $all_transactions_count = $all_transactions->count();
        $all_transactions_preview = Transaction::where('seller_user_id',$user->user_id)->take(5)->get();
        foreach ($all_transactions_preview as $key => $item) {
            $buyer = User::where('user_id',$item->buyer_user_id)->first();
            $item->setAttribute('buyer',$buyer);
            $details = TransactionDetail::where('transaction_detail_id',$item->transaction_detail_id)->first();
            $product = Product::where('product_id',$details->product_id)->first();
            $item->setAttribute('product',$product);
            $item->transaction_status = Utils::maskNumberedList($item->transaction_status,$this->transaction_status_list);
        }
        return view('homeSeller')->with([
            'user'=>$user,
            'products_count'=>$products_count,
            'products_preview'=>$products_preview,
            'new_orders_count'=>$new_orders_count,
            'new_orders_preview'=>$new_orders_preview,
            'delivery_needed_count'=>$delivery_needed_count,
            'delivery_needed_preview'=>$delivery_needed_preview,
            'all_transactions_count'=>$all_transactions_count,
            'all_transactions_preview'=>$all_transactions_preview
        ]);
    }

    public function adminIndex(){
        $user = Auth::user();
        $products = Product::all();
        $products_count = $products->count();
        $products_preview = Product::all()->take(5);
        $transaction = Transaction::all();
        $transaction_count = $transaction->count();
        $transaction_preview = Transaction::all()->take(5);
        foreach ($transaction_preview as $key => $item) {
            $buyer = User::where('user_id',$item->buyer_user_id)->first();
            $item->setAttribute('buyer',$buyer);
            $details = TransactionDetail::where('transaction_detail_id',$item->transaction_detail_id)->first();
            $product = Product::where('product_id',$details->product_id)->first();
            $item->setAttribute('product',$product);
        }
        $customer = User::where('user_type','customer')->get();
        $customer_count = $customer->count();
        $customer_preview = User::where('user_type','customer')->take(5)->get();
        $seller = User::where('user_type','seller')->get();
        $seller_count = $seller->count();
        $seller_preview = User::where('user_type','seller')->take(5)->get();
        return view('homeAdmin')->with([
            'user'=>$user,
            'products_count'=>$products_count,
            'products_preview'=>$products_preview,
            'transactions_count'=>$transaction_count,
            'transactions_preview'=>$transaction_preview,
            'customer_count'=>$customer_count,
            'customer_preview'=>$customer_preview,
            'seller_count'=>$seller_count,
            'seller_preview'=>$seller_preview
        ]);
    }

    public function sellerRequest(){
        $user = Auth::user();
        $user->update([
            'is_seller_request'=>true
        ]);
        return redirect()->route('home.seller');
    }

    public function cartIndex(){
        $user = Auth::user();
        if($user->cart_list == '' || $user->cart_list == ',' || $user->cart_list == ',,'){
            return view('cart')->with([
                'user'=>$user,
                'products'=>[]
            ]);
        }
        $productIDs = explode(',',$user->cart_list);
        $products = $this->productsExtractor($productIDs);
        return view('cart')->with([
            'user'=>$user,
            'products'=>$products
        ]);
    }

    public function shipmentsIndex(){
        $user = Auth::user();
        if($user->user_type == 'admin' || $user->user_type == 'principal'){
            $transactions = Transaction::where('transaction_status','>',2)->where('transaction_status','<',5)->get();
        }else if($user->user_type == 'seller'){
            $transactions = Transaction::where('seller_user_id',$user->user_id)->where('transaction_status','>',1)->where('transaction_status','<',5)->get();
        }
        foreach ($transactions as $transaction) {
            $customer = User::where('user_id',$transaction->buyer_user_id)->first();
            $transaction->setAttribute('customer',$customer);
            $seller = User::where('user_id',$transaction->seller_user_id)->first();
            $transaction->setAttribute('seller',$seller);
            $transaction_details = TransactionDetail::where('transaction_detail_id',$transaction->transaction_detail_id)->first();
            $transaction->setAttribute('details',$transaction_details);
            $product = Product::where('product_id',$transaction_details->product_id)->first();
            $thumbnail = Gallery::where('product_id',$product->product_id)->first();
            $product->setAttribute('thumbnail',$thumbnail);
            $transaction->setAttribute('product',$product);
            $transaction->transaction_status = Utils::maskNumberedList($transaction->transaction_status,$this->transaction_status_list);
            $transaction->transaction_total_cost = Utils::formatPrice($transaction->transaction_total_cost);
            $delivery = Delivery::where('transaction_id',$transaction->transaction_id)->first();
            $transaction->setAttribute('delivery',$delivery);
        }
        $sukses = session()->get('sukses');
        return view('shipments')->with([
            'sukses'=>$sukses,
            'user'=>$user,
            'transactions'=>$transactions,
        ]);
    }
    
    public function deliveriesIndex(){
        $user = Auth::user();
        $transactions = Transaction::where('buyer_user_id',$user->user_id)->where('transaction_status','>',2)->where('transaction_status','<',5)->get();
        foreach ($transactions as $transaction) {
            $seller = User::where('user_id',$transaction->seller_user_id)->first();
            $transaction->setAttribute('seller',$seller);
            $transaction_details = TransactionDetail::where('transaction_detail_id',$transaction->transaction_detail_id)->first();
            $transaction->setAttribute('details',$transaction_details);
            $product = Product::where('product_id',$transaction_details->product_id)->first();
            $thumbnail = Gallery::where('product_id',$product->product_id)->first();
            $product->setAttribute('thumbnail',$thumbnail);
            $transaction->setAttribute('product',$product);
            $can_be_canceled = false;
            $can_upload_receipt = false;
            if($transaction->transaction_status == 0){
                $can_be_canceled = true;
                $can_upload_receipt = true;
            }
            $can_receive = false;
            if($transaction->transaction_status == 3){
                $can_receive = true;
            }
            $transaction->setAttribute('can_be_canceled',$can_be_canceled);
            $transaction->setAttribute('can_upload_receipt',$can_upload_receipt);
            $transaction->setAttribute('can_receive',$can_receive);
            $transaction->transaction_status = Utils::maskNumberedList($transaction->transaction_status,$this->transaction_status_list);
            $transaction->transaction_total_cost = Utils::formatPrice($transaction->transaction_total_cost);
            $delivery = Delivery::where('transaction_id',$transaction->transaction_id)->first();
            $transaction->setAttribute('delivery',$delivery);
        }
        $sukses = session()->get('sukses');
        return view('deliveries')->with([
            'sukses'=>$sukses,
            'user'=>$user,
            'transactions'=>$transactions,
        ]);
    }

    public function wishlistIndex(){
        $user = Auth::user();
        if($user->wishlist == '' || $user->wishlist == ',' || $user->wishlist == ',,'){
            return view('cart')->with([
                'user'=>$user,
                'products'=>[]
            ]);
        }
        $productIDs = explode(',',$user->wishlist);
        $products = $this->productsExtractor($productIDs);
        return view('wishlist')->with([
            'user'=>$user,
            'products'=>$products
        ]);
    }

    public function profileIndex(){
        $user = Auth::user();
        return view('profile')->with([
            'user'=>$user,
        ]);
    }

    public function chatIndex(){
        $user = Auth::user();
        return view('chats.messages')->with([
            'user'=>$user
        ]);
    }

    public function userCustomerIndex(){
        $authUser = Auth::user();
        $users = User::where('user_type','customer')->orderBy('name','asc')->get();
        foreach ($users as $user) {
            $location = Indo_Province::where('province_id',$user->province_id)->first();
            $user->setAttribute('location',$location);
        }
        return view('users')->with([
            'user'=>$authUser,
            'users'=>$users
        ]);
    }

    public function userSellerIndex(){
        $authUser = Auth::user();
        $users = User::where('user_type','seller')->orderBy('name','asc')->get();
        foreach ($users as $user) {
            $location = Indo_Province::where('province_id',$user->province_id)->first();
            $user->setAttribute('location',$location);
        }
        return view('users')->with([
            'user'=>$authUser,
            'users'=>$users
        ]);
    }

    public function userAdminIndex(){
        $authUser = Auth::user();
        $users = User::orderBy('name','asc')->get();
        foreach ($users as $user) {
            $location = Indo_Province::where('province_id',$user->province_id)->first();
            $user->setAttribute('location',$location);
        }
        return view('users')->with([
            'user'=>$authUser,
            'users'=>$users
        ]);
    }
}
