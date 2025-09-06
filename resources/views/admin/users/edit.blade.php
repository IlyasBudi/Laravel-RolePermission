@extends('layouts.app')
@section('title', 'Edit User')

@section('content')
<div class="bg-white p-6 rounded shadow">
  <h1 class="text-xl font-semibold mb-1">{{ $user->name }}</h1>
  <p class="text-sm text-gray-600 mb-6">{{ $user->email }}</p>

  <div class="grid md:grid-cols-2 gap-6">
    {{-- Sync Roles --}}
    <div>
      <h2 class="font-semibold mb-3">Roles</h2>
      <form action="{{ route('admin.users.sync-roles', $user) }}" method="POST">
        @csrf
        <div class="flex items-center gap-3 mb-3">
          <input id="checkAllRoles" type="checkbox" class="rounded">
          <label for="checkAllRoles" class="text-sm">Select all</label>
        </div>
        <div class="grid sm:grid-cols-2 gap-2 max-h-80 overflow-auto border p-3 rounded">
          @foreach ($roles as $r)
            <label class="inline-flex items-center gap-2">
              <input type="checkbox" name="roles[]" value="{{ $r->name }}" class="rounded"
                     @checked(in_array($r->name, $userRoles))>
              <span class="text-sm">{{ $r->name }}</span>
            </label>
          @endforeach
        </div>
        <div class="mt-4">
          <button class="px-3 py-2 rounded bg-gray-900 text-white">Simpan Roles</button>
        </div>
      </form>
    </div>

    {{-- Sync Direct Permissions --}}
    <div>
      <h2 class="font-semibold mb-3">Permissions (langsung ke user)</h2>
      <form action="{{ route('admin.users.sync-permissions', $user) }}" method="POST">
        @csrf
        <div class="flex items-center gap-3 mb-3">
          <input id="checkAllUserPerm" type="checkbox" class="rounded">
          <label for="checkAllUserPerm" class="text-sm">Select all</label>
        </div>
        <div class="grid sm:grid-cols-2 gap-2 max-h-80 overflow-auto border p-3 rounded">
          @foreach ($permissions as $p)
            <label class="inline-flex items-center gap-2">
              <input type="checkbox" name="permissions[]" value="{{ $p->name }}" class="rounded"
                     @checked(in_array($p->name, $userPerms))>
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

  <div class="mt-6">
    <a href="{{ route('admin.users.index') }}" class="px-3 py-2 rounded border">Kembali</a>
  </div>
</div>

<script>
  const checkAllRoles = document.getElementById('checkAllRoles');
  const checkAllUserPerm = document.getElementById('checkAllUserPerm');

  if (checkAllRoles) {
    checkAllRoles.addEventListener('change', (e) => {
      document.querySelectorAll('input[name="roles[]"]').forEach(cb => cb.checked = e.target.checked);
    });
  }
  if (checkAllUserPerm) {
    checkAllUserPerm.addEventListener('change', (e) => {
      document.querySelectorAll('input[name="permissions[]"]').forEach(cb => cb.checked = e.target.checked);
    });
  }
</script>
@endsection
