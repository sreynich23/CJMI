<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVolumeIssueImagesTable extends Migration
{
    public function up()
    {
        Schema::create('volume_issue_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('volume_issue_id');
            $table->string('image_path');
            $table->timestamps();

            $table->foreign('volume_issue_id')->references('id')->on('volume_issues')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('volume_issue_images');
    }
}
