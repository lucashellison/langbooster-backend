<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 * @mixin Builder
 */
class Payment extends Model
{
    use HasFactory;

    protected $table = "payments";
    protected $fillable = ['stripe_payment_id','amount','currency','payment_status','payment_date','subscription_end_date'];
    public $timestamps = true;
}
