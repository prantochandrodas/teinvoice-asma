<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();

            $table->string('code', 30)->unique()->nullable();
            $table->string('name', 191)->unique();
            $table->float('price', 8,2)->default(0);
            $table->float('tax', 8,2)->default(0);
            $table->float('price_without_tax', 8,2)->default(0);
            $table->float('purchase_price', 8,2)->default(0);
            $table->float('quantity', 8,2)->default(0);
            $table->text('details')->nullable();
            $table->string('image', 100)->nullable();
            $table->integer('created_admin_id');
            $table->integer('updated_admin_id')->nullable();
            $table->tinyInteger('status')->default(1)->comment('0_for_inactive, 1_for_active');

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
        Schema::dropIfExists('items');
    }
}
