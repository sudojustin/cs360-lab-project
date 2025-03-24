<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderProductTable extends Migration
{
    public function up()
    {
        Schema::create('order_product', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->integer('quantity'); // Quantity of the product
            $table->decimal('price', 8, 2); // Price of the product when ordered
            $table->timestamps(); // Optional, based on whether you need to track time
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_product');
    }
}
