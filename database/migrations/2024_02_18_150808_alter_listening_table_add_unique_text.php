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
        Schema::table('listening', function (Blueprint $table) {
            $table->unique('text', 'unique_text_listening');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('listening', function (Blueprint $table) {
            $table->dropUnique('unique_text_listening');
        });
    }
};
