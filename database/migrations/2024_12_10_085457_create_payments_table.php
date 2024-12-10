<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sale_id')->nullable();
            $table->foreign('sale_id')->on('sales')->references('id');
            $table->tinyInteger('payment_type')->comment('1 = Sale Payment, 2 = Due Payment')->nullable();
            $table->string('voucher_number')->nullable(); 
            $table->decimal('pay_amount', 8, 2)->nullable();
            $table->date('payment_date')->nullable();
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
        Schema::dropIfExists('payments');
    }
}
