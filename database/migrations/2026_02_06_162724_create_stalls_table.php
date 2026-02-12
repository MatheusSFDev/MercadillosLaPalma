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
        Schema::create('stalls', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('flea_market_id');
            $table->boolean("home_delivery")->default(false); // boolean / string
            $table->string("information")->nullable();
            $table->boolean("active")->default(true);
            $table->dateTime("reset_date")->nullable();
            $table->dateTime('register_date')->nullable();
            $table->string('name')->nullable();
            $table->string('img_url')->default('img/imgNotAvailable.png');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('flea_market_id')->references('id')->on('flea_markets')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stalls');
    }
};
