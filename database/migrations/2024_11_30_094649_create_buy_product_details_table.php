<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuyProductDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buy_product_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buy_product_id')->constrained()->onDelete('cascade');
            $table->string('purchase_no')->nullable();
            $table->string('supplier_name')->nullable();
            $table->string('item_code')->nullable();
            $table->string('item_name')->nullable();
            $table->float('item_buy_bill',12,2)->nullable();
            $table->float('total_cost',12,2)->nullable();
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
        Schema::dropIfExists('buy_product_details');
    }
}
