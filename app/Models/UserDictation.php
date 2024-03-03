<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 * @mixin Builder
 */
class UserDictation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'dictation_id',
        'dictation_date',
        'score',
        'ip_address'
    ];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dictation()
    {
        return $this->belongsTo(Dictation::class);
    }
}
