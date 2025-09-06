<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

// ✅ L12: daftarkan middleware via interface HasMiddleware
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware as ControllerMiddleware;

class RoleController extends Controller implements HasMiddleware
{
    /**
     * Laravel 12: definisikan middleware di sini.
     */
    public static function middleware(): array
    {
        return [
            new ControllerMiddleware('auth'),
            new ControllerMiddleware('role:superadmin|admin'),
        ];
    }

    public function index()
    {
        $roles = Role::with('permissions')->orderBy('name')->paginate(15);
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        return view('admin.roles.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:roles,name'],
        ]);

        $role = Role::create([
            'name' => $data['name'],
            // 'guard_name' => 'web', // (opsional) default guard
        ]);

        return redirect()
            ->route('admin.roles.index')
            ->with('success', 'Role berhasil dibuat.');
    }

    public function edit(Role $role)
    {
        $permissions = Permission::orderBy('name')->get();
        $rolePermissions = $role->permissions->pluck('name')->toArray();

        return view('admin.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(Request $request, Role $role)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:roles,name,'.$role->id],
        ]);

        $role->update(['name' => $data['name']]);

        return redirect()
            ->route('admin.roles.index')
            ->with('success', 'Role berhasil diupdate.');
    }

    public function destroy(Role $role)
    {
        $role->delete();

        return redirect()
            ->route('admin.roles.index')
            ->with('success', 'Role berhasil dihapus.');
    }

    // POST: sinkronisasi permission ke role
    public function syncPermissions(Request $request, Role $role)
    {
        $data = $request->validate([
            'permissions'   => ['array'],
            'permissions.*' => ['string'], // kirim array nama permission
        ]);

        $role->syncPermissions($data['permissions'] ?? []);

        return redirect()
            ->route('admin.roles.edit', $role)
            ->with('success', 'Permission role berhasil disinkron.');
    }
}
