<?php

namespace App;

trait MenusTrait
{
    /**
     * register routes for menu pages.
     *
     * @return [type] [description]
     */
    public function createMenus()
    {
        foreach (cache('menus')->pluck('name') as $name) {
            $this->viewComp($name);
        }
    }

    /**
     * [viewComp description].
     *
     * @param [type] $name [description]
     *
     * @return [type] [description]
     */
    public function viewComp($name)
    {
        $viewFile = view()->exists("menu.{$name}")
        ? "menu.{$name}"
        : 'menu.example';

        return view()->composer($viewFile, function ($view) use ($name) {
            $view->with([
                'PAGES' => $this->query($name),
            ]);
        });
    }

    /**
     * menu logic.
     *
     * @param [type]     $name [description]
     * @param null|mixed $nest
     *
     * @return [type] [description]
     */
    public function query($name)
    {
        return cache('menus')->where('name', $name)->first()->pages;
    }
}