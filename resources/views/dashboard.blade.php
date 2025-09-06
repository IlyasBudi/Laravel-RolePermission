@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="bg-white p-6 rounded-lg shadow">
  <h1 class="text-2xl font-semibold mb-2">Halo, {{ auth()->user()->name }}</h1>
  <p class="text-gray-600">Selamat datang di dashboard.</p>

  <div class="mt-6 grid grid-cols-1 sm:grid-cols-3 gap-4">
    <a href="{{ route('admin.roles.index') }}" class="block border rounded p-4 hover:bg-gray-50">
      <div class="font-semibold">Roles</div>
      <div class="text-sm text-gray-600">Kelola daftar role & izin role</div>
    </a>
    <a href="{{ route('admin.permissions.index') }}" class="block border rounded p-4 hover:bg-gray-50">
      <div class="font-semibold">Permissions</div>
      <div class="text-sm text-gray-600">Kelola daftar permission</div>
    </a>
    <a href="{{ route('admin.users.index') }}" class="block border rounded p-4 hover:bg-gray-50">
      <div class="font-semibold">Users</div>
      <div class="text-sm text-gray-600">Kelola role & permission user</div>
    </a>
  </div>
</div>
@endsection
