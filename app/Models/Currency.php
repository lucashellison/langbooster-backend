<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 * @mixin Builder
 */
class Currency extends Model
{
    use HasFactory;

    protected $table = "currencies";
    protected $fillable = ['code','name'];
    public $timestamps = true;
}
