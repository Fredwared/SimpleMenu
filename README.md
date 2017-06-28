- Package Uses
    > - Permissions
    >   - https://github.com/spatie/laravel-permission

    > - MultiLocale
    >   - https://github.com/spatie/laravel-translatable
    >   - https://github.com/mcamara/laravel-localization

    > - Menu Nested Set
    >   - https://github.com/gazsp/baum

## Installation

- `composer require ctf0/simple-menu`

- add the service provider & facade to `config/app.php`
```php
'providers' => [
    ctf0\SimpleMenu\SimpleMenuServiceProvider::class,
]

'aliases' => [
    'SimpleMenu' => ctf0\SimpleMenu\Facade\SimpleMenu::class,
]
```

- publish the package assets with `php artisan vendor:publish` [Wiki](https://github.com/ctf0/simple-menu/wiki/Publish)

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
     * where to search for the template views relative to "resources\views" folder
     */
    'templatePath' => 'pages',

    /*
     * the path where we will save the route list for multiLocal route resolving
     */
    'routeListPath' => storage_path('logs/simpleMenu.php'),

    /*
     * what happens when a route is available in one locale "en" but not in another "fr", add either
     * 'home' = '/' or
     * 'error' = '404'
     */
    'unFoundLocalizedRoute' => 'home',

    /*
     * pages controller namespace
     */
    'pagesControllerNS'=> 'App\Http\Controllers',
];
```

## Usage
[Wiki](https://github.com/ctf0/simple-menu/wiki/Usage)

### MiddleWares
- the package automatically register 2 middlewares `role & perm` to handle all the routes, however to use them on any other routes, use
    ```php
    Route::group(['middleware' => ['role:admin','perm:access_backend']], function () {
        // ...
    });
    ```

### Good Practice
Ofcourse you are free to code your app the way you want, but just in-case here are the naming convention the package use.

- `title`       > `title_case(some title)`
- `route_name`  > `str_slug(title)`
- `action`      > `SomeController\camelCase(title)`

## Notes
- for the pages with "action" you can get all the page params like **template, title, body, desc, breadCrump** inside your "action@method" by using `extract(cache('the_route_name'));`

<u>**or**</u>
- if you followed the naming convention above, you can instead use `extract(cache(kebab_case('TheCurrentMethodName')));`

# ToDo

* [ ] CRUD Views for (roles/perms/pages/menus). *any help is appreciated*
* [ ] clear cache through pivot table events. *any help is appreciated*
