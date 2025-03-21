<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPathImageToEditorialTeamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('editorial_teams', function (Blueprint $table) {
            // Add the path_image column
            $table->string('path_image')->nullable()->after('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('editorial_teams', function (Blueprint $table) {
            // Drop the path_image column if rolling back
            $table->dropColumn('path_image');
        });
    }
}
