<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->tinyInteger('type')->default(1)->comment('1=category, 2=sub_category, 3=child_category');
            $table->foreignId('sub_category_id')->nullable()->constrained('categories', 'id')->onDelete('cascade');
            $table->foreignId('child_category_id')->nullable()->constrained('categories', 'id')->onDelete('cascade');
            $table->tinyInteger('status')->default(1);
            $table->foreignId('created_by')->nullable()->constrained('users', 'id')->onDelete('cascade');
            $table->foreignId('updated_by')->nullable()->constrained('users', 'id')->onDelete('cascade');
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
        Schema::dropIfExists('categories');
    }
}
