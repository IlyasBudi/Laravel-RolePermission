@extends('layouts.app')

@section('title', 'Detail User')

@section('content')
<div class="grid gap-6 lg:grid-cols-2">

  {{-- Detail User --}}
  <section class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
    <div class="p-6">
      <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Detail User</h2>

      <div class="mt-4 space-y-2 text-sm text-gray-700 dark:text-gray-200">
        <div><span class="text-gray-500 dark:text-gray-400">Nama:</span> {{ $user->name }}</div>
        <div><span class="text-gray-500 dark:text-gray-400">Email:</span> {{ $user->email }}</div>
        <div><span class="text-gray-500 dark:text-gray-400">Username:</span> {{ $user->username ?? '—' }}</div>
        <div><span class="text-gray-500 dark:text-gray-400">No. HP:</span> {{ $user->phone_number ?? '—' }}</div>
        <div>
          <span class="text-gray-500 dark:text-gray-400">Verifikasi Email:</span>
          @if($user->email_verified_at)
            <span class="px-2 py-0.5 rounded-full bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300 text-xs">Terverifikasi</span>
          @else
            <span class="px-2 py-0.5 rounded-full bg-yellow-100 text-yellow-700 dark:bg-yellow-900/40 dark:text-yellow-300 text-xs">Belum</span>
          @endif
        </div>
      </div>

      <div class="mt-6 flex gap-2">
        @can('users.update')
          <a href="{{ route('admin.users.edit', $user) }}" class="px-4 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white">Edit</a>
        @endcan
        <a href="{{ route('admin.users.index') }}" class="px-4 py-2 rounded-lg border dark:border-gray-600">Kembali</a>
      </div>
    </div>
  </section>

  {{-- Roles & Permissions --}}
  <section class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
    <div class="p-6">
      <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Role & Permissions</h3>

      {{-- Penjelasan singkat direct permission --}}
      <div class="mt-3 rounded-lg border border-amber-300 bg-amber-50 dark:bg-amber-900/20 dark:border-amber-700 p-3">
        <div class="text-sm text-amber-800 dark:text-amber-200">
          <strong>Direct permission</strong> adalah izin yang diberikan <em>langsung</em> ke user (bukan lewat role).
          Cocok untuk pengecualian/akses sementara. Untuk skala besar, tetap disarankan atur izin lewat <strong>role</strong>.
          Sistem mengecek hak akses sebagai <em>gabungan</em> dari izin via role dan direct permission (tidak ada “deny” bawaan).
        </div>
      </div>

      {{-- Roles --}}
      <div class="mt-5">
        <div class="text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">Roles</div>
        <div class="flex flex-wrap gap-2">
          @forelse ($roleNames as $r)
            <span class="px-2 py-1 rounded-lg bg-gray-100 dark:bg-gray-900/40 text-gray-800 dark:text-gray-100 text-xs">{{ $r }}</span>
          @empty
            <span class="text-sm text-gray-500 dark:text-gray-400">—</span>
          @endforelse
        </div>
      </div>

      {{-- Permissions via semua role (agregat) --}}
      <div class="mt-6">
        <div class="text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">Permissions (via Role)</div>
        <div class="flex flex-wrap gap-2 max-h-48 overflow-auto">
          @forelse ($permissionsViaRoles as $p)
            <span class="px-2 py-1 rounded-lg bg-indigo-50 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-200 text-xs">{{ $p }}</span>
          @empty
            <span class="text-sm text-gray-500 dark:text-gray-400">—</span>
          @endforelse
        </div>
      </div>

      {{-- NEW: Direct permissions (langsung ke user) --}}
      <div class="mt-6">
        <div class="text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">Direct Permissions</div>
        <div class="flex flex-wrap gap-2 max-h-48 overflow-auto">
          @forelse ($directPermissions as $dp)
            <span class="px-2 py-1 rounded-lg bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-200 text-xs">{{ $dp }}</span>
          @empty
            <span class="text-sm text-gray-500 dark:text-gray-400">— (user tidak memiliki direct permission)</span>
          @endforelse
        </div>
      </div>

      {{-- (Opsional) Effective permissions: gabungan role + direct --}}
      @isset($effectivePermissions)
      <div class="mt-6">
        <div class="text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">Effective Permissions (gabungan)</div>
        <div class="flex flex-wrap gap-2 max-h-48 overflow-auto">
          @forelse ($effectivePermissions as $ep)
            <span class="px-2 py-1 rounded-lg bg-sky-50 dark:bg-sky-900/30 text-sky-700 dark:text-sky-200 text-xs">{{ $ep }}</span>
          @empty
            <span class="text-sm text-gray-500 dark:text-gray-400">—</span>
          @endforelse
        </div>
      </div>
      @endisset

      {{-- Rincian permission per role --}}
      <div class="mt-6">
        <div class="text-sm font-medium text-gray-700 dark:text-gray-200 mb-3">Rincian Permission per Role</div>
        <div class="space-y-4">
          @forelse ($rolePermissionsMap as $roleName => $perms)
            <div>
              <div class="text-sm font-semibold text-gray-900 dark:text-gray-100 mb-1">{{ $roleName }}</div>
              <div class="flex flex-wrap gap-2">
                @if (count($perms))
                  @foreach ($perms as $perm)
                    <span class="px-2 py-1 rounded-lg bg-rose-50 dark:bg-rose-900/30 text-rose-700 dark:text-rose-200 text-xs">{{ $perm }}</span>
                  @endforeach
                @else
                  <span class="text-sm text-gray-500 dark:text-gray-400">— (role belum punya permission)</span>
                @endif
              </div>
            </div>
          @empty
            <div class="text-sm text-gray-500 dark:text-gray-400">User belum memiliki role.</div>
          @endforelse
        </div>
      </div>

    </div>
  </section>

</div>
@endsection
