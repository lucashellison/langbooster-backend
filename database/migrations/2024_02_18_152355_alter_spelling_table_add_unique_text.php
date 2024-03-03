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
        Schema::table('spelling', function (Blueprint $table) {
            $table->unique('text', 'unique_text_spelling');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('spelling', function (Blueprint $table) {
            $table->dropUnique('unique_text_spelling');
        });
    }
};
