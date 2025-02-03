<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('journal_issue_id'); // Foreign key reference
            $table->string('title', 255);
            $table->string('subtitle', 255)->nullable();
            $table->text('abstract')->nullable();
            $table->text('keywords')->nullable();
            $table->string('pdf_url', 255);
            $table->integer('page');
            $table->string('doi')->nullable();
            $table->timestamps(); // created_at and updated_at

            // Foreign key constraint (assuming 'journal_issues' table exists)
            $table->foreign('journal_issue_id')->references('id')->on('journal_issues')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('articles');
    }
};
