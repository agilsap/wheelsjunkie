<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Indo_Province;
use App\Models\Gallery;
use App\Models\TransactionDetail;
use App\Utils\Utils;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class ProfileController extends Controller
{
    //
    private  $category_list = [
        'Rims - Replica', //0
        'Rims - Original', //1
        'Rims - OEM', //2
        'Tires' //3
    ];
    private $unit_list = [
        'Piece',
        'Unit'
    ];
    private $condition_list = [
        'New',
        'Used'
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

    public function activation($id){
        $deleted_user = User::where('user_id',$id)->first();
        $deleted_user->is_deleted = !$deleted_user->is_deleted;
        $deleted_user->save();
        if(!$deleted_user->is_deleted){
            if($deleted_user->user_type == 'seller'){
                $products = Product::where('user_id',$deleted_user->user_id)->get();
                foreach ($products as $product) {
                    $product->is_deleted = false;
                    $product->save();
                }
            }
            return back()->with([
                'sukses'=>'Successfully activate user, '.$deleted_user->name,
            ]);
        }
        if($deleted_user->is_deleted){
            if($deleted_user->user_type == 'seller'){
                $products = Product::where('user_id',$deleted_user->user_id)->get();
                foreach ($products as $product) {
                    $product->is_deleted = true;
                    $product->save();
                }
            }
            return back()->with([
                'error'=>'Successfully deactivate user, '.$deleted_user->name,
            ]);
        }
    }

    public function approveSellerRequest($id){
        $user = User::where('user_id',$id)->first();
        if($user->is_seller_request){
            $user->is_seller_request = false;
            $user->user_type = 'seller';
            $user->save();
            return back()->with([
                'sukses'=>'Seller request approved for '.$user->name,
            ]);
        }
    }

    public function update(Request $request, $id){
        $user = Auth::user();
        $user->update([
            'name'=>$request->get('name'),
            'email'=>$request->get('email'),
            'mobile_number'=>$request->get('mobile_number'),
            'password'=>$request->get('password'),
            'province_id'=>$request->get('sub_district'),
            'address'=>$request->get('address'),
        ]);
        return back()->with([
            'sukses'=>'Profile Updated'
        ]);
    }

    public function changePicture(Request $request, $id){
        $user = Auth::user();
        if($request->hasFile('profile_picture')){
            $base_path = public_path('img/images/profile');
            if(!File::isDirectory($base_path)){
                File::makeDirectory($base_path, 0777, true, true);
            }
            $time = Carbon::now()->format('dmyhms');
            $file_name = 'PP'.$user->user_id.'U'.$time.'.png';
            $user->profile_picture = $file_name;
            $user->save();
            $img = Image::make($request->file('profile_picture')->getRealPath());
            $img->save('img/images/profile/'.$file_name, 80);
        }
        return back()->with([
            'sukses'=>'Profile Picture Changed'
        ]);
    }

    public function view($id){
        $user = User::where('user_id',$id)->first();
        $location = Indo_Province::where('province_id',$user->province_id)->first();
        $user->setAttribute('location',$location);
        $products = Product::where('user_id',$user->user_id)->paginate(8);
        $products = $this->modifyProducts($products);
        $editable = false;
        if(Auth::user()){
            $editable = ($user->user_id == Auth::user()->user_id);
        }
        return view('front.profileDetails')->with([
            'user'=>$user,
            'products'=>$products,
            'editable'=>$editable
        ]);
    }
}
