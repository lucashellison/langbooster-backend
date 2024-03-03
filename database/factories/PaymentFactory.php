<?php

namespace Database\Factories;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition()
    {
        return [
            'stripe_payment_id' => $this->faker->uuid,
            'amount' => $this->faker->numberBetween(1000, 5000),
            'currency' => 'USD',
            'payment_status' => 'succeeded',
            'payment_date' => now(),
            'subscription_end_date' => now()->addYear(1)
        ];
    }
}
