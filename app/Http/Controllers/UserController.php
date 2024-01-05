<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role; // Import Role dari Spatie

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::latest()->get();
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|unique:users',
                'password' => 'required|string|min:8',
                'roles' => 'required|array',
            ]);

            $user = new User([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
            ]);
            $user->save();

            $user->syncRoles($request->input('roles')); // Menambahkan peran kepada pengguna

            return redirect()->route('users.index')->with('success', 'User created successfully');
        } catch (\Exception $e) {
            // Tangani pengecualian di sini (misalnya, log atau tampilkan pesan kesalahan)
            return redirect()->route('users.index')->with('error', 'Error: ' . $e->getMessage());
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::with('roles')->findOrFail($id);
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::with('roles')->findOrFail($id);
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $user = User::findOrFail($id);

            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|unique:users,email,' . $user->id,
                'password' => 'nullable|string|min:8',
                'roles' => 'required|array',
            ]);

            $user->name = $request->input('name');
            $user->email = $request->input('email');

            if ($request->has('password')) {
                $user->password = Hash::make($request->input('password'));
            }

            $user->save();

            $user->syncRoles($request->input('roles')); // Mengelola peran pengguna

            return redirect()->route('users.index')->with('success', 'User updated successfully');
        } catch (\Exception $e) {
            // Tangani pengecualian di sini (misalnya, log atau tampilkan pesan kesalahan)
            return redirect()->route('users.index')->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }
}
