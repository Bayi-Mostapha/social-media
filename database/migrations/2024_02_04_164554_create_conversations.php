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
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id1')->references('id')->on('users')->cascadeOnDelete();
            $table->foreignId('user_id2')->references('id')->on('users')->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['user_id1', 'user_id2']);
        });            
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conversations');
    }
};
