@extends('layouts.app')
@section('title', 'Users')

@section('content')
<div class="flex items-center justify-between mb-4">
  <h1 class="text-xl font-semibold">Users</h1>
  <form method="GET" class="flex items-center gap-2">
    <input type="text" name="q" value="{{ $q }}" class="border rounded px-3 py-2" placeholder="Cari nama/email...">
    <button class="px-3 py-2 rounded border">Cari</button>
  </form>
</div>

<div class="bg-white rounded shadow overflow-hidden">
  <table class="min-w-full">
    <thead class="bg-gray-100 text-sm">
      <tr>
        <th class="text-left px-4 py-2">Nama</th>
        <th class="text-left px-4 py-2">Email</th>
        <th class="text-left px-4 py-2">Roles</th>
        <th class="px-4 py-2">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($users as $u)
      <tr class="border-t">
        <td class="px-4 py-2">{{ $u->name }}</td>
        <td class="px-4 py-2">{{ $u->email }}</td>
        <td class="px-4 py-2 text-sm text-gray-600">{{ $u->getRoleNames()->join(', ') ?: '-' }}</td>
        <td class="px-4 py-2 text-right">
          <a href="{{ route('admin.users.edit', $u) }}" class="px-3 py-1.5 text-sm rounded border">Edit</a>
        </td>
      </tr>
      @empty
      <tr><td class="px-4 py-3" colspan="4">Belum ada user.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
<div class="mt-3">{{ $users->links() }}</div>
@endsection
