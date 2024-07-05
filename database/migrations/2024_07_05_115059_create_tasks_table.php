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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('level_id');
            $table->string('name');
            $table->decimal('purchase_amount', 10, 2)->nullable();
            $table->timestamps();

            $table->foreign('level_id')->references('id')->on('levels')->onDelete('cascade');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('level_id')->nullable();
            $table->enum('gender', ['man', 'woman'])->default('man');

            $table->foreign('level_id', 'users_level_id_foreign')->references('id')->on('levels');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_level_id_foreign');
            $table->dropColumn('level_id');
            $table->dropColumn('gender');
        });
    }
};
