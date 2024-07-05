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
        Schema::create('levels', function (Blueprint $table) {
            $table->id();
            $table->string('name_man', 50)->unique();
            $table->string('name_woman', 50)->unique();
            $table->timestamps();
        });

        DB::table('levels')->insert([
            [
                'name_man' => 'Незнакомец',
                'name_woman' => 'Незнакомка',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_man' => 'Лояльный хозаяц',
                'name_woman' => 'Лояльная хозаюшка',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_man' => 'VIP-хозаяц',
                'name_woman' => 'VIP–хозаюшка',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('levels');
    }
};
