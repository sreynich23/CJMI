<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKeywordsAndSubtitleToArticlesTable extends Migration
{
    public function up()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->string('subtitle')->nullable()->after('title')->comment('Subtitle of the article');
            $table->text('keywords')->nullable()->after('abstract')->comment('Keywords for the article');
        });
    }

    public function down()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn('subtitle');
            $table->dropColumn('keywords');
        });
    }
}
