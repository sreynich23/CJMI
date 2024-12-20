<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'role')) {
                $table->string('role')->default('user');
            }
            if (!Schema::hasColumn('users', 'notifications_enabled')) {
                $table->boolean('notifications_enabled')->default(false);
            }
            if (!Schema::hasColumn('users', 'reviewer_available')) {
                $table->boolean('reviewer_available')->default(false);
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'notifications_enabled', 'reviewer_available']);
        });
    }
};
