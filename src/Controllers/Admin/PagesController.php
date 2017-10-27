<?php

namespace ctf0\SimpleMenu\Controllers\Admin;

use Illuminate\Http\Request;
use ctf0\SimpleMenu\Models\Page;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use ctf0\SimpleMenu\Controllers\BaseController;
use ctf0\SimpleMenu\Controllers\Admin\Traits\PageOps;
use ctf0\SimpleMenu\Controllers\Admin\Traits\UserPageOps;

class PagesController extends BaseController
{
    use PageOps, UserPageOps;

    /**
     * Display a listing of Page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages = $this->cache->tags('sm')->get('pages');

        return view("{$this->adminPath}.pages.index", compact('pages'));
    }

    /**
     * Show the form for creating new Page.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles       = Role::get()->pluck('name', 'name');
        $permissions = Permission::get()->pluck('name', 'name');
        $menus       = $this->cache->tags('sm')->get('menus')->pluck('name', 'id');

        return view("{$this->adminPath}.pages.create", compact('roles', 'permissions', 'menus'));
    }

    /**
     * Store a newly created Page in storage.
     *
     * @param \App\Http\Requests\StorePagesRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->sT_uP_Validaiton($request);

        $img         = $this->getImage($request->cover);
        $page        = Page::create(array_merge(['cover'=>$img], $this->cleanEmptyTranslations($request)));
        $roles       = $request->input('roles') ?: [];
        $permissions = $request->input('permissions') ?: [];
        $menus       = $request->input('menus') ?: [];

        $page->assignRole($roles);
        $page->givePermissionTo($permissions);
        $page->assignToMenus($menus);

        return redirect()->route($this->crud_prefix . '.pages.index');
    }

    /**
     * Show the form for editing Page.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $roles       = Role::get()->pluck('name', 'name');
        $permissions = Permission::get()->pluck('name', 'name');
        $page        = $this->cache->tags('sm')->get('pages')->find($id);
        $menus       = $this->cache->tags('sm')->get('menus')->pluck('name', 'id');

        return view("{$this->adminPath}.pages.edit", compact('roles', 'permissions', 'page', 'menus'));
    }

    /**
     * Update Page in storage.
     *
     * @param \App\Http\Requests\UpdatePagesRequest $request
     * @param int                                   $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $this->sT_uP_Validaiton($request, $id);

        $img         = $this->getImage($request->cover);
        $page        = Page::find($id);
        $roles       = $request->input('roles') ?: [];
        $permissions = $request->input('permissions') ?: [];
        $menus       = $request->input('menus') ?: [];

        $page->update(array_merge(['cover'=>$img], $this->cleanEmptyTranslations($request)));
        $page->syncRoles($roles);
        $page->syncPermissions($permissions);
        $page->syncMenus($menus);

        return redirect()->route($this->crud_prefix . '.pages.index');
    }

    /**
     * Remove Page from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $page = Page::find($id);
        $page->delete();

        if ($request->expectsJson()) {
            return response()->json(['done'=>true]);
        }

        return redirect()->route($this->crud_prefix . '.pages.index');
    }
}
