@extends('layouts.app')

@section('title', 'Edit Role')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Role</h1>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Edit role information and manage permissions</p>
        </div>
        <a href="{{ route('admin.roles.index') }}" 
           class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Roles
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Edit Role Form -->
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Role Information</h3>
            </div>
            
            <form method="POST" action="{{ route('admin.roles.update', $role) }}" class="p-6">
                @csrf
                @method('PUT')
                
                <div class="space-y-6">
                    <!-- Role Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Role Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $role->name) }}" required
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white sm:text-sm">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Role Stats -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Users with this role</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $role->users->count() }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Permissions assigned</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $role->permissions->count() }}</dd>
                            </div>
                        </dl>
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button type="submit" 
                                class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            Update Role
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Permissions Management -->
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Role Permissions</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Assign permissions to this role</p>
            </div>
            
            <form method="POST" action="{{ route('admin.roles.sync-permissions', $role) }}" class="p-6">
                @csrf
                
                <div class="space-y-3 max-h-96 overflow-y-auto">
                    @forelse($permissions as $permission)
                        <div class="flex items-center">
                            <input id="permission_{{ $permission->id }}" name="permissions[]" type="checkbox" value="{{ $permission->name }}"
                                   {{ in_array($permission->name, $rolePermissions) ? 'checked' : '' }}
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
                    <div class="mt-6 space-y-3">
                        <!-- Select All / Deselect All -->
                        <div class="flex space-x-3">
                            <button type="button" onclick="selectAll()" 
                                    class="text-sm text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300">
                                Select All
                            </button>
                            <button type="button" onclick="deselectAll()" 
                                    class="text-sm text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300">
                                Deselect All
                            </button>
                        </div>
                        
                        <button type="submit" 
                                class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 dark:focus:ring-offset-gray-800">
                            Update Permissions
                        </button>
                    </div>
                @endif
            </form>
        </div>
    </div>

    <!-- Delete Role -->
    <div class="bg-red-50 dark:bg-red-900 border border-red-200 dark:border-red-700 rounded-lg p-6">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
            </div>
            <div class="ml-3 flex-1">
                <h3 class="text-sm font-medium text-red-800 dark:text-red-200">Delete Role</h3>
                <div class="mt-2 text-sm text-red-700 dark:text-red-300">
                    <p>Once you delete this role, all users assigned to this role will lose their permissions. This action cannot be undone.</p>
                </div>
                <div class="mt-4">
                    <form method="POST" action="{{ route('admin.roles.destroy', $role) }}" 
                          onsubmit="return confirm('Are you sure you want to delete this role? This action cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:focus:ring-offset-red-900">
                            Delete Role
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function selectAll() {
    const checkboxes = document.querySelectorAll('input[name="permissions[]"]');
    checkboxes.forEach(checkbox => checkbox.checked = true);
}

function deselectAll() {
    const checkboxes = document.querySelectorAll('input[name="permissions[]"]');
    checkboxes.forEach(checkbox => checkbox.checked = false);
}
</script>
@endsection