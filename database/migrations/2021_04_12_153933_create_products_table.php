<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id('product_id');
            $table->Integer('user_id');
            $table->String('product_name');
            $table->String('category');
            $table->float('weight',11,3);
            $table->float('price',12,3);
            $table->String('unit');
            $table->Integer('quantity');
            $table->Integer('condition')->nullable();
            $table->float('rim_diameter',11,3)->nullable();
            $table->float('front_rim_width',11,3)->nullable();
            $table->float('rear_rim_width',11,3)->nullable();
            $table->float('front_offset',11,3)->nullable();
            $table->float('rear_offset',11,3)->nullable();
            $table->Integer('pcd_1')->nullable();
            $table->Integer('pcd_2')->nullable();
            $table->float('tire_diameter',11,3)->nullable();
            $table->float('tire_width',11,3)->nullable();
            $table->float('tire_width_ratio',11,3)->nullable();
            $table->Text('description');
            $table->Boolean('is_deleted');
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
        Schema::dropIfExists('products');
    }
}
