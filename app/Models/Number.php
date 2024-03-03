<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 *
 * @mixin Builder
 */
class Number extends Model
{
    use HasFactory;

    protected $table = "number";

    protected $fillable = [
        'number_topic_id',
        'language_variant_id',
        'premium',
        'text',
        'path_audio',
        'sort_order',
        'enabled'
    ];

    public $timestamps = false;

    /**
     * Get the number topic associated with the number.
     */
    public function numberTopic(): BelongsTo
    {
        return $this->belongsTo(NumberTopic::class);
    }

    /**
     * Get the language variant associated with the number.
     */
    public function languageVariant(): BelongsTo
    {
        return $this->belongsTo(LanguageVariant::class);
    }

}
