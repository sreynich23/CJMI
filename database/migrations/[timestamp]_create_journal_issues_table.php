<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('journal_issues', function (Blueprint $table) {
            $table->id();
            $table->string('journal_name');
            $table->integer('current_volume')->default(1);
            $table->integer('current_issue')->default(1);
            $table->text('description')->nullable();
            $table->json('issues')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('journal_issues');
    }
};