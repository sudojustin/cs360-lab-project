<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('status');
            $table->decimal('total_price', 8, 2);
            $table->string('shipping_address');
            $table->string('payment_status');
            $table->string('payment_provider');
            $table->string('payment_transaction_id')->nullable();
            $table->timestamp('placed_at');
            $table->timestamps();

            // Define the foreign key to users table
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
