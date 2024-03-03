<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 * @mixin Builder
 */
class UserSpelling extends Model
{
    use HasFactory;

    protected $table = "user_spelling";

    protected $fillable = [
        'user_id',
        'spelling_id',
        'spelling_date',
        'score',
        'ip_address'
    ];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function spelling()
    {
        return $this->belongsTo(Spelling::class);
    }
}
