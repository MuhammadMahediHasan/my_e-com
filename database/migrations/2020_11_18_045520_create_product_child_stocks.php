<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductChildStocks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_child_stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_stock_id')->constrained('product_stocks','id')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products','id')->onDelete('cascade');
            $table->foreignId('color_id')->nullable()->constrained('colors','id')->onDelete('cascade');
            $table->foreignId('size_id')->nullable()->constrained('sizes','id')->onDelete('cascade');
            $table->integer('quantity')->default(0);
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
        Schema::dropIfExists('product_child_stocks');
    }
}
