@extends('layouts.app')
@section('title', 'Edit Permission')

@section('content')
<div class="max-w-lg bg-white p-6 rounded shadow">
  <h1 class="text-xl font-semibold mb-4">Edit Permission</h1>
  <form action="{{ route('admin.permissions.update', $permission) }}" method="POST" class="space-y-4">
    @csrf @method('PUT')
    <div>
      <label class="block text-sm mb-1">Nama Permission</label>
      <input type="text" name="name" value="{{ old('name', $permission->name) }}" class="w-full border rounded px-3 py-2" required>
    </div>
    <div class="flex gap-2">
      <a href="{{ route('admin.permissions.index') }}" class="px-3 py-2 rounded border">Kembali</a>
      <button class="px-3 py-2 rounded bg-gray-900 text-white">Update</button>
    </div>
  </form>
</div>
@endsection
