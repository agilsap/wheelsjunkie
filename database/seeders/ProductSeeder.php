<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Gallery;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        for($i=0; $i<30; $i++){
            $product = Product::create([
                'user_id'=>2,
                'product_name'=>'produk '.($i+1),
                'category'=>3,
                'weight'=>123,
                'price'=>123123.23,
                'unit'=>1,
                'quantity'=>5,
                'condition'=>1,
                'rim_diameter'=>null,
                'front_rim_width'=>null,
                'rear_rim_width'=>null,
                'front_offset'=>null,
                'rear_offset'=>null,
                'pcd_1'=>null,
                'pcd_2'=>null,
                'tire_diameter'=>10,
                'tire_width'=>10,
                'tire_width_ratio'=>10,
                'description'=>"asdfasdf",
                'is_deleted'=>false,
            ]);
            Gallery::create([
                'product_id'=>$product->product_id,
                'picture'=>'P33U2190621040606.png'
            ]);
        }
        for($i=0; $i<3; $i++){
            $product = Product::create([
                'user_id'=>2,
                'product_name'=>'produk '.($i+34),
                'category'=>$i,
                'weight'=>123,
                'price'=>123123.23,
                'unit'=>1,
                'quantity'=>5,
                'condition'=>0,
                'rim_diameter'=>12,
                'front_rim_width'=>2,
                'rear_rim_width'=>2,
                'front_offset'=>12,
                'rear_offset'=>12,
                'pcd_1'=>2,
                'pcd_2'=>2,
                'tire_diameter'=>null,
                'tire_width'=>null,
                'tire_width_ratio'=>null,
                'description'=>"asdfasdf",
                'is_deleted'=>false,
            ]);
            Gallery::create([
                'product_id'=>$product->product_id,
                'picture'=>'P33U2190621040606.png'
            ]);
        }
    }
}
