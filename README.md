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
- the package automatically register 4 middlewares to handle all the package routes, however to use them anywhere else, they are
    - `localizationRedirect`
    - `localeSessionRedirect`
    - `role:roleName`
    - `perm:permName`

### Good Practice
Ofcourse you are free to code your app the way you want, but just in-case here are the naming convention the package use.

| column name |                format                |   output   |
|-------------|--------------------------------------|------------|
| title       | title_case(some title)               | Some Title |
| route_name  | str_slug(Some Title)                 | some-title |
| action      | SomeController\camelCase(Some Title) | someTitle  |

## Notes
- you can get any page params like (**template, title, body, desc, breadCrump**) by using `extract(cache('the_route_name'));`

<u>**or**</u>

- if you followed the naming convention above and you are inside the `page action method`, you can instead use `extract(cache(kebab_case('TheCurrentMethodName')));`

    | method name |          format         | output = route_name |
    |-------------|-------------------------|---------------------|
    | contactUs   | kebab_case('contactUs') | contact-us          |

# ToDo

* [ ] CRUD Views for (roles/perms/pages/menus). *any help is appreciated*
* [ ] clear cache through pivot table events. *any help is appreciated*
