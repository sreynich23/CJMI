<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTablesForVolume extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('journal_issues', function (Blueprint $table) {
            // Remove the id_volume_issue_images column
            $table->dropColumn('id_volume_issue_images');
        });
        Schema::table('volume_issue', function (Blueprint $table) {
            $table->integer('volume')->after('issue')->nullable();
            $table->integer('issue')->after('volume')->nullable();
            $table->integer('year')->after('issue')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Revert changes in the volume_issue table
        Schema::table('journal_issues', function (Blueprint $table) {
            // Add back the removed columns
            $table->string('id_volume_issue_images')->nullable();
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('volume');
            $table->dropColumn('issue');
            $table->dropColumn('year');
        });
    }
}
