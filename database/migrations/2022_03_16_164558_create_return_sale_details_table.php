<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReturnSaleDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('return_sale_details', function (Blueprint $table) {
            $table->id();
            $table->integer('return_sale_id');
            $table->integer('sale_detail_id');
            $table->integer('item_id')->default(0);
            $table->string('item_name',155)->nullable();
            $table->float('price', 8,2);
            $table->float('quantity', 8,2);
            $table->float('amount', 8,2);
            $table->tinyInteger('status')->default(1)->comment('1_for_active, 0_for_inactive');
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
        Schema::dropIfExists('return_sale_details');
    }
}
