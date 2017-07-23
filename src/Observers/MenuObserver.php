<?php

namespace ctf0\SimpleMenu\Observers;

use ctf0\SimpleMenu\Models\Menu;
use Illuminate\Support\Facades\Cache;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class MenuObserver
{
    /**
     * Listen to the User saved event.
     */
    public function saved(Menu $menu)
    {
        return $this->cleanData($menu);
    }

    /**
     * Listen to the User deleting event.
     */
    public function deleted(Menu $menu)
    {
        return $this->cleanData($menu);
    }

    /**
     * helpers.
     *
     * @param [type] $menu [description]
     *
     * @return [type] [description]
     */
    protected function cleanData($menu)
    {
        foreach (array_keys(LaravelLocalization::getSupportedLocales()) as $code) {
            return Cache::forget("{$menu->name}Menu-{$code}Pages");
        }
    }
}