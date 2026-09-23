<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('user')->after('email'); // super_admin, admin, reviewer, user
            $table->string('department')->nullable()->after('role');
            $table->boolean('is_active')->default(true)->after('department');
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'department', 'is_active']);
            $table->dropSoftDeletes();
        });
    }
};
