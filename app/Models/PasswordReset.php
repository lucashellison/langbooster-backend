<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 * @mixin Builder
 */
class PasswordReset extends Model
{
    use HasFactory;

    protected $table = 'password_resets';

    protected $fillable = ['user_id','token','expires_at','used'];

    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
