@extends('layouts.app')
@section('title', 'Tambah Permission')

@section('content')
<div class="max-w-lg bg-white p-6 rounded shadow">
  <h1 class="text-xl font-semibold mb-4">Tambah Permission</h1>
  <form action="{{ route('admin.permissions.store') }}" method="POST" class="space-y-4">
    @csrf
    <div>
      <label class="block text-sm mb-1">Nama Permission</label>
      <input type="text" name="name" value="{{ old('name') }}" class="w-full border rounded px-3 py-2" placeholder="mis: posts.view" required>
    </div>
    <div class="flex gap-2">
      <a href="{{ route('admin.permissions.index') }}" class="px-3 py-2 rounded border">Batal</a>
      <button class="px-3 py-2 rounded bg-gray-900 text-white">Simpan</button>
    </div>
  </form>
</div>
@endsection
