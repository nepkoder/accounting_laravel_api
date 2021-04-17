<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_main')->create('users', function (Blueprint $table) {
            $table->id();
            $table->uuid("uuid")->unique();
            $table->string('name', 50);
            $table->string('email', 50)->unique()->nullable();
            $table->string("phone", 50)->unique()->nullable();
            $table->string("address", 100)->nullable();
            $table->string("device_id", 50)->nullable();
            $table->string("city", 50)->nullable();
            $table->string("country", 50)->nullable()->default("Nepal");
            $table->ipAddress("ip_address")->nullable();
            $table->tinyInteger("status")->default(1);
            $table->tinyInteger("is_block")->default(0);
            $table->tinyInteger("verified")->default(0);
            $table->dateTime("verified_at")->nullable();
            $table->string("password")->nullable();
            $table->string("image")->nullable();
            $table->string("fcm")->nullable();
            $table->integer('company_id')->nullable();
            $table->string("active_date_time")->nullable();
            $table->timestamps();
        });

        Schema::connection('mysql_main')->create('company', function (Blueprint $table) {
            $table->id();
            $table->uuid("cuid")->unique();
            $table->string('name', 50);
            $table->string('email', 50)->unique()->nullable();
            $table->string("phone", 50)->unique()->nullable();
            $table->string("address", 100)->nullable();
            $table->string("city", 50)->nullable();
            $table->string("vatpan", 15)->nullable();
            $table->string("country", 50)->nullable()->default("Nepal");
            $table->tinyInteger("status")->default(1);
            $table->tinyInteger("is_block")->default(0);
            $table->tinyInteger("payment_pending")->default(0);
            $table->tinyInteger("verified")->default(0);
            $table->dateTime("verified_at")->nullable();
            $table->string("password")->nullable();
            $table->string("image")->nullable();
            $table->string("fcm")->nullable();
            $table->string("active_date_time")->nullable();
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
        Schema::connection("mysql_main")->dropIfExists('users');
        Schema::connection("mysql_main")->dropIfExists('company');
    }
}
