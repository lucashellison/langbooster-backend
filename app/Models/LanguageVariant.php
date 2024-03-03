<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 *
 * @mixin Builder
 */
class LanguageVariant extends Model
{
    use HasFactory;

    protected $fillable = ['learning_language_id', 'code', 'description', 'order', 'enabled'];
    public $timestamps = false;

    public function learningLanguage()
    {
        return $this->belongsTo(LearningLanguage::class);
    }
}
