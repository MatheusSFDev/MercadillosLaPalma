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
        Schema::create('stalls_category', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id');    
            $table->unsignedBigInteger('stall_id');
            $table->primary(['stall_id', 'category_id']);

            $table->foreign('stall_id')->references('id')->on('stalls')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stalls_category');
    }
};
