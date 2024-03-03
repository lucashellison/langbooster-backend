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
        Schema::create('number', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('number_topic_id');
            $table->unsignedBigInteger('language_variant_id');
            $table->integer('premium')->default(0);
            $table->text('text');
            $table->string('path_audio');
            $table->integer('sort_order');
            $table->integer('enabled')->default(1);

            $table->foreign('number_topic_id')
                ->references('id')
                ->on('number_topics')
                ->onDelete('cascade');

            $table->foreign('language_variant_id')
                ->references('id')
                ->on('language_variants')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('number');
    }
};
