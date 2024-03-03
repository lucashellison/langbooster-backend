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
class Dictation extends Model
{
    use HasFactory;

    protected $fillable = [
        'dictation_topic_id',
        'language_variant_id',
        'premium',
        'title',
        'text',
        'path_audio',
        'sort_order',
        'enabled'
    ];

    public $timestamps = false;

    /**
     * Get the dictation topic associated with the dictation.
     */
    public function dictationTopic(): BelongsTo
    {
        return $this->belongsTo(DictationTopic::class);
    }

    /**
     * Get the language variant associated with the dictation.
     */
    public function languageVariant(): BelongsTo
    {
        return $this->belongsTo(LanguageVariant::class);
    }

}
