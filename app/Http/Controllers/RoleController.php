<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    public function index()
    {
        if (!Auth::user()->canManageRoles()) {
            abort(403);
        }
        
        $roles = Role::all();
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        if (!Auth::user()->canManageRoles()) {
            abort(403);
        }
        
        return view('admin.roles.create');
    }

    public function store(Request $request)
    {
        if (!Auth::user()->canManageRoles()) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255|unique:roles',
        ]);

        Role::create($request->only('name'));

        return redirect()->route('roles.index')->with('success', 'Role created successfully');
    }

    public function edit(Role $role)
    {
        if (!Auth::user()->canManageRoles()) {
            abort(403);
        }
        
        return view('admin.roles.edit', compact('role'));
    }

    public function update(Request $request, Role $role)
    {
        if (!Auth::user()->canManageRoles()) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
        ]);

        $role->update($request->only('name'));

        return redirect()->route('roles.index')->with('success', 'Role updated successfully');
    }

    public function destroy(Role $role)
    {
        if (!Auth::user()->canManageRoles()) {
            abort(403);
        }

        if ($role->users()->count() > 0) {
            return back()->withErrors(['error' => 'Cannot delete role with assigned users']);
        }

        $role->delete();

        return redirect()->route('roles.index')->with('success', 'Role deleted successfully');
    }
}