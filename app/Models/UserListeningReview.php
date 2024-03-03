<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 * @mixin Builder
 */
class UserListeningReview extends Model
{
    use HasFactory;

    protected $table = 'user_listening_review';

    protected $fillable = [
        'user_id',
        'listening_id',
        'review',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function listening()
    {
        return $this->belongsTo(Listening::class, 'listening_id');
    }
}
