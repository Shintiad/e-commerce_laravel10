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
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); 
            $table->unsignedBigInteger('product_id'); 
            $table->integer('quantity')->default(1);
            $table->timestamps();

            // Menambahkan indeks ke kolom user_id dan product_id untuk performa pencarian yang lebih baik
            $table->index('user_id');
            $table->index('product_id');
            
            // Menambahkan foreign key constraint untuk mengaitkan cart dengan user dan product
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
            $table->dropForeign(['product_id']);
            $table->dropColumn('product_id');
        });
        Schema::dropIfExists('carts');
    }
};
