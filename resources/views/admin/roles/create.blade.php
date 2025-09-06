@extends('layouts.app')
@section('title', 'Tambah Role')

@section('content')
<div class="max-w-lg bg-white p-6 rounded shadow">
  <h1 class="text-xl font-semibold mb-4">Tambah Role</h1>
  <form action="{{ route('admin.roles.store') }}" method="POST" class="space-y-4">
    @csrf
    <div>
      <label class="block text-sm mb-1">Nama Role</label>
      <input type="text" name="name" value="{{ old('name') }}" class="w-full border rounded px-3 py-2" required>
    </div>
    <div class="flex gap-2">
      <a href="{{ route('admin.roles.index') }}" class="px-3 py-2 rounded border">Batal</a>
      <button class="px-3 py-2 rounded bg-gray-900 text-white">Simpan</button>
    </div>
  </form>
</div>
@endsection
