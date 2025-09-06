<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RoleStoreUpdateRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        return response()->json([
            'roles' => Role::with('permissions')->orderBy('name')->get(),
        ]);
    }

    public function store(RoleStoreUpdateRequest $request)
    {
        $role = Role::create([
            'name' => $request->validated()['name'],
            // 'guard_name' => 'web', // default
        ]);

        return response()->json(['message' => 'Role created', 'role' => $role], 201);
    }

    public function update(RoleStoreUpdateRequest $request, Role $role)
    {
        $role->update($request->validated());
        return response()->json(['message' => 'Role updated', 'role' => $role]);
    }

    public function destroy(Role $role)
    {
        // Optional: detach permissions dulu, atau langsung delete (Spatie handle pivot)
        $role->delete();
        return response()->json(['message' => 'Role deleted']);
    }

    public function syncPermissions(Request $request, Role $role)
    {
        $data = $request->validate([
            'permissions' => ['array'],
            'permissions.*' => ['string'],
        ]);

        $role->syncPermissions($data['permissions'] ?? []);
        return response()->json([
            'message' => 'Role permissions synced',
            'role'    => $role->load('permissions'),
        ]);
    }
}
