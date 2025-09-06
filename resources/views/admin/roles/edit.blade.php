@extends('layouts.app')
@section('title', 'Edit Role')

@section('content')
<div class="grid md:grid-cols-2 gap-6">
  <div class="bg-white p-6 rounded shadow">
    <h2 class="font-semibold mb-3">Ubah Nama Role</h2>
    <form action="{{ route('admin.roles.update', $role) }}" method="POST" class="space-y-4">
      @csrf @method('PUT')
      <div>
        <label class="block text-sm mb-1">Nama Role</label>
        <input type="text" name="name" value="{{ old('name', $role->name) }}" class="w-full border rounded px-3 py-2" required>
      </div>
      <div class="flex gap-2">
        <a href="{{ route('admin.roles.index') }}" class="px-3 py-2 rounded border">Kembali</a>
        <button class="px-3 py-2 rounded bg-gray-900 text-white">Update</button>
      </div>
    </form>
  </div>

  <div class="bg-white p-6 rounded shadow">
    <h2 class="font-semibold mb-3">Permissions untuk Role: <span class="font-mono">{{ $role->name }}</span></h2>
    <form action="{{ route('admin.roles.sync-permissions', $role) }}" method="POST">
      @csrf
      <div class="flex items-center gap-3 mb-3">
        <input id="checkAllPerm" type="checkbox" class="rounded">
        <label for="checkAllPerm" class="text-sm">Select all</label>
      </div>
      <div class="grid sm:grid-cols-2 gap-2 max-h-80 overflow-auto border p-3 rounded">
        @foreach ($permissions as $p)
          <label class="inline-flex items-center gap-2">
            <input type="checkbox" name="permissions[]"
                   value="{{ $p->name }}"
                   class="rounded"
                   @checked(in_array($p->name, $rolePermissions))>
            <span class="text-sm">{{ $p->name }}</span>
          </label>
        @endforeach
      </div>
      <div class="mt-4">
        <button class="px-3 py-2 rounded bg-gray-900 text-white">Simpan Permissions</button>
      </div>
    </form>
  </div>
</div>

<script>
  const checkAll = document.getElementById('checkAllPerm');
  if (checkAll) {
    checkAll.addEventListener('change', (e) => {
      document.querySelectorAll('input[name="permissions[]"]').forEach(cb => cb.checked = e.target.checked);
    });
  }
</script>
@endsection
