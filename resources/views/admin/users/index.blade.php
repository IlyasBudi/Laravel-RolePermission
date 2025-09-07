@extends('layouts.app')

@section('title', 'Users')

@section('content')
<div class="flex items-start justify-between gap-4 mb-6">
  <div>
    <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">Users</h1>
    <p class="text-sm text-gray-600 dark:text-gray-300">Kelola data pengguna, role, dan permissions.</p>
  </div>

  @can('users.create')
  <a href="{{ route('admin.users.create') }}"
     class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white shadow-sm">
    + Tambah User
  </a>
  @endcan
</div>

{{-- Search --}}
<form method="GET" action="{{ route('admin.users.index') }}" class="mb-4">
  <div class="flex items-center gap-2">
    <input type="text" name="q" placeholder="Cari nama atau email…"
           value="{{ $q }}"
           class="w-full md:w-80 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900/50 px-3 py-2 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500">
    <button class="px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800">
      Cari
    </button>
    @if($q)
      <a href="{{ route('admin.users.index') }}"
         class="px-3 py-2 text-sm rounded-lg text-gray-600 dark:text-gray-300 hover:underline">Reset</a>
    @endif
  </div>
</form>

{{-- Table --}}
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
  <div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
      <thead class="bg-gray-50 dark:bg-gray-900/40">
        <tr>
          <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">#</th>
          <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Nama</th>
          <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Email</th>
          <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Username</th>
          <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">No. HP</th>
          <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Roles</th>
          <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Aksi</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
        @php
          $start = ($users->currentPage() - 1) * $users->perPage();
        @endphp

        @forelse ($users as $i => $u)
          <tr class="hover:bg-gray-50/60 dark:hover:bg-gray-900/40">
            <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-200">{{ $start + $i + 1 }}</td>
            <td class="px-4 py-3">
              <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $u->name }}</div>
              <div class="mt-0.5">
                @if($u->email_verified_at)
                  <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300 text-[11px]">Verified</span>
                @else
                  <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-yellow-100 text-yellow-700 dark:bg-yellow-900/40 dark:text-yellow-300 text-[11px]">Unverified</span>
                @endif
              </div>
            </td>
            <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-200">{{ $u->email }}</td>
            <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-200">{{ $u->username ?? '—' }}</td>
            <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-200">{{ $u->phone_number ?? '—' }}</td>
            <td class="px-4 py-3">
              <div class="flex flex-wrap gap-1.5">
                @php $roleNames = $u->getRoleNames(); @endphp
                @forelse($roleNames as $r)
                  <span class="px-2 py-0.5 rounded-lg bg-gray-100 dark:bg-gray-900/40 text-gray-800 dark:text-gray-100 text-xs">{{ $r }}</span>
                @empty
                  <span class="text-xs text-gray-500 dark:text-gray-400">—</span>
                @endforelse
              </div>
            </td>
            <td class="px-4 py-3">
              <div class="flex justify-end gap-2">
                @can('users.view')
                <a href="{{ route('admin.users.show', $u) }}"
                   class="px-3 py-1.5 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800 text-sm">
                  Lihat
                </a>
                @endcan

                @can('users.update')
                <a href="{{ route('admin.users.edit', $u) }}"
                   class="px-3 py-1.5 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white text-sm">
                  Edit
                </a>
                @endcan
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="7" class="px-4 py-6 text-center text-sm text-gray-600 dark:text-gray-300">
              Tidak ada data user.
              @can('users.create')
              <a href="{{ route('admin.users.create') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">Tambah user pertama</a>.
              @endcan
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{-- Pagination --}}
  <div class="px-4 py-3 bg-gray-50 dark:bg-gray-900/40 border-t border-gray-200 dark:border-gray-700">
    {{ $users->onEachSide(1)->links() }}
  </div>
</div>
@endsection
