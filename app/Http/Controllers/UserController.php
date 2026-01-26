<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->canManageRoles()) {
            $users = User::all();
        } else {
            abort(403);
        }
        
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $user = Auth::user();
        
        if (!$user->canManageRoles() && !$user->hasRole('Supervisor')) {
            abort(403);
        }
        
        if ($user->hasRole('Supervisor')) {
            $roles = Role::whereNotIn('name', ['Super Admin', 'Admin'])->get();
        } else {
            $roles = Role::all();
        }
        
        // Debug: Check if roles exist
        if ($roles->isEmpty()) {
            $roles = Role::all(); // Fallback to all roles
        }
        
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        
        if (!$user->canManageRoles() && !$user->hasRole('Supervisor')) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'role_id' => 'required|exists:roles,id',
        ]);

        if ($user->hasRole('Supervisor')) {
            $role = Role::find($request->role_id);
            if (in_array($role->name, ['Super Admin', 'Admin'])) {
                abort(403);
            }
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully');
    }

    public function edit(User $user)
    {
        $currentUser = Auth::user();
        
        if (!$currentUser->canManageRoles() && !$currentUser->hasRole('Supervisor')) {
            abort(403);
        }
        
        if ($currentUser->hasRole('Supervisor')) {
            $roles = Role::whereNotIn('name', ['Super Admin', 'Admin'])->get();
        } else {
            $roles = Role::all();
        }
        
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $currentUser = Auth::user();
        
        if (!$currentUser->canManageRoles() && !$currentUser->hasRole('Supervisor')) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role_id' => 'required|exists:roles,id',
            'password' => 'nullable|min:8',
        ]);

        if ($currentUser->hasRole('Supervisor')) {
            $role = Role::find($request->role_id);
            if (in_array($role->name, ['Super Admin', 'Admin'])) {
                abort(403);
            }
        }

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => $request->role_id,
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $user->update($updateData);

        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }

    public function destroy(User $user)
    {
        $currentUser = Auth::user();
        
        if (!$currentUser->canManageRoles() && !$currentUser->hasRole('Supervisor')) {
            abort(403);
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }

    public function profile()
    {
        return view('admin.users.profile');
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $rules = [
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
        
        // Add password validation if password fields are provided
        if ($request->filled('current_password') || $request->filled('new_password')) {
            $rules['current_password'] = 'required';
            $rules['new_password'] = 'required|min:8|confirmed';
        }
        
        $request->validate($rules);

        $updateData = [];

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            $updateData['profile_picture'] = $request->file('profile_picture')->store('profile-pictures', 'public');
        }
        
        // Handle password change
        if ($request->filled('current_password') && $request->filled('new_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect.']);
            }
            $updateData['password'] = Hash::make($request->new_password);
        }

        if (!empty($updateData)) {
            $user->update($updateData);
        }

        return redirect()->route('profile')->with('success', 'Profile updated successfully!');
    }
}