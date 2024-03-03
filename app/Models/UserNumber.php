<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 * @mixin Builder
 */
class UserNumber extends Model
{
    use HasFactory;

    protected $table = "user_number";

    protected $fillable = [
        'user_id',
        'number_id',
        'number_date',
        'score',
        'ip_address'
    ];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function number()
    {
        return $this->belongsTo(Number::class);
    }
}
