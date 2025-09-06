<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

// Laravel 12: daftarkan middleware via interface HasMiddleware
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware as ControllerMiddleware;

class UserManagementController extends Controller implements HasMiddleware
{
    /**
     * Laravel 12: definisikan middleware di sini (bukan di __construct()).
     */
    public static function middleware(): array
    {
        return [
            new ControllerMiddleware('auth'),
            new ControllerMiddleware('role:superadmin|admin'),
        ];
    }

    public function index(Request $request)
    {
        $q = $request->string('q')->toString();

        $users = User::query()
            ->when($q, fn ($s) => $s->where(function ($w) use ($q) {
                $w->where('name', 'like', "%{$q}%")
                  ->orWhere('email', 'like', "%{$q}%");
            }))
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('admin.users.index', compact('users', 'q'));
    }

    public function edit(User $user)
    {
        $roles       = Role::orderBy('name')->get();
        $permissions = Permission::orderBy('name')->get();

        $userRoles = $user->getRoleNames()->toArray();
        $userPerms = $user->getPermissionNames()->toArray();

        return view('admin.users.edit', compact('user', 'roles', 'permissions', 'userRoles', 'userPerms'));
    }

    // POST: sinkron role (checkbox multiple)
    public function syncRoles(Request $request, User $user)
    {
        $data = $request->validate([
            'roles'   => ['array'],
            'roles.*' => ['string'], // nama role
        ]);

        $user->syncRoles($data['roles'] ?? []);

        // (opsional) sinkron ke kolom users.role jika kamu menyimpan label
        // if (!empty($data['roles'])) {
        //     $user->update(['role' => $data['roles'][0]]);
        // }

        return redirect()
            ->route('admin.users.edit', $user)
            ->with('success', 'Role user berhasil disinkron.');
    }

    // POST: grant/revoke direct permissions (checkbox multiple)
    public function syncPermissions(Request $request, User $user)
    {
        $data = $request->validate([
            'permissions'   => ['array'],
            'permissions.*' => ['string'], // nama permission
        ]);

        $user->syncPermissions($data['permissions'] ?? []);

        return redirect()
            ->route('admin.users.edit', $user)
            ->with('success', 'Permission user berhasil disinkron.');
    }
}
