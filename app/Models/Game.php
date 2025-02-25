<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Game extends Model
{
    protected $table = 'games';

    protected $guarded = [];

    public function isWin(): Attribute
    {
        return Attribute::get( fn ($value, $attributes) => $attributes('is_win') );
    }

}
