<?php

namespace App;

use App\Http\Models\Menu;
use App\Http\Models\Page;
use Cache;

class SimpleMenu
{
    use RoutesTrait, MenusTrait, NavigationTrait;

    protected $listFileDir;

    public function __construct()
    {
        $this->listFileDir = config('simpleMenu.routeListPath');
        view()->share(config('simpleMenu.viewVar'), $this);
    }

    /**
     * [createCache description].
     *
     * @return [type] [description]
     */
    public function createCache()
    {
        // for creating the routes
        Cache::rememberForever('pages', function () {
            return Page::get();
        });

        // for creating the menu
        Cache::rememberForever('menus', function () {
            return Menu::get();
        });
    }
}
