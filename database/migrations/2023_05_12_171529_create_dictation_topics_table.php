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
        Schema::create('dictation_topics', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('learning_language_id');
            $table->string('description');
            $table->integer('sort_order');
            $table->integer('enabled')->default(1);

            $table->foreign('learning_language_id')
                ->references('id')
                ->on('learning_languages')
                ->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dictation_topics');
    }
};
