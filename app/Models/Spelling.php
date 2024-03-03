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
class Spelling extends Model
{
    use HasFactory;

    protected $table = "spelling";

    protected $fillable = [
        'spelling_topic_id',
        'language_variant_id',
        'premium',
        'text',
        'path_normal_audio',
        'path_spelled_audio',
        'sort_order',
        'enabled'
    ];

    public $timestamps = false;

    /**
     * Get the spelling topic associated with the spelling.
     */
    public function spellingTopic(): BelongsTo
    {
        return $this->belongsTo(SpellingTopic::class);
    }

    /**
     * Get the language variant associated with the spelling.
     */
    public function languageVariant(): BelongsTo
    {
        return $this->belongsTo(LanguageVariant::class);
    }

}
