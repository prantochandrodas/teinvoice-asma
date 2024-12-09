<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEasySaleItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('easy_sale_items', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('item_id')->default(0);
            $table->tinyInteger('status')->default(1)->comment('1_for_active, 0_for_inactive');
            $table->integer('created_admin_id')->nullable();
            $table->integer('updated_admin_id')->nullable();

            $table->softDeletes();
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
        Schema::dropIfExists('easy_sale_items');
    }
}
