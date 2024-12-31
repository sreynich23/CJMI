<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddYearToJournalIssuesTable extends Migration
{
    public function up()
    {
        Schema::table('journal_issues', function (Blueprint $table) {
            $table->integer('year')->after('issue')->nullable()->comment('Year of the journal issue');
        });
    }

    public function down()
    {
        Schema::table('journal_issues', function (Blueprint $table) {
            $table->dropColumn('year');
        });
    }
}
