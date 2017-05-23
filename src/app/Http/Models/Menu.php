<?php

namespace App\Http\Models;

use Cache;

class Menu extends BaseModel
{
    protected $with = ['pages'];

    public static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            Cache::forget('menus');
        });
        static::updated(function ($model) {
            Cache::forget('menus');
        });
        static::deleted(function ($model) {
            Cache::forget('menus');
        });
    }

    public function pages()
    {
        return $this->belongsToMany(Page::class);
    }
}