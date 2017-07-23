@extends('SimpleMenu::pages.'.config('simpleMenu.framework').'.shared')
@section('title'){{ 'Pages' }}@endsection

@section('sub')
    <h3 class="title">
        @lang('SimpleMenu::messages.pages.title') "{{ count($pages) }}"
        <a href="{{ route('admin.pages.create') }}" class="button is-success">@lang('SimpleMenu::messages.app_add_new')</a>
    </h3>
    
    <table class="table is-bordered">
        <thead>
            <tr>
                <th>@lang('SimpleMenu::messages.pages.fields.title')</th>
                <th>@lang('SimpleMenu::messages.pages.fields.roles')</th>
                <th>@lang('SimpleMenu::messages.pages.fields.permissions')</th>
                <th>@lang('SimpleMenu::messages.ops')</th>
            </tr>
        </thead>
        
        <tbody>
            @if (count($pages) > 0)
                @foreach ($pages as $page)
                    <tr>
                        <td>{{ $page->title }}</td>
                        <td>
                            @foreach ($page->roles()->pluck('name') as $role)
                                <span class="tag is-medium is-info">{{ $role }}</span>
                            @endforeach
                        </td>
                        <td>
                            @foreach ($page->permissions()->pluck('name') as $perm)
                                <span class="tag is-medium is-info">{{ $perm }}</span>
                            @endforeach
                        </td>
                        <td>
                            <a href="{{ route('admin.pages.edit',[$page->id]) }}" class="button is-info is-inline-block">@lang('SimpleMenu::messages.app_edit')</a>
                            <a class="is-inline-block">
                                {!! Form::open(['method' => 'DELETE', 'route' => ['admin.pages.destroy', $page->id]]) !!}
                                    {!! Form::submit(trans('SimpleMenu::messages.app_delete'), ['class' => 'button is-danger']) !!}
                                {!! Form::close() !!}
                            </a>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="9">@lang('SimpleMenu::messages.app_no_entries_in_table')</td>
                </tr>
            @endif
        </tbody>
    </table>
@stop