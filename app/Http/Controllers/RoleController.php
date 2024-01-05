<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;

class RoleController extends Controller
{
    public function index()
    {
        try {
            $roles = Role::all();
            return view('roles.index', compact('roles'));
        } catch (QueryException $e) {
            return back()->withErrors('Error while fetching roles: ' . $e->getMessage());
        }
    }

    public function create()
    {
        try {
            $permissions = Permission::all();
            return view('roles.create', compact('permissions'));
        } catch (QueryException $e) {
            return back()->withErrors('Error while fetching permissions: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|unique:roles,name',
                'permissions' => 'required|array',
            ]);

            $role = Role::create(['name' => $request->input('name')]);
            $role->syncPermissions($request->input('permissions'));

            return redirect()->route('roles.index')
                ->with('success', 'Role created successfully');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (QueryException $e) {
            return back()->withErrors('Error while creating role: ' . $e->getMessage());
        }
    }

    public function edit(Role $role)
    {
        try {
            $permissions = Permission::all();
            return view('roles.edit', compact('role', 'permissions'));
        } catch (QueryException $e) {
            return back()->withErrors('Error while fetching permissions: ' . $e->getMessage());
        }
    }

    public function update(Request $request, Role $role)
    {
        try {
            $request->validate([
                'name' => 'required|unique:roles,name,' . $role->id,
                'permissions' => 'required|array',
            ]);

            $role->name = $request->input('name');
            $role->save();
            $role->syncPermissions($request->input('permissions'));

            return redirect()->route('roles.index')
                ->with('success', 'Role updated successfully');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (QueryException $e) {
            return back()->withErrors('Error while updating role: ' . $e->getMessage());
        }
    }

    public function destroy(Role $role)
    {
        try {
            $role->delete();
            return redirect()->route('roles.index')
                ->with('success', 'Role deleted successfully');
        } catch (QueryException $e) {
            return back()->withErrors('Error while deleting role: ' . $e->getMessage());
        }
    }
}
