<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->string('firstname');
            $table->string('lastname');
            $table->json('roles')->nullable();
        });

        \App\Models\User::where('email','admin@damin.com')
            ->update(['roles' => json_encode(['admin']), 'firstname' => 'Гульмира', 'lastname' => 'Земкина']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('roles');
            $table->dropColumn('firstname');
            $table->dropColumn('lastname');
            $table->string('name');
        });
    }
};
