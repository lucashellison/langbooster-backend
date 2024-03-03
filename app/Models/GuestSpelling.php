<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 * @mixin Builder
 */
class GuestSpelling extends Model
{
    use HasFactory;

    protected $table = "guest_spelling";

    protected $fillable = [
        'ip_address',
        'spelling_id',
        'spelling_date',
        'score'
    ];

    public $timestamps = false;

    public function spelling()
    {
        return $this->belongsTo(Spelling::class);
    }
}
