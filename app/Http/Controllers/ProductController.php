<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Gallery;
use App\Models\TransactionDetail;
use App\Models\Transaction;
use App\Models\Notification;
use App\Models\User;
use App\Models\Indo_Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use App\Utils\Utils;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     private  $category_list = [
        'Rims - Replica', //0
        'Rims - Original', //1
        'Rims - OEM', //2
        'Tires' //3
    ];
    private $unit_list = [
        'Piece',
        'Set'
    ];
    private $condition_list = [
        'New',
        'Used'
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
    private $pcd_list = [
        "4 x 100 mm",
        "4 x 108 mm",
        "4 x 114,3 mm",
        "5 x 100 mm",
        "5 x 108 mm",
        "5 x 112 mm",
        "5 x 114,3 mm",
        "5 x 120 mm",
        "5 x 127 mm",
        "5 x 130 mm",
        "5 x 139,7 mm",
        "5 x 165,1 mm",
        "6 x 114,3 mm",
        "6 x 139,7 mm"
    ];
    public function modifyProducts($products){
        foreach ($products as $product) {
            $product_owner = User::where('user_id',$product->user_id)->first();
            $product->setAttribute('product_owner',$product_owner);
            $owner_location = Indo_Province::where('province_id',$product_owner->province_id)->first();
            $product->setAttribute('delivery_from',$owner_location);
            $category = $product->category;
            $product->category = Utils::maskNumberedList($category,$this->category_list);
            $product->condition = Utils::maskNumberedList($product->condition, $this->condition_list);
            $pcd_1 = $product->pcd_1;
            if($pcd_1){
                $product->pcd_1 = Utils::maskNumberedList($pcd_1,$this->pcd_list);
            }
            $pcd_2 = $product->pcd_2;
            if($pcd_2){
                $product->pcd_2 = Utils::maskNumberedList($pcd_2,$this->pcd_list);
            }
            $price = $product->price;
            $product->price = Utils::formatPrice($price);
            $unit = $product->unit;
            $product->unit = Utils::formatPlural($product->quantity,Utils::maskNumberedList($unit,$this->unit_list));
            if($product->category == 'Tires'){
                $product->tire_diameter = Utils::formatDecimal($product->tire_diameter);
                $product->tire_width = Utils::formatDecimal($product->tire_width);
                $product->tire_width_ratio = Utils::formatDecimal($product->tire_width_ratio);   
            }else{
                $product->rim_diameter = Utils::formatDecimal($product->rim_diameter);
                $product->front_rim_width = Utils::formatDecimal($product->front_rim_width);
                $product->rear_rim_width = Utils::formatDecimal($product->rear_rim_width);
                $product->front_offset = Utils::formatDecimal($product->front_offset);
                $product->rear_offset = Utils::formatDecimal($product->rear_offset);
            }
            $transactionDetail = TransactionDetail::where('product_id',$product->product_id)->get();
            if($transactionDetail->count() > 0){
                $total_qty_sold = 0;
                $isSold = false;
                foreach ($transactionDetail as $detail) {
                    $transaction = Transaction::where('transaction_detail_id',$detail->transaction_detail_id)->first();
                    if($transaction->transaction_status != 6){
                        $total_qty_sold += $detail->quantity;
                        $isSold = true;
                    }
                }
                if($isSold){
                    $product->setAttribute('status','Sold '.$total_qty_sold);
                }
            }
            $gallery = Gallery::where('product_id',$product->product_id)->first();
            if($gallery){
                $product->setAttribute('product_thumbnail',$gallery->picture);
            }
        }
        return $products;
    }
    public function index(Request $request)
    {
        $url = url()->previous();
        $endpoint_mark = strpos($url,'/',15);
        $endpoint = substr($url,$endpoint_mark+1);
        $sukses = null;
        if($endpoint == 'add'){
            $sukses = "Successfully added a new product";
        }
        $user = Auth::user();
        if($user->user_type == 'customer'){
            return redirect()->route('home.seller');
        }
        if($user->user_type == 'admin' || $user->user_type == 'principal'){
            $products = Product::orderBy('product_id','desc')->paginate(10);
        }else{
            $products = Product::where('user_id',$user->user_id)->orderBy('product_id','desc')->paginate(10);
        }
        $products = $this->modifyProducts($products);
        return view('products.productsDashboard')->with([
            'user' => $user,
            'products' => $products,
            'sukses'=>$sukses
        ]);
    }

    public function details($id){
        $product = Product::where('product_id',$id)->get();
        $user = Auth::user();
        if($user->user_id != $product[0]->user_id){
            return redirect()->route('front.product.details',$id);
        }
        $url = url()->previous();
        $endpoint_mark = strpos($url,'/',25);
        $endpoint = substr($url,$endpoint_mark+1);
        $sukses = null;
        if($endpoint == 'edit'){
            $sukses = "Successfully updated product, ".$product[0]->product_name;
        }
        $product = $this->modifyProducts($product);
        $product_images = Gallery::where('product_id',$id)->get();
        $shown_thumbnail = [];
        if($product_images->count()<4){
            $shown_thumbnail = $product_images;
        }else{
            foreach ($product_images as $key => $image) {
                if($key<3){
                    $shown_thumbnail[] = $image;
                }
            }
        }
        return view('products.productsDetails')->with([
            'user'=>$user,
            'product'=>$product[0],
            'shown_thumbnails'=>$shown_thumbnail,
            'product_images'=>$product_images,
            'sukses'=>$sukses
        ]);
    }

    public function frontIndex(Request $request, $request_id){
        $products = Product::where('category',$request_id)->where('is_deleted',false);
        if($request->get('search_title')){
            $products = $products->where('product_name',$request->get('search_title'));
        }
        if($request->get('size')){
            if($request_id==3){
                $products = $products->where('tire_diameter',$request->get('size'));
            }else{
                $products = $products->where('rim_diameter',$request->get('size'));
            }
        }
        if($request_id==3){
            if($request->get('width')){
                $products = $products->where('tire_width',$request->get('width'));
            }
        }
        if($request_id!=3){
            if($request->get('front_width')){
                $products = $products->where('front_rim_width',$request->get('front_width'));
            }
            if($request->get('rear_width')){
                $products = $products->where('rear_rim_width',$request->get('rear_width'));
            }
            if($request->get('front_offset_low')){
                $products = $products->where('front_offset','>',$request->get('front_offset_low'));
            }
            if($request->get('front_offset_high')){
                $products = $products->where('front_offset','<',$request->get('front_offset_high'));
            }
            if($request->get('rear_offset_low')){
                $products = $products->where('rear_offset','>',$request->get('rear_offset_low'));
            }
            if($request->get('rear_offset_high')){
                $products = $products->where('rear_offset','<',$request->get('rear_offset_high'));
            }
            if($request->get('pcd')!=''){
                $products = $products->where('pcd_1','LIKE',$request->get('pcd'));
                if($products->count() == 0){
                    $products = $products->where('pcd_2','LIKE',$request->get('pcd'));
                }
            }
        }
        if($request->get('price_low')){
            $products = $products->where('price','>',$request->get('price_low'));
        }
        if($request->get('price_high')){
            $products = $products->where('price','<',$request->get('price_high'));
        }
        if($request->get('price_sort')){
            $products = $products->orderBy('price',$request->get('price_sort'));
        }
        $products = $products->paginate(8)->appends([
            'search_title'=>$request->get('search_title'),
            'size'=>$request->get('size'),
            'front_width'=>$request->get('front_width'),
            'rear_width'=>$request->get('rear_width'),
            'front_offset_low'=>$request->get('front_offset_low'),
            'front_offset_high'=>$request->get('front_offset_high'),
            'rear_offset_low'=>$request->get('rear_offset_low'),
            'rear_offset_high'=>$request->get('rear_offset_high'),
            'price_low'=>$request->get('price_low'),
            'price_high'=>$request->get('price_high'),
            'price_sort'=>$request->get('price_sort'),
        ]);
        $products = $this->modifyProducts($products);
        $category = Utils::maskNumberedList($request_id,$this->category_list);
        return view('front.products')->with([
            'products'=>$products,
            'category'=>$category,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $user = Auth::user();
        return view('products.productsCreate')->with([
            'user'=>$user
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $chosen_category = $request->get('category');
        $category = $chosen_category == 0 ? $request->get('rim_type') : 3;
        $product = Product::create([
            'user_id'=>$user->user_id,
            'product_name'=>$request->get('product_name'),
            'category'=>$category,
            'weight'=>$request->get('weight'),
            'price'=>$request->get('price'),
            'unit'=>$request->get('unit'),
            'quantity'=>$request->get('quantity'),
            'condition'=>$request->get('condition'),
            'description'=>$request->get('description'),
            'is_deleted'=>false,
        ]);
        if($category == 3){
            $product->tire_diameter = $request->get('tire_diameter');
            $product->tire_width = $request->get('tire_width');
            $product->tire_width_ratio = $request->get('tire_width_ratio');
        }else{
            $product->rim_diameter = $request->get('rim_diameter');
            $product->front_rim_width = $request->get('front_rim_width');
            $product->rear_rim_width = $request->get('rear_rim_width');
            $product->front_offset = $request->get('front_offset');
            $product->rear_offset = $request->get('rear_offset');
            $product->pcd_1 = $request->get('pcd_1');
            $product->pcd_2 = $request->get('pcd_2');
        }
        if($request->hasFile('product_thumbnail')){
            $base_path = public_path('img/images/products');
            if(!File::isDirectory($base_path)){
                File::makeDirectory($base_path, 0777, true, true);
            }
            $time = Carbon::now()->format('dmyhms');
            $file_name = 'P'.$product->product_id.'U'.$user->user_id.$time.'.png';
            $img = Image::make($request->file('product_thumbnail')->getRealPath());
            $gallery = Gallery::create([
                'product_id'=>$product->product_id,
                'picture'=> $file_name,
            ]);
            $img->save('img/images/products/'.$file_name, 80);
        }
        $product->save();
        return redirect()->route('products.index')->with([
            'test'=>'from store'
        ]);
    }

    public function buyNow($id){
        $user = Auth::user();
        $product = Product::where('product_id',$id)->get();
        if($product[0]->user_id == $user->user_id){
            return redirect()->back()->with([
                'error'=>'This is your product'
            ]);
        }
        $product = $this->modifyProducts($product);
        $location = Indo_Province::where('province_id',$user->province_id)->first();
        $user->setAttribute('location',$location);
        $cart_ids = $user->cart_list;
        $cart_ids = explode(',',$cart_ids);
        $isInCart = false;
        foreach ($cart_ids as $key => $curr_id) {
            if($curr_id == $id){
                $isInCart = true;
            }
        }
        $buy_now_qty = 1;
        $buy_now_unit = Utils::formatPlural($buy_now_qty,$product[0]->unit);
        return view('front.checkout')->with([
            'user'=>$user,
            'product'=>$product[0],
            'buy_now_qty'=>$buy_now_qty, 
            'buy_now_unit'=>$buy_now_unit
        ]);
    }

    public function payment($id){
        $user = Auth::user();
        //check existing transaction
        $search_transaction = Transaction::where('buyer_user_id',$user->user_id)->get();
        foreach ($search_transaction as $key =>$item) {
            $search_details = TransactionDetail::where('transaction_detail_id',$item->transaction_detail_id)->first();
            if($search_details && $item->transaction_status == 0){
                if($search_details->product_id == $id){
                    $product = Product::where('product_id',$search_details->product_id)->first();
                    return view('front.uploadPayment')->with([
                        'product'=>$product,
                        'user'=>$user,
                        'transaction_detail'=>$search_details,
                        'transaction'=>$item
                    ]);
                }
            }
        }
        $product = Product::where('product_id',$id)->first();
        $total_shipment = 0;
        if($product->unit == 0){
            $sold_qty = $product->quantity; 
            $total_cost = $product->price;
        }else{
            $sold_qty = 1;
            $total_cost = $product->price * $sold_qty;
        }
        $total_price = $total_cost + $total_shipment;
        $product->quantity = $product->quantity - $sold_qty;
        $product->save();
        // dd($total_cost);
        $transaction_detail = TransactionDetail::create([
            'product_id'=>$product->product_id,
            'quantity'=>$sold_qty,
            'total_cost'=>$total_cost
        ]);
        $transaction = Transaction::create([
            'buyer_user_id'=>$user->user_id,
            'seller_user_id'=>$product->user_id,
            'payment_status'=>0,
            'transaction_detail_id'=>$transaction_detail->transaction_detail_id,
            'transaction_total_cost'=>$total_price,
            'transaction_status'=>0
        ]);
        $admins = User::where('user_type','admin')->get();
        foreach ($admins as $key => $admin) {
            $notification = Notification::create([
                'receiver_id'=>$admin->user_id,
                'Subject'=>'Product Transaction',
                'notification'=>$user->name.' just checked out a product, '.$product->product_name,
                'notification_link'=>'/transactions',
                'is_seen'=>false,
            ]);
        }
        $notification = Notification::create([
            'receiver_id'=>$product->user_id,
            'Subject'=>'Product Transaction',
            'notification'=>$user->name.' just checked out your product, '.$product->product_name,
            'notification_link'=>'/transactions',
            'is_seen'=>false,
        ]);
        $transaction->transaction_status = Utils::maskNumberedList($transaction->transaction_status,$this->transaction_status_list);
        return redirect()->route('transaction.create', $transaction->transaction_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $user = Auth::user();
        $product = Product::where('product_id',$id)->first();
        if($product->category == 3){
            $product->setAttribute('rim_type','');
            $product->category= 1;
            $product->setAttribute('pcd_control','');
        }else{
            $product->setAttribute('rim_type',$product->category);
            $product->category = 0;
            if($product->pcd_2){
                $product->setAttribute('pcd_control','yes');
            }else{
                $product->setAttribute('pcd_control','no');
            }
        }
        return view('products.productsEdit')->with([
            'user'=>$user,
            'product'=>$product,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $product = Product::where('product_id',$id)->first();
        $chosen_category = $request->get('category');
        $category = $chosen_category == 0 ? $request->get('rim_type') : 3;
        $product->product_name = $request->get('product_name');
        $product->category = $category;
        $product->weight = $request->get('weight');
        $product->price = $request->get('price');
        $product->unit = $request->get('unit');
        $product->quantity = $request->get('quantity');
        $product->description = $request->get('description');
        if($category == 3){
            $product->tire_diameter = $request->get('tire_diameter');
            $product->tire_width = $request->get('tire_width');
            $product->tire_width_ratio = $request->get('tire_width_ratio');

            $product->rim_diameter = null;
            $product->front_rim_width = null;
            $product->rear_rim_width = null;
            $product->front_offset = null;
            $product->rear_offset = null;
            $product->pcd_1 = null;
            $product->pcd_2 = null;
        }else if($category == 0){
            $product->rim_diameter = $request->get('rim_diameter');
            $product->front_rim_width = $request->get('front_rim_width');
            $product->rear_rim_width = $request->get('rear_rim_width');
            $product->front_offset = $request->get('front_offset');
            $product->rear_offset = $request->get('rear_offset');
            $product->pcd_1 = $request->get('pcd_1');
            $product->pcd_2 = $request->get('pcd_2');

            $product->tire_diameter = null;
            $product->tire_width = null;
            $product->tire_width_ratio = null;
        }
        $product->save();
        return redirect()->route('products.details',$id);
    }

    public function quickUpdate(Request $req, $id){
        $product = Product::where('product_id',$id)->first();
        if($req->get('quantity')==0){
            $product->is_deleted = true;
        }
        if($req->get('quantity')>0 && $product->quantity == 0){
           $product->is_deleted = false; 
        }
        $product->quantity = $req->get('quantity');
        $product->condition = $req->get('condition');
        $product->save();
        return redirect()->back()->with([
            'user'=>Auth::user(),
            'product'=>$product,
            'sukses'=>"Successfully updated product, ".$product->product_name,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }

    public function delete($id){
        $product = Product::where('product_id',$id)->first();
        if($product->quantity == 0){
            return redirect()->back()->with([
                'user'=>Auth::user(),
                'product'=>$product,
                'error'=>'Cannot show products with 0 quantity'
            ]);
        }
        $product->is_deleted = !$product->is_deleted;
        $product->save();
        return redirect()->back()->with([
            'user'=>Auth::user(),
            'product'=>$product
        ]);
    }

    public function wishlistToggle($id){
        $user = Auth::user();
        $product = Product::where('product_id',$id)->first();
        if($product->user_id == $user->user_id){
            return redirect()->back()->with([
                'error'=>'This is your product'
            ]);
        }
        $wishlist = $user->wishlist;
        $items = explode(',',$wishlist);
        $is_liked = false;
        foreach ($items as $item ) {
            if($item == $id){
                $is_liked = true;
            }
        }
        if($is_liked){
            $new_wishlist = str_replace($id.',','',$wishlist);
            $user->wishlist = $new_wishlist;
            $user->save();
            return redirect()->back()->with([
                'error'=>'Removed from wishlist'
            ]);
        }else{
            $new_wishlist = $id.','.$wishlist;
            $user->wishlist = $new_wishlist;
            $user->save();
            return redirect()->back()->with([
                'sukses'=>'Added to wishlist'
            ]);
        }
    }

    public function addToCart($id){
        $user = Auth::user();
        $product = Product::where('product_id',$id)->first();
        if($product->user_id == $user->user_id){
            return redirect()->back()->with([
                'error'=>'This is your product'
            ]);
        }
        $cart_list = $user->cart_list;
        $items = explode(',',$cart_list);
        foreach ($items as $item) {
            if($item == $id){
                return redirect()->route('cart.index')->with([
                    'error'=> $product->product_name.' is already in your cart'
                ]);
            }
        }
        $user->cart_list = $id.','.$user->cart_list;
        $user->save();
        return redirect()->route('cart.index')->with([
            'sukses'=> $product->product_name.' is added to your cart',
        ]);
    }

    public function removeFromCart($id){
        $product = Product::where('product_id',$id)->first();
        $user = Auth::user();
        $cart_list = $user->cart_list;
        $items = explode(',',$cart_list);
        $new_list = '';
        foreach ($items as $key => $item) {
            if($item != $id){
                $new_list = $new_list.','.$item;
            }
        }
        $user->cart_list = $new_list;
        $user->save();
        return redirect()->route('cart.index')->with([
            'error' => $product->product_name.' is removed from your cart',
        ]);
    }
}
