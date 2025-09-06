@extends('layouts.app')
@section('title', 'Permissions')

@section('content')
<div class="flex items-center justify-between mb-4">
  <h1 class="text-xl font-semibold">Permissions</h1>
  <a href="{{ route('admin.permissions.create') }}" class="px-3 py-2 bg-gray-900 text-white rounded">+ Permission</a>
</div>

<div class="bg-white rounded shadow overflow-hidden">
  <table class="min-w-full">
    <thead class="bg-gray-100 text-sm">
      <tr>
        <th class="text-left px-4 py-2">Nama</th>
        <th class="px-4 py-2">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($permissions as $perm)
      <tr class="border-t">
        <td class="px-4 py-2">{{ $perm->name }}</td>
        <td class="px-4 py-2 text-right">
          <div class="inline-flex gap-2">
            <a href="{{ route('admin.permissions.edit', $perm) }}" class="px-3 py-1.5 text-sm rounded border">Edit</a>
            <form action="{{ route('admin.permissions.destroy', $perm) }}" method="POST" onsubmit="return confirm('Hapus permission ini?')">
              @csrf @method('DELETE')
              <button class="px-3 py-1.5 text-sm rounded border border-red-300 text-red-700">Hapus</button>
            </form>
          </div>
        </td>
      </tr>
      @empty
      <tr><td class="px-4 py-3" colspan="2">Belum ada permission.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
<div class="mt-3">{{ $permissions->links() }}</div>
@endsection
