<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 * @mixin Builder
 */
class UserListening extends Model
{
    use HasFactory;

    protected $table = "user_listening";

    protected $fillable = [
        'user_id',
        'listening_id',
        'listening_date',
        'score',
        'ip_address'
    ];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function listening()
    {
        return $this->belongsTo(Listening::class);
    }
}
