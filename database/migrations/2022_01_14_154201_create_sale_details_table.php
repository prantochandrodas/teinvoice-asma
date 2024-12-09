<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_details', function (Blueprint $table) {
            $table->id();
            $table->integer('sale_id');
            $table->integer('item_id')->default(0);
            $table->string('item_name',155)->nullable();
            $table->float('price', 8,2);
            $table->float('tax', 8,2);
            $table->float('quantity', 8,2);
            $table->float('amount', 8,2);
            // $table->float('return_quantity', 6,2)>default(0)->nullable();
            $table->float('return_amount', 8,2)->default(0)->nullable();
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
        Schema::dropIfExists('sale_details');
    }
}
