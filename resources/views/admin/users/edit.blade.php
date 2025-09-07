@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Edit User</h1>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Manage user roles and permissions</p>
        </div>
        <a href="{{ route('admin.users.index') }}" 
           class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Users
        </a>
    </div>

    <!-- User Info Card -->
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="flex-shrink-0 h-12 w-12">
                    <div class="h-12 w-12 rounded-full bg-indigo-500 flex items-center justify-center">
                        <span class="text-white font-medium text-lg">{{ substr($user->name, 0, 1) }}</span>
                    </div>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ $user->name }}</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $user->email }}</p>
                    @if($user->username)
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $user->username }}</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="px-6 py-4">
            <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Phone Number</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $user->phone_number ?: 'Not provided' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Joined</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $user->created_at->format('M d, Y') }}</dd>
                </div>
            </dl>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Roles Management -->
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">User Roles</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Assign roles to this user</p>
            </div>
            
            <form method="POST" action="{{ route('admin.users.sync-roles', $user) }}" class="p-6">
                @csrf
                
                <div class="space-y-3">
                    @forelse($roles as $role)
                        <div class="flex items-center">
                            <input id="role_{{ $role->id }}" name="roles[]" type="checkbox" value="{{ $role->name }}"
                                   {{ in_array($role->name, $userRoles) ? 'checked' : '' }}
                                   class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 dark:border-gray-600 rounded dark:bg-gray-700">
                            <label for="role_{{ $role->id }}" class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ $role->name }}
                            </label>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500 dark:text-gray-400">No roles available.</p>
                    @endforelse
                </div>

                @if($roles->count() > 0)
                    <div class="mt-6">
                        <button type="submit" 
                                class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            Update Roles
                        </button>
                    </div>
                @endif
            </form>
        </div>

        <!-- Permissions Management -->
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Direct Permissions</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Grant specific permissions to this user</p>
            </div>
            
            <form method="POST" action="{{ route('admin.users.sync-permissions', $user) }}" class="p-6">
                @csrf
                
                <div class="space-y-3 max-h-96 overflow-y-auto">
                    @forelse($permissions as $permission)
                        <div class="flex items-center">
                            <input id="permission_{{ $permission->id }}" name="permissions[]" type="checkbox" value="{{ $permission->name }}"
                                   {{ in_array($permission->name, $userPerms) ? 'checked' : '' }}
                                   class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 dark:border-gray-600 rounded dark:bg-gray-700">
                            <label for="permission_{{ $permission->id }}" class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ $permission->name }}
                            </label>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500 dark:text-gray-400">No permissions available.</p>
                    @endforelse
                </div>

                @if($permissions->count() > 0)
                    <div class="mt-6">
                        <button type="submit" 
                                class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 dark:focus:ring-offset-gray-800">
                            Update Permissions
                        </button>
                    </div>
                @endif
            </form>
        </div>
    </div>

    <!-- Current Permissions Summary -->
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Current Permissions Summary</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">All permissions this user has (from roles and direct assignments)</p>
        </div>
        <div class="p-6">
            <div class="flex flex-wrap gap-2">
                @php
                    $allPermissions = $user->getAllPermissions();
                @endphp
                @forelse($allPermissions as $permission)
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">
                        {{ $permission->name }}
                    </span>
                @empty
                    <p class="text-sm text-gray-500 dark:text-gray-400">This user has no permissions.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection