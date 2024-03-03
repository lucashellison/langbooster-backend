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
        Schema::table('payments', function (Blueprint $table) {
            $table->string('stripe_payment_id')->nullable()->change();
            $table->timestamp('payment_date')->nullable()->change();
            $table->timestamp('subscription_end_date')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->string('stripe_payment_id')->nullable(false)->change();
            $table->timestamp('payment_date')->nullable(false)->change();
            $table->timestamp('subscription_end_date')->nullable(false)->change();
        });
    }
};
