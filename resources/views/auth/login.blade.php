@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<div class="text-center mb-6">
    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Sign in to your account</h2>
    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
        Or 
        <a href="{{ route('register') }}" class="font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400">
            create a new account
        </a>
    </p>
</div>

<form method="POST" action="{{ route('login.attempt') }}" class="space-y-6">
    @csrf

    <!-- Email -->
    <div>
        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email address</label>
        <input id="email" name="email" type="email" autocomplete="email" required 
               value="{{ old('email') }}"
               class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white sm:text-sm">
        @error('email')
            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <!-- Password -->
    <div>
        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
        <input id="password" name="password" type="password" autocomplete="current-password" required
               class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white sm:text-sm">
        @error('password')
            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <!-- Remember Me -->
    <div class="flex items-center justify-between">
        <div class="flex items-center">
            <input id="remember" name="remember" type="checkbox" 
                   class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 dark:border-gray-600 rounded dark:bg-gray-700">
            <label for="remember" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">
                Remember me
            </label>
        </div>

        <div class="text-sm">
            <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400">
                Forgot your password?
            </a>
        </div>
    </div>

    <!-- Submit Button -->
    <div>
        <button type="submit" 
                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 transition duration-150 ease-in-out">
            Sign in
        </button>
    </div>
</form>
@endsection