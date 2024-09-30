<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up()
    {
        Schema::create('friend_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sender_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('receiver_id')->constrained('users')->onDelete('cascade');
            $table->enum('status', ['pending', 'rejected'])->default('pending');
            $table->timestamps();
            $table->unique(['sender_id', 'receiver_id']);
        });
    }

   
    public function down(): void
    {
        Schema::dropIfExists('friend_requests');
    }
};