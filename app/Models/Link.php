<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    protected $guarded = [];

    public function scopeValid(Builder $query): void
    {
        $query->where('valid', true);
    }
}
