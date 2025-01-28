<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAuthorNameToSubmitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('submits', function (Blueprint $table) {
            $table->string('author_name')->after('user_id')->nullable(); // Replace 'column_name' with the column after which you want to add 'author_name'
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('submits', function (Blueprint $table) {
            $table->dropColumn('author_name');
        });
    }
}
