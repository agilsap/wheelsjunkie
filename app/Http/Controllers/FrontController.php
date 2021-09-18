<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Gallery;
use Illuminate\Support\Facades\Auth;

class FrontController extends ProductController
{
    public function categoriesIndex($request){
        if($request == -1){
            return view('front.categories')->with([
                "type"=>'index'
            ]);
        }elseif ($request == 10) {
            return view('front.categories')->with([
                "type"=>'rims'
            ]);
        }else {
            return redirect()->route('front.product.index',$request);
        }
    }

    public function productDetails($id){
        $user = Auth::user();
        $product = Product::where('product_id',$id)->get();
        $product = $this->modifyProducts($product);
        $product_images = Gallery::where('product_id',$id)->get();
        if($user){
            $wishlist = $user->wishlist;
            $items = explode(',',$wishlist);
            foreach ($items as $item ) {
                if($item == $id){
                    $product[0]->setAttribute('liked',true);
                }
            }
        }
        return view('front.productDetails')->with([
            'product'=>$product[0],
            'product_images'=>$product_images
        ]);
    }
}
