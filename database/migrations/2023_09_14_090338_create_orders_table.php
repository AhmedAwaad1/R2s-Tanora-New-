<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->unsignedBigInteger('user_id');
            $table->string('address');
            $table->string('code');
            $table->double('lng');
            $table->double('lat');
            $table->double('total_price');
            $table->date('date');
            $table->enum('time', ['8-12', '3-6']);
            $table->enum('status', ['pending', 'approved', 'in_progress', 'canceled', 'delivered']);
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
        Schema::dropIfExists('orders');
    }
}
