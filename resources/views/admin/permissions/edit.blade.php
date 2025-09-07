@extends('layouts.app')

@section('title', 'Edit Permission')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Permission</h1>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Edit permission information</p>
        </div>
        <a href="{{ route('admin.permissions.index') }}" 
           class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Permissions
        </a>
    </div>

    <!-- Edit Permission Form -->
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Permission Information</h3>
        </div>
        
        <form method="POST" action="{{ route('admin.permissions.update', $permission) }}" class="p-6">
            @csrf
            @method('PUT')
            
            <div class="space-y-6">
                <!-- Permission Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Permission Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $permission->name) }}" required
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white sm:text-sm">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Permission Stats -->
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                    <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-3">Permission Usage:</h4>
                    <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Roles using this permission</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $permission->roles->count() }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Users with direct permission</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $permission->users->count() }}</dd>
                        </div>
                    </dl>
                    
                    @if($permission->roles->count() > 0)
                        <div class="mt-4">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Used by roles:</dt>
                            <div class="flex flex-wrap gap-1">
                                @foreach($permission->roles as $role)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">
                                        {{ $role->name }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('admin.permissions.index') }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                        Update Permission
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Delete Permission -->
    <div class="bg-red-50 dark:bg-red-900 border border-red-200 dark:border-red-700 rounded-lg p-6">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
            </div>
            <div class="ml-3 flex-1">
                <h3 class="text-sm font-medium text-red-800 dark:text-red-200">Delete Permission</h3>
                <div class="mt-2 text-sm text-red-700 dark:text-red-300">
                    <p>Once you delete this permission, all roles and users with this permission will lose access. This action cannot be undone.</p>
                </div>
                <div class="mt-4">
                    <form method="POST" action="{{ route('admin.permissions.destroy', $permission) }}" 
                          onsubmit="return confirm('Are you sure you want to delete this permission? This action cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:focus:ring-offset-red-900">
                            Delete Permission
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection