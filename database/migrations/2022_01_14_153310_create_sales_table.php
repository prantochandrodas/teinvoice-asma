<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('bill_no',100)->nullable();
            $table->string('bill_type',100)->nullable();
            $table->integer('customer_id')->default(0);
            $table->text('note')->nullable();
            $table->float('total_quantity', 8,2);
            $table->float('grand_amount', 8,2);
            $table->float('discount_amount', 8,2);
            $table->float('tax_amount', 8,2);
            $table->float('final_amount', 8,2);
            $table->float('total_unit_cost', 8,2)->default(0)->nullable();

            // $table->float('return_total_quantity', 6,2)>default(0)->nullable();
            $table->float('return_total_amount', 8,2)->default(0)->nullable();

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
        Schema::dropIfExists('sales');
    }
}
