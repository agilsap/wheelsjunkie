<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $cart_list = '';
        for($i = 0; $i < 6; $i++){
            $randomNumber = rand(1,6);
            $cart_list = $cart_list == '' ? $cart_list.','.$randomNumber.',' : $cart_list.$randomNumber.',';
        }
        $wishlist = '';
        for($i = 0; $i < 6; $i++){
            $randomNumber = rand(1,6);
            $wishlist = $wishlist == '' ? $wishlist.','.$randomNumber.',' : $wishlist.$randomNumber.',';
        }
        User::create([
            'user_type' => 'customer',
            'name' => 'customer',
            'email' => 'customer@email.com',
            'mobile_number' => '08123123123',
            'address' => 'address',
            'province_id'=> '1',
            'is_seller_request'=> false,
            'cart_list'=>$cart_list,
            'wishlist'=>$wishlist,
            'is_deleted'=>false,
            'password' => Hash::make('123123123'),
        ]);
        User::create([
            'user_type' => 'seller',
            'name' => 'seller',
            'email' => 'seller@email.com',
            'mobile_number' => '08987987987',
            'address' => 'address',
            'province_id'=> '1',
            'is_seller_request'=> false,
            'cart_list'=>$cart_list,
            'wishlist'=>$wishlist,
            'is_deleted'=>false,
            'password' => Hash::make('123123123'),
        ]);
        User::create([
            'user_type' => 'admin',
            'name' => 'admin',
            'email' => 'admin@email.com',
            'mobile_number' => '08789789789',
            'address' => 'address',
            'province_id'=> '1',
            'is_seller_request'=> false,
            'is_deleted'=>false,
            'password' => Hash::make('123123123'),
        ]);
        User::create([
            'user_type' => 'principal',
            'name' => 'principal',
            'email' => 'principal@email.com',
            'mobile_number' => '08321321321',
            'address' => 'address',
            'province_id'=> '1',
            'is_seller_request'=> false,
            'is_deleted'=>false,
            'password' => Hash::make('123123123'),
        ]);
    }
}
