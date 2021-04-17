<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string("acid")->unique();
            $table->string('name');
            $table->string('phone')->unique();
            $table->string("email")->unique()->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('address')->nullable();
            $table->string('country')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('mobile_no')->nullable();
            $table->string('location')->nullable();
            $table->string('vatno')->nullable();
            $table->string('business')->nullable();
            $table->string('type')->default('supplier')->nullable();
            $table->enum('invoice_type', ['cash', 'credit', 'both'])->default('both')->nullable();
            $table->double('opening_balance', 12, 2)->default(0)->nullable();
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
        Schema::dropIfExists('suppliers');
    }
}
