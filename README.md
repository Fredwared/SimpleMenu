- Dependencies
    > - Permissions
    >   - https://github.com/spatie/laravel-permission

    > - MultiLocale
    >   - https://github.com/spatie/laravel-translatable
    >   - https://github.com/mcamara/laravel-localization

    > - Menu Nested Set
    >   - https://github.com/gazsp/baum

- Javascript
    + [jQuery](https://jquery.com/) (cdn)
    + [select2](https://select2.github.io/) (cdn)
    + [tinymce](https://www.tinymce.com/) (cdn)
    + [Vue](https://vuejs.org/)
    + [vuedraggable](https://github.com/SortableJS/Vue.Draggable)
    + [notification-component](https://github.com/ctf0/Notification-Component)

## Installation

- `composer require ctf0/simple-menu`

- add the service provider & facade to `config/app.php`

    - all the package dependencies "serviceProvider & aliases" are registerd with the package.

```php
'providers' => [
    ctf0\SimpleMenu\SimpleMenuServiceProvider::class,
]

'aliases' => [
    'SimpleMenu' => ctf0\SimpleMenu\Facade\SimpleMenu::class,
]
```

- the package relay heavily on caching through **Redis**, so make sure to check the [docs](https://laravel.com/docs/5.4/redis) for installation & configuration.

- publish the packages assets with `php artisan vendor:publish`
    - for simpleMenu [Wiki](https://github.com/ctf0/simple-menu/wiki/Publish)
    - also check the **Dependencies** packages for "configuration/options/migrations".

## Config
**config/simpleMenu.php**
```php
return [
    /*
     * the menu list classes to be used for "render()"
     */
    'listClasses' => [
        'ul' => 'menu-list',
        'li' => 'list-item',
        'a'  => 'is-active',
    ],

    /*
     * where to search for the template views ? (relative to "resources\views" folder)
     */
    'templatePath' => 'pages',

    /*
     * the path where we will save the routes list
     */
    'routeListPath' => storage_path('logs/simpleMenu.php'),

    /*
     * where to redirect when a route is available in one locale "en" but not in another "fr" ?
     */
    'unFoundLocalizedRoute' => 'home',

    /*
     * pages action controller namespace
     */
    'pagesControllerNS' => 'App\Http\Controllers',

    /*
     * the user model we are going to use for the admin page
     */
    'userModel' => App\User::class,

    /*
     * by default when removing a nested page, all of its 'Descendants' gets cleared.
     * but what about when removing the root, do you also want the same behavior ?
     */
    'clearRootDescendants' => false,

    /*
     * crud views url prefix
     */
    'crud_prefix' => 'admin',

    /*
     * css farmework for admin pages
     */
    'framework' => 'bulma',
];
```

## Usage
[Wiki](https://github.com/ctf0/simple-menu/wiki/Usage)

### Crud Views
[Wiki](https://github.com/ctf0/SimpleMenu/wiki/Crud-Views)
