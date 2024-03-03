<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 * @mixin Builder
 */
class UserDictationsReview extends Model
{
    use HasFactory;

    protected $table = 'user_dictations_review';

    protected $fillable = [
        'user_id',
        'dictation_id',
        'review',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function dictation()
    {
        return $this->belongsTo(Dictation::class, 'dictation_id');
    }
}
