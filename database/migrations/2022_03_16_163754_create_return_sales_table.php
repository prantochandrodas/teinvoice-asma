<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReturnSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('return_sales', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->integer('sale_id')->default(0);
            $table->integer('customer_id')->default(0)->nullable();
            $table->text('note')->nullable();
            $table->float('total_quantity', 8,2);
            $table->float('grand_amount', 8,2);
            $table->tinyInteger('status')->default(1)->comment('1_for_active, 0_for_inactive');
            $table->integer('created_admin_id')->nullable();
            $table->integer('updated_admin_id')->nullable();
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
        Schema::dropIfExists('return_sales');
    }
}
