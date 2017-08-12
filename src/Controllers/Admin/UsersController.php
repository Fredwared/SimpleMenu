<?php

namespace ctf0\SimpleMenu\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use ctf0\SimpleMenu\Controllers\BaseController;

class UsersController extends BaseController
{
    /**
     * Display a listing of User.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = cache('sm-users');

        return view("{$this->adminPath}.users.index", compact('users'));
    }

    /**
     * Show the form for creating new User.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles       = Role::get()->pluck('name', 'name');
        $permissions = cache('spatie.permission.cache')->pluck('name', 'name');

        return view("{$this->adminPath}.users.create", compact('roles', 'permissions'));
    }

    /**
     * Store a newly created User in storage.
     *
     * @param \App\Http\Requests\StoreUsersRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'        => 'required',
            'email'       => 'required|email|unique:users,email',
            'password'    => 'required',
            'roles'       => 'required',
            'permissions' => 'required',
        ]);

        $user        = $this->userModel->create($request->except(['roles', 'permissions']));
        $roles       = $request->input('roles') ?: [];
        $permissions = $request->input('permissions') ?: [];

        $user->assignRole($roles);
        $user->givePermissionTo($permissions);

        return redirect()->route($this->crud_prefix . '.users.index');
    }

    /**
     * Show the form for editing User.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user        = cache('sm-users')->find($id);
        $roles       = Role::get()->pluck('name', 'name');
        $permissions = cache('spatie.permission.cache')->pluck('name', 'name');

        return view("{$this->adminPath}.users.edit", compact('user', 'roles', 'permissions'));
    }

    /**
     * Update User in storage.
     *
     * @param \App\Http\Requests\UpdateUsersRequest $request
     * @param int                                   $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $this->validate($request, [
            'name'        => 'required',
            'email'       => 'required|email|unique:users,email,' . $id,
            'roles'       => 'required',
            'permissions' => 'required',
        ]);

        $user        = $this->userModel->find($id);
        $roles       = $request->input('roles') ?: [];
        $permissions = $request->input('permissions') ?: [];

        $user->update($request->except(['roles', 'permissions']));
        $user->syncRoles($roles);
        $user->syncPermissions($permissions);

        return redirect()->route($this->crud_prefix . '.users.index');
    }

    /**
     * Remove User from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        if (auth()->user()->id == $id) {
            abort(403);
        }

        $this->userModel->find($id)->delete();

        if ($request->expectsJson()) {
            return response()->json(['done'=>true]);
        }

        return redirect()->route($this->crud_prefix . '.users.index');
    }
}
