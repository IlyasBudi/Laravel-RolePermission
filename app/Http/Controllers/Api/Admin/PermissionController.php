<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PermissionStoreUpdateRequest;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        return response()->json([
            'permissions' => Permission::orderBy('name')->get(),
        ]);
    }

    public function store(PermissionStoreUpdateRequest $request)
    {
        $perm = Permission::create([
            'name' => $request->validated()['name'],
            // 'guard_name' => 'web',
        ]);

        return response()->json(['message' => 'Permission created', 'permission' => $perm], 201);
    }

    public function update(PermissionStoreUpdateRequest $request, Permission $permission)
    {
        $permission->update($request->validated());
        return response()->json(['message' => 'Permission updated', 'permission' => $permission]);
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
        return response()->json(['message' => 'Permission deleted']);
    }
}
