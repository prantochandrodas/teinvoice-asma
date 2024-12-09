<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('username', 30)->unique();
            $table->string('email', 100)->unique();
            $table->string('phone', 20)->unique();
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->string('password', 191);
            $table->string('store_password', 100);
            $table->text('address')->nullable();
            $table->string('photo', 100)->nullable();
            $table->tinyInteger('status')->default(1)->comment('1_for active, 0_for inactive');
            $table->tinyInteger('email_verification')->default(0)->comment('0_for not verified, 1_for verified');
            $table->tinyInteger('phone_verification')->default(0)->comment('0_for not verified, 1_for verified');
            $table->rememberToken();
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
        Schema::dropIfExists('admins');
    }
}
