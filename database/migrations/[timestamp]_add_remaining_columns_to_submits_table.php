<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('submits', function (Blueprint $table) {
            $table->string('file_path')->after('keywords');
            $table->string('original_filename')->after('file_path');
            $table->text('comments')->nullable()->after('original_filename');
        });
    }

    public function down()
    {
        Schema::table('submits', function (Blueprint $table) {
            $table->dropColumn([
                'file_path',
                'original_filename',
                'comments'
            ]);
        });
    }
};
