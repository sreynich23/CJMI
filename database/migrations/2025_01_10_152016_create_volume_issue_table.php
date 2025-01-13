<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('volume_issue', function (Blueprint $table) {
        $table->id(); // Primary key
        $table->integer('volume'); // Volume field
        $table->integer('issue');  // Issue field
        $table->timestamps(); // Adds created_at and updated_at fields
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('volume_issue');
    }
};
