<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        DB::table('journal_information')
            ->where('id', 1)
            ->update(['journal_name' => 'Cambodian Journal of Multidisciplinary Research and Innovation']);
    }

    public function down()
    {
        DB::table('journal_information')
            ->where('id', 1)
            ->update(['journal_name' => 'CJER']);
    }
};
