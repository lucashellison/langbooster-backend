<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 * @mixin Builder
 */
class UserSpellingReview extends Model
{
    use HasFactory;

    protected $table = 'user_spelling_review';

    protected $fillable = [
        'user_id',
        'spelling_id',
        'review',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function spelling()
    {
        return $this->belongsTo(Spelling::class, 'spelling_id');
    }
}
