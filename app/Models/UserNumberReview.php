<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 * @mixin Builder
 */
class UserNumberReview extends Model
{
    use HasFactory;

    protected $table = 'user_number_review';

    protected $fillable = [
        'user_id',
        'number_id',
        'review',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function number()
    {
        return $this->belongsTo(Number::class, 'number_id');
    }
}
