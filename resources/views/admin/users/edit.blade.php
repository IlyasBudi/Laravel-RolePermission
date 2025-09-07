@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
@if ($errors->any())
  <div class="mb-4 rounded-lg border border-red-300 bg-red-50 dark:bg-red-900/30 dark:border-red-800 p-3 text-sm text-red-700 dark:text-red-300">
    <ul class="list-disc ml-5">
      @foreach ($errors->all() as $err)
        <li>{{ $err }}</li>
      @endforeach
    </ul>
  </div>
@endif

<div class="grid gap-6 lg:grid-cols-2">
  {{-- Kiri: Edit Profil + Password --}}
  <div class="space-y-6">
    {{-- Edit Profil --}}
    <section class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
      <div class="p-6">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Edit Profil</h2>
        <form action="{{ route('admin.users.update', $user) }}" method="POST" class="mt-5 space-y-4">
          @csrf
          @method('PUT')

          <div>
            <label class="block text-sm mb-1">Nama</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                   class="w-full rounded-lg border dark:border-gray-600 bg-white dark:bg-gray-900/50 px-3 py-2" required>
          </div>

          <div>
            <label class="block text-sm mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                   class="w-full rounded-lg border dark:border-gray-600 bg-white dark:bg-gray-900/50 px-3 py-2" required>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Mengubah email akan mengatur ulang verifikasi.</p>
          </div>

          <div class="grid sm:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm mb-1">Username (opsional)</label>
              <input type="text" name="username" value="{{ old('username', $user->username) }}"
                     class="w-full rounded-lg border dark:border-gray-600 bg-white dark:bg-gray-900/50 px-3 py-2">
            </div>
            <div>
              <label class="block text-sm mb-1">No. HP (opsional)</label>
              <input type="tel" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}"
                     class="w-full rounded-lg border dark:border-gray-600 bg-white dark:bg-gray-900/50 px-3 py-2" maxlength="15">
            </div>
          </div>

          <div class="pt-2">
            <button class="px-4 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white">Simpan Profil</button>
          </div>
        </form>
      </div>
    </section>

    {{-- Ganti Password --}}
    <section class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700" x-data="{ showNew:false, showConf:false }">
      <div class="p-6">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Ganti Password</h2>
        <form action="{{ route('admin.users.password.update', $user) }}" method="POST" class="mt-5 space-y-4">
          @csrf
          @method('PUT')

          <div class="grid sm:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm mb-1">Password Baru</label>
              <div class="relative">
                <input :type="showNew ? 'text' : 'password'" name="password"
                       class="w-full rounded-lg border dark:border-gray-600 bg-white dark:bg-gray-900/50 px-3 py-2 pr-12" required>
                <button type="button" class="absolute inset-y-0 right-0 px-3 text-sm" @click="showNew = !showNew">Tampil</button>
              </div>
            </div>
            <div>
              <label class="block text-sm mb-1">Konfirmasi Password</label>
              <div class="relative">
                <input :type="showConf ? 'text' : 'password'" name="password_confirmation"
                       class="w-full rounded-lg border dark:border-gray-600 bg-white dark:bg-gray-900/50 px-3 py-2 pr-12" required>
                <button type="button" class="absolute inset-y-0 right-0 px-3 text-sm" @click="showConf = !showConf">Tampil</button>
              </div>
            </div>
          </div>

          <div class="pt-2">
            <button class="px-4 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white">Update Password</button>
          </div>
        </form>
      </div>
    </section>
  </div>

  {{-- Kanan: Roles & Direct Permissions --}}
  <div class="space-y-6" x-data="{ checkAllRoles:false, checkAllPerm:false }">
    {{-- Roles --}}
    <section class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
      <div class="p-6">
        <div class="flex items-center justify-between">
          <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Roles</h2>
          <label class="text-xs inline-flex items-center gap-2 text-gray-600 dark:text-gray-300">
            <input type="checkbox" x-model="checkAllRoles"
                   @change="document.querySelectorAll('input[name=\'roles[]\']').forEach(cb => cb.checked = checkAllRoles)"
                   class="rounded"> Select all
          </label>
        </div>

        <form action="{{ route('admin.users.sync-roles', $user) }}" method="POST" class="mt-4">
          @csrf
          <div class="max-h-72 overflow-auto border border-gray-200 dark:border-gray-700 rounded-lg p-3 grid sm:grid-cols-2 gap-2">
            @foreach ($roles as $r)
              <label class="inline-flex items-center gap-2 text-sm text-gray-700 dark:text-gray-200">
                <input type="checkbox" name="roles[]" value="{{ $r->name }}" class="rounded"
                       @checked(in_array($r->name, $userRoles))>
                {{ $r->name }}
              </label>
            @endforeach
          </div>

          <div class="mt-4">
            <button class="px-4 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white">Simpan Roles</button>
          </div>
        </form>
      </div>
    </section>

    {{-- Direct Permissions (langsung ke user) --}}
    <section class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
      <div class="p-6">
        <div class="flex items-center justify-between">
          <div>
            <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Direct Permissions</h2>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
              Izin yang diberikan <em>langsung</em> ke user (bukan lewat role). Cocok untuk pengecualian/akses temporer.
              Untuk skala besar tetap kelola lewat <strong>role</strong>. Cek `can()` akan menggabungkan izin dari role + direct permission.
            </p>
          </div>
          <label class="text-xs inline-flex items-center gap-2 text-gray-600 dark:text-gray-300">
            <input type="checkbox" x-model="checkAllPerm"
                   @change="document.querySelectorAll('input[name=\'permissions[]\']').forEach(cb => cb.checked = checkAllPerm)"
                   class="rounded"> Select all
          </label>
        </div>

        <form action="{{ route('admin.users.sync-permissions', $user) }}" method="POST" class="mt-4">
          @csrf
          <div class="max-h-72 overflow-auto border border-gray-200 dark:border-gray-700 rounded-lg p-3 grid sm:grid-cols-2 gap-2">
            @foreach ($permissions as $p)
              <label class="inline-flex items-center gap-2 text-sm text-gray-700 dark:text-gray-200">
                <input type="checkbox" name="permissions[]" value="{{ $p->name }}" class="rounded"
                       @checked(in_array($p->name, $userPerms))>
                {{ $p->name }}
              </label>
            @endforeach
          </div>

          <div class="mt-4">
            <button class="px-4 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white">Simpan Direct Permissions</button>
          </div>
        </form>
      </div>
    </section>
  </div>
</div>

<div class="mt-6">
  <a href="{{ route('admin.users.index') }}" class="px-4 py-2 rounded-lg border dark:border-gray-600">Kembali</a>
</div>
@endsection
