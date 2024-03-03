<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 * @mixin Builder
 */
class GuestListening extends Model
{
    use HasFactory;

    protected $table = "guest_listening";

    protected $fillable = [
        'ip_address',
        'listening_id',
        'listening_date',
        'score'
    ];

    public $timestamps = false;

    public function listening()
    {
        return $this->belongsTo(Listening::class);
    }
}
