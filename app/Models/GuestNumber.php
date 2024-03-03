<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 * @mixin Builder
 */
class GuestNumber extends Model
{
    use HasFactory;

    protected $table = "guest_number";

    protected $fillable = [
        'ip_address',
        'number_id',
        'number_date',
        'score'
    ];

    public $timestamps = false;

    public function number()
    {
        return $this->belongsTo(Number::class);
    }
}
