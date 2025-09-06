@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow">
  <h1 class="text-xl font-semibold mb-4">Register</h1>
  <form action="{{ route('register.attempt') }}" method="POST" class="space-y-4">
    @csrf
    <div>
      <label class="block text-sm mb-1">Nama</label>
      <input type="text" name="name" value="{{ old('name') }}" class="w-full border rounded px-3 py-2" required>
    </div>
    <div>
      <label class="block text-sm mb-1">Email</label>
      <input type="email" name="email" value="{{ old('email') }}" class="w-full border rounded px-3 py-2" required>
    </div>
    <div>
      <label class="block text-sm mb-1">Username (opsional)</label>
      <input type="text" name="username" value="{{ old('username') }}" class="w-full border rounded px-3 py-2">
    </div>
    <div>
      <label class="block text-sm mb-1">No. HP (opsional)</label>
      <input type="text" name="phone_number" value="{{ old('phone_number') }}" class="w-full border rounded px-3 py-2">
    </div>
    <div>
      <label class="block text-sm mb-1">Password</label>
      <input type="password" name="password" class="w-full border rounded px-3 py-2" required>
    </div>
    <div>
      <label class="block text-sm mb-1">Konfirmasi Password</label>
      <input type="password" name="password_confirmation" class="w-full border rounded px-3 py-2" required>
    </div>
    <button class="w-full bg-gray-900 text-white py-2 rounded">Register</button>
  </form>
</div>
@endsection
