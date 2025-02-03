<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameCoverImageToPageInArticlesTable extends Migration
{
    public function up()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->renameColumn('cover_image', 'page');
        });
    }

    public function down()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->renameColumn('page', 'cover_image');
        });
    }
}
