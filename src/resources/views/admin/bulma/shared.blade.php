<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('description', '')">
    <title>@yield('title', '')</title>

    <link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <link href="//cdnjs.cloudflare.com/ajax/libs/bulma/0.5.0/css/bulma.min.css" rel="stylesheet" />

    {{-- jquery --}}
    <script src="//code.jquery.com/jquery-3.1.1.min.js"></script>
    {{-- select2 --}}
    <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    {{-- tinymce --}}
    <script src="//cdnjs.cloudflare.com/ajax/libs/tinymce/4.6.4/tinymce.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.6.4/plugins/lists/plugin.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.6.4/plugins/link/plugin.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.6.4/plugins/image/plugin.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.6.4/plugins/spellchecker/plugin.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.6.4/plugins/fullscreen/plugin.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.6.4/plugins/media/plugin.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.6.4/plugins/table/plugin.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/tinymce/4.6.4/plugins/preview/plugin.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/tinymce/4.6.4/plugins/contextmenu/plugin.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/tinymce/4.6.4/plugins/autoresize/plugin.min.js"></script>
</head>

<body>
    <section id="app">

        {{-- notif --}}
        <div class="notif-container">
            <my-notification></my-notification>
        </div>

        {{-- Body --}}
        <div class="container">
            <div class="columns">
                {{-- Sidebar --}}
                <div class="column">
                    <aside class="menu">
                        <ul class="menu-list">
                            <li><a class="{{ URL::is($crud_prefix.'.users.index') ? 'is-active' : '' }}" href="{{ route($crud_prefix.'.users.index') }}">Users</a></li>
                            <li><a class="{{ URL::is($crud_prefix.'.roles.index') ? 'is-active' : '' }}" href="{{ route($crud_prefix.'.roles.index') }}">Roles</a></li>
                            <li><a class="{{ URL::is($crud_prefix.'.permissions.index') ? 'is-active' : '' }}" href="{{ route($crud_prefix.'.permissions.index') }}">Permissions</a></li>
                            <li><a class="{{ URL::is($crud_prefix.'.pages.index')  ? 'is-active' : '' }}" href="{{ route($crud_prefix.'.pages.index') }}">Pages</a></li>
                            <li>
                                <a class="{{ URL::is($crud_prefix.'.menus.index') ? 'is-active' : '' }}" href="{{ route($crud_prefix.'.menus.index') }}">Menus</a>
                                <ul>
                                    @foreach (Cache::tags('sm')->get('menus') as $menu)
                                        <li data-id="menu-{{ $menu->id }}">
                                            <a class="{{ URL::is($crud_prefix.'.menus.edit',['id'=>$menu->id]) ? 'is-active' : '' }}" href="{{ route($crud_prefix.'.menus.edit',[$menu->id]) }}">{{ $menu->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        </ul>
                    </aside>
                </div>

                {{-- Pages --}}
                <div class="column">
                    @yield('sub')
                </div>
            </div>
        </div>
    </section>

    {{-- Scripts --}}
    <script>
        // role & perm
        $('.select2').select2({
            placeholder: 'Select an option',
            allowClear: true,
            tag: true
        })

        // body & desc
        tinymce.overrideDefaults({
            menubar: false,
            branding: false,
            height : "120",
            plugins: "lists link image spellchecker fullscreen media table preview contextmenu autoresize",
            toolbar: 'undo redo | link unlink | media image | styleselect removeformat | outdent indent | numlist bullist table | spellchecker preview fullscreen'
        })
    </script>
</body>
</html>
