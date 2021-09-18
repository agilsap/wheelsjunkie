<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('user_id');
            $table->String('user_type');
            $table->String('email')->unique();
            $table->String('password');
            $table->String('name');
            $table->String('address');
            $table->String('mobile_number');
            $table->String('profile_picture')->nullable();
            $table->Integer('province_id');
            $table->Boolean('is_seller_request')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->String('cart_list')->nullable();
            $table->String('wishlist')->nullable();
            $table->Boolean('is_deleted')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
