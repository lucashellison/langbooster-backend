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
        Schema::create('dictations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dictation_topic_id');
            $table->unsignedBigInteger('language_variant_id');
            $table->integer('premium')->default(0);
            $table->string('title');
            $table->text('text');
            $table->string('path_audio');
            $table->integer('sort_order');
            $table->integer('enabled')->default(1);

            $table->foreign('dictation_topic_id')
                ->references('id')
                ->on('dictation_topics')
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
        Schema::dropIfExists('dictations');
    }
};
