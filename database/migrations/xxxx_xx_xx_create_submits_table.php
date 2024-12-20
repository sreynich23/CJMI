<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('submits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('prefix')->nullable();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->text('abstract');
            $table->string('keywords');
            $table->string('file_path');
            $table->string('original_filename');
            $table->string('status')->default('pending');
            $table->text('comments')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('submits');
    }
};
