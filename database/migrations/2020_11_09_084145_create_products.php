<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('name');
            $table->string('slug');
            $table->foreignId('vendor_id')->constrained('users', 'id')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('categories', 'id')->onDelete('cascade');
            $table->foreignId('sub_category_id')->constrained('categories', 'id')->onDelete('cascade');
            $table->foreignId('child_category_id')->nullable()->constrained('categories', 'id')->onDelete('cascade');
            $table->foreignId('attribute_id')->nullable()->constrained('attributes', 'id')->onDelete('cascade');
            $table->foreignId('attribute_value_id')->nullable()->constrained('attribute_values', 'id')->onDelete('cascade');
            $table->decimal('purchase_price',8,2)->default(0);
            $table->decimal('sale_price',8,2)->default(0);
            $table->text('description')->nullable();
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
        Schema::dropIfExists('products');
    }
}
