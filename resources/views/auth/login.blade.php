@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow">
  <h1 class="text-xl font-semibold mb-4">Login</h1>
  <form action="{{ route('login.attempt') }}" method="POST" class="space-y-4">
    @csrf
    <div>
      <label class="block text-sm mb-1">Email</label>
      <input type="email" name="email" value="{{ old('email') }}" class="w-full border rounded px-3 py-2" required>
    </div>
    <div>
      <label class="block text-sm mb-1">Password</label>
      <input type="password" name="password" class="w-full border rounded px-3 py-2" required>
    </div>
    <div class="flex items-center justify-between">
      <label class="inline-flex items-center gap-2">
        <input type="checkbox" name="remember" class="rounded">
        <span class="text-sm">Remember me</span>
      </label>
      <a href="{{ route('register') }}" class="text-sm text-blue-600 hover:underline">Buat akun</a>
    </div>
    <button class="w-full bg-gray-900 text-white py-2 rounded">Login</button>
  </form>
</div>
@endsection
