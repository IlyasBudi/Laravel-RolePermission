@extends('layouts.app')

@section('title', 'Create Permission')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Create Permission</h1>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Create a new permission for your application</p>
        </div>
        <a href="{{ route('admin.permissions.index') }}" 
           class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Permissions
        </a>
    </div>

    <!-- Create Permission Form -->
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Permission Information</h3>
        </div>
        
        <form method="POST" action="{{ route('admin.permissions.store') }}" class="p-6">
            @csrf
            
            <div class="space-y-6">
                <!-- Permission Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Permission Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white sm:text-sm"
                           placeholder="Enter permission name (e.g., users.create, posts.edit)">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        Use descriptive names with dots for organization (e.g., users.create, users.edit, users.delete)
                    </p>
                </div>

                <!-- Permission Examples -->
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                    <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-3">Common Permission Examples:</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-sm text-gray-600 dark:text-gray-400">
                        <div>
                            <strong>Users:</strong>
                            <ul class="ml-2 space-y-1">
                                <li>• users.index</li>
                                <li>• users.create</li>
                                <li>• users.edit</li>
                                <li>• users.delete</li>
                            </ul>
                        </div>
                        <div>
                            <strong>Roles:</strong>
                            <ul class="ml-2 space-y-1">
                                <li>• roles.index</li>
                                <li>• roles.create</li>
                                <li>• roles.edit</li>
                                <li>• roles.delete</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('admin.permissions.index') }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                        Create Permission
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection