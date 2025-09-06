@extends('layouts.app')
@section('title', 'Roles')

@section('content')
<div class="flex items-center justify-between mb-4">
  <h1 class="text-xl font-semibold">Roles</h1>
  <a href="{{ route('admin.roles.create') }}" class="px-3 py-2 bg-gray-900 text-white rounded">+ Role</a>
</div>

<div class="bg-white rounded shadow overflow-hidden">
  <table class="min-w-full">
    <thead class="bg-gray-100 text-sm">
      <tr>
        <th class="text-left px-4 py-2">Nama</th>
        <th class="text-left px-4 py-2">Permissions</th>
        <th class="px-4 py-2">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($roles as $role)
      <tr class="border-t">
        <td class="px-4 py-2">{{ $role->name }}</td>
        <td class="px-4 py-2">
          <div class="text-xs text-gray-600">
            {{ $role->permissions->pluck('name')->join(', ') ?: '-' }}
          </div>
        </td>
        <td class="px-4 py-2 text-right">
          <div class="inline-flex gap-2">
            <a href="{{ route('admin.roles.edit', $role) }}" class="px-3 py-1.5 text-sm rounded border">Edit</a>
            <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" onsubmit="return confirm('Hapus role ini?')">
              @csrf @method('DELETE')
              <button class="px-3 py-1.5 text-sm rounded border border-red-300 text-red-700">Hapus</button>
            </form>
          </div>
        </td>
      </tr>
      @empty
      <tr><td class="px-4 py-3" colspan="3">Belum ada role.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
<div class="mt-3">{{ $roles->links() }}</div>
@endsection
