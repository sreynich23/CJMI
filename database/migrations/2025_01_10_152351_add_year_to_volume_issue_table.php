<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('volume_issue', function (Blueprint $table) {
        $table->integer('year')->after('issue')->nullable(); // Add year column after issue
    });
}

public function down()
{
    Schema::table('volume_issue', function (Blueprint $table) {
        $table->dropColumn('year'); // Rollback the column if needed
    });
}

};
