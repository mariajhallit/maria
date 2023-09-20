<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id()->unique();
            $table->text('description');
            $table->decimal('price')->nullable(false);
            $table->string('image');
           
           
            $table->timestamps();
            $table->index('category_id');
            $table->unsignedBigInteger('category_id');
           
           
           
            $table->foreign('category_id')
            ->references('id')
            ->on('categories')
            ->onDelete('cascade');


        });
    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
