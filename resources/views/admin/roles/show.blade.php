@extends('layouts.app') {{-- ganti ke 'layout.app' jika proyekmu pakai itu --}}

@section('title', 'Detail Role')

@section('content')
<div class="max-w-7xl mx-auto">
  {{-- Header --}}
  <div class="mb-4 flex items-center justify-between gap-3">
    <div>
      <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">Role: {{ $role->name }}</h1>
      <p class="text-sm text-gray-600 dark:text-gray-300">
        Guard: <span class="font-mono">{{ $role->guard_name ?? 'web' }}</span>
      </p>
    </div>
    <div class="flex gap-2">
      @can('roles.update')
      <a href="{{ route('admin.roles.edit', $role) }}" class="px-4 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white">Edit</a>
      @endcan
      <a href="{{ route('admin.roles.index') }}" class="px-4 py-2 rounded-lg border dark:border-gray-600">Kembali</a>
    </div>
  </div>

  <div class="grid grid-cols-1 xl:grid-cols-12 gap-6">
    {{-- KIRI: Ringkasan + Sinkron Permission --}}
    <section class="xl:col-span-5 space-y-6">
      {{-- Ringkasan --}}
      <div class="bg-white dark:bg-gray-800 rounded-xl shadow border border-gray-200 dark:border-gray-700 p-6">
        <div class="grid grid-cols-2 gap-4 text-sm">
          <div>
            <div class="text-gray-500 dark:text-gray-400">Total Permissions</div>
            <div class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $assignedPermissions->count() }}</div>
          </div>
          <div>
            <div class="text-gray-500 dark:text-gray-400">Total Users</div>
            <div class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $users->total() }}</div>
          </div>
        </div>

        @if($assignedPermissions->isNotEmpty())
          <div class="mt-6">
            <div class="text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">Permissions yang melekat</div>
            <div class="flex flex-wrap gap-2 max-h-40 overflow-auto">
              @foreach ($assignedPermissions as $p)
                <span class="px-2 py-1 rounded-lg bg-indigo-50 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-200 text-xs">{{ $p->name }}</span>
              @endforeach
            </div>
          </div>
        @else
          <p class="mt-6 text-sm text-gray-500 dark:text-gray-400">Role ini belum memiliki permission.</p>
        @endif
      </div>

      {{-- Sinkron Permission ke Role --}}
      @can('roles.sync-permissions')
      <div x-data="{ all:false, q:'' }" class="bg-white dark:bg-gray-800 rounded-xl shadow border border-gray-200 dark:border-gray-700 p-6">
        <div class="flex items-center justify-between gap-3">
          <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Kelola Permissions</h2>
          <div class="flex items-center gap-3">
            <input type="text" x-model="q" placeholder="Cari permission…" class="px-3 py-1.5 rounded-lg border dark:border-gray-600 text-sm">
            <label class="text-xs inline-flex items-center gap-2">
              <input type="checkbox" x-model="all"
                     @change="document.querySelectorAll('input[name=\'permissions[]\']').forEach(cb => cb.checked = all)"
                     class="rounded"> Select all
            </label>
          </div>
        </div>

        <form action="{{ route('admin.roles.sync-permissions', $role) }}" method="POST" class="mt-4">
          @csrf
          <div class="grid gap-2 max-h-80 overflow-auto border border-gray-200 dark:border-gray-700 rounded-lg p-3">
            @foreach ($allPermissions as $perm)
              <label class="inline-flex items-center gap-2 text-sm text-gray-700 dark:text-gray-200"
                     x-show="'{{ strtolower($perm->name) }}'.includes(q.toLowerCase())" x-cloak>
                <input type="checkbox" name="permissions[]" value="{{ $perm->name }}" class="rounded"
                       @checked(in_array($perm->name, $assignedNames))>
                {{ $perm->name }}
              </label>
            @endforeach
          </div>

          <div class="mt-4 flex justify-end">
            <button class="px-4 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white">Simpan Permissions</button>
          </div>
        </form>

        <p class="mt-3 text-xs text-gray-500 dark:text-gray-400">
          Perubahan ini akan berdampak ke semua user yang memiliki role <strong>{{ $role->name }}</strong>.
        </p>
      </div>
      @endcan
    </section>

    {{-- KANAN: Daftar User pemilik role --}}
    <section class="xl:col-span-7 bg-white dark:bg-gray-800 rounded-xl shadow border border-gray-200 dark:border-gray-700 p-6">
      <div class="flex items-center justify-between gap-3">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Users dengan role ini</h2>
        <form method="GET" action="{{ route('admin.roles.show', $role) }}" class="flex items-center gap-2">
          <input type="text" name="q" value="{{ $q }}" placeholder="Cari nama/email…"
                 class="px-3 py-1.5 rounded-lg border dark:border-gray-600 text-sm">
          <button class="px-3 py-1.5 rounded-lg border dark:border-gray-600 text-sm">Cari</button>
          @if($q)
            <a href="{{ route('admin.roles.show', $role) }}" class="text-sm text-gray-600 dark:text-gray-300 hover:underline">Reset</a>
          @endif
        </form>
      </div>

      <div class="mt-4 overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
          <thead class="bg-gray-50 dark:bg-gray-900/40">
            <tr>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Nama</th>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Email</th>
              <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
            @forelse ($users as $u)
              <tr class="hover:bg-gray-50/60 dark:hover:bg-gray-900/40">
                <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100">{{ $u->name }}</td>
                <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-200">{{ $u->email }}</td>
                <td class="px-4 py-3">
                  <div class="flex justify-end gap-2">
                    @can('users.view')
                    <a href="{{ route('admin.users.show', $u) }}"
                       class="px-3 py-1.5 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-200 text-sm">
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
                <td colspan="3" class="px-4 py-6 text-center text-sm text-gray-600 dark:text-gray-300">Belum ada user dengan role ini.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div class="mt-4">
        {{ $users->onEachSide(1)->links() }}
      </div>
    </section>
  </div>
</div>
@endsection
