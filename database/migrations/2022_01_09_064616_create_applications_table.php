<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('arabic_name')->nullable();
            $table->integer('vat_percent',5);
            $table->string('develop_by', 500)->nullable();
            $table->string('contact_number');
            $table->string('email');
            $table->string('address');
            $table->string('photo',100);
            $table->string('vat_number',100)->nullable();
            $table->string('cr_no',100)->nullable();
            $table->string('locale',100)->default('en');
            $table->string('favicon',100)->nullable();
            $table->text('meta_author')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('google_map')->nullable();
            $table->integer('admin_id');
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
        Schema::dropIfExists('applications');
    }
}
