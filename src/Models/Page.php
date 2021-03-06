<?php

namespace ctf0\SimpleMenu\Models;

use Baum\Node;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Page extends Node
{
    use HasRoles, HasTranslations, SoftDeletes;

    protected $with       = ['roles', 'permissions', 'menus'];
    protected $appends    = ['nests'];
    protected $guard_name = 'web';
    protected $hidden     = [
        'children', 'roles', 'permissions', 'menus',
        'pivot', 'parent_id', 'lft', 'rgt', 'depth',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    public $translatable = [
        'title', 'body', 'desc', 'prefix',
        'url', 'meta',
    ];

    public function menus()
    {
        return $this->belongsToMany(config('simpleMenu.models.menu'));
    }

    protected function getCrntLocale()
    {
        return LaravelLocalization::getCurrentLocale();
    }

    /**
     * override HasTranslations\getAttributeValue().
     *
     * @param [type] $key [description]
     *
     * @return [type] [description]
     */
    public function getAttributeValue($key)
    {
        if (!$this->isTranslatableAttribute($key)) {
            return parent::getAttributeValue($key);
        }

        return $this->getTranslationWithoutFallback($key, $this->getCrntLocale());
    }

    /**
     * Menus.
     *
     * @param [type] $menus [description]
     *
     * @return [type] [description]
     */
    public function assignToMenus($menus)
    {
        $this->menus()->attach($menus);
        $this->touch();
    }

    public function syncMenus($menus)
    {
        $this->menus()->sync($menus);
        $this->touch();
    }

    /**
     * Nesting.
     *
     * @param mixed $columns
     *
     * @return [type] [description]
     */
    public function getAncestors($columns = ['*'])
    {
        return app('cache')->tags('sm')->rememberForever($this->getCrntLocale() . "-{$this->route_name}_ancestors", function () use ($columns) {
            return $this->ancestors()->get($columns);
        });
    }

    public function getNestsAttribute()
    {
        return app('cache')->tags('sm')->rememberForever($this->getCrntLocale() . "-{$this->route_name}_nests", function () {
            return array_flatten(current($this->getDescendants()->toHierarchy()));
        });
    }

    /**
     * clear Nesting.
     *
     * @return [type] [description]
     */
    public function destroyDescendants()
    {
        if (config('simpleMenu.deletePageAndNests')) {
            parent::destroyDescendants();
        } else {
            $this->clearNests();
        }
    }

    public function clearSelfAndDescendants()
    {
        $this->makeRoot();
        $this->clearNests();
    }

    protected function clearNests()
    {
        $lft = $this->getLeft();
        $rgt = $this->getRight();

        if (is_null($lft) || is_null($rgt)) {
            return;
        }

        $lftCol = $this->getLeftColumnName();
        $rgtCol = $this->getRightColumnName();

        $this->where($lftCol, '>', $lft)->where($rgtCol, '<', $rgt)->each(function ($one) {
            $one->makeRoot();
        });

        $this->touch();
    }
}
