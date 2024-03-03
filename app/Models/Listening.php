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
class Listening extends Model
{
    use HasFactory;

    protected $table = "listening";

    protected $fillable = [
        'listening_topic_id',
        'language_variant_id',
        'premium',
        'text',
        'path_audio',
        'sort_order',
        'enabled'
    ];

    public $timestamps = false;

    /**
     * Get the listening topic associated with the listening.
     */
    public function listeningTopic(): BelongsTo
    {
        return $this->belongsTo(ListeningTopic::class);
    }

    /**
     * Get the language variant associated with the listening.
     */
    public function languageVariant(): BelongsTo
    {
        return $this->belongsTo(LanguageVariant::class);
    }

}
