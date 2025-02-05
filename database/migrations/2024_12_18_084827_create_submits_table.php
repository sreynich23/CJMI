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
        Schema::create('submits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('author_name', 255);
            $table->string('prefix', 255);
            $table->string('title', 255);
            $table->string('subtitle', 255);
            $table->text('abstract');
            $table->string('keywords', 255);
            $table->string('file_path', 255);
            $table->string('original_filename', 255);
            $table->text('comments')->nullable();
            $table->string('status', 255);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submits');
    }
};
