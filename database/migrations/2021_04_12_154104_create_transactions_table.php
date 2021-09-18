<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id('transaction_id');
            $table->Integer('buyer_user_id');
            $table->Integer('seller_user_id');
            $table->Integer('admin_id')->nullable();
            $table->String('payment_status')->nullable(); 
            $table->Date('payment_date')->nullable();
            $table->String('bank_account_owner')->nullable();
            $table->String('proof_of_payment')->nullable();
            $table->Integer('transaction_detail_id');
            $table->Decimal('transaction_total_cost');
            $table->String('transaction_status');
            $table->Text('additional_info')->nullable();
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
        Schema::dropIfExists('transactions');
    }
}
