<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 * @mixin Builder
 */
class GuestDictation extends Model
{
    use HasFactory;

    protected $table = "guest_dictations";

    protected $fillable = [
        'ip_address',
        'dictation_id',
        'dictation_date',
        'score'
    ];

    public $timestamps = false;

    public function dictation()
    {
        return $this->belongsTo(Dictation::class);
    }
}
