<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('journal_information', function (Blueprint $table) {
            $table->id();
            $table->string('journal_name')->default('Cambodian Journal of Multidisciplinary Research and Innovation');
            $table->string('telegram')->default('+855 85593115');
            $table->string('email')->default('cjer.journal@gmail.com');
            $table->string('editorial_office')->default('Phnom Penh, Cambodia');
            $table->string('license_text')->default('This work is licensed under a Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International License.');
            $table->string('developer')->default('LONG SREYNICH');
            $table->string('publisher')->default('Cambodian Education Forum');
            $table->string('website')->default('https://example.com');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('journal_information');
    }
};
