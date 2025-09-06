<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AssignRoleRequest;
use App\Http\Requests\Admin\SyncPermissionsRequest;
use App\Models\User;

class UserRoleController extends Controller
{
    public function getUserRoles(User $user)
    {
        return response()->json([
            'user'  => $user->only(['id', 'name', 'email', 'role']),
            'roles' => $user->getRoleNames(),
            'perms' => $user->getPermissionNames(),
        ]);
    }

    public function syncRoles(AssignRoleRequest $request, User $user)
    {
        $roles = $request->validated()['roles'] ?? [];
        $user->syncRoles($roles);

        // (Opsional) sinkronkan kolom users.role ke primary role pertama:
        if (!empty($roles)) {
            $user->update(['role' => $roles[0]]);
        }

        return response()->json([
            'message' => 'User roles synced',
            'roles'   => $user->getRoleNames(),
        ]);
    }

    public function givePermissions(SyncPermissionsRequest $request, User $user)
    {
        $perms = $request->validated()['permissions'] ?? [];
        $user->givePermissionTo($perms);
        return response()->json([
            'message' => 'Permissions granted to user',
            'perms'   => $user->getPermissionNames(),
        ]);
    }

    public function revokePermissions(SyncPermissionsRequest $request, User $user)
    {
        $perms = $request->validated()['permissions'] ?? [];
        $user->revokePermissionTo($perms);
        return response()->json([
            'message' => 'Permissions revoked from user',
            'perms'   => $user->getPermissionNames(),
        ]);
    }
}
