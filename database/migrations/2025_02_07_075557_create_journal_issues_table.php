<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('journal_issues', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('id_volume_issue');
            $table->date('publication_date')->nullable();
            $table->year('year');
            $table->timestamps();

            // Foreign key constraint (if id_volume_issue references another table)
            $table->foreign('id_volume_issue')->references('id')->on('volume_issues')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('journal_issues');
    }
};
