@extends('layouts.app')

@section('title', 'Tambah User')

@section('content')
<div class="max-w-7xl mx-auto">
  {{-- Header --}}
  <div class="mb-4 flex items-center justify-between gap-3">
    <div>
      <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">Tambah User</h1>
      <p class="text-sm text-gray-600 dark:text-gray-300">Isi data dasar, lalu atur role & (opsional) direct permission.</p>
    </div>
    <a href="{{ route('admin.users.index') }}" class="px-4 py-2 rounded-lg border dark:border-gray-600">Kembali</a>
  </div>

  @if ($errors->any())
    <div class="mb-4 rounded-lg border border-red-300 bg-red-50 dark:bg-red-900/30 dark:border-red-800 p-3 text-sm text-red-700 dark:text-red-300">
      <ul class="list-disc ml-5">
        @foreach ($errors->all() as $err)
          <li>{{ $err }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <div class="grid gap-6 lg:grid-cols-3">
    {{-- KIRI (span 2): FORM DATA USER --}}
    <section class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
      <form id="createUserForm" action="{{ route('admin.users.store') }}" method="POST" class="p-6 space-y-4">
        @csrf

        <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Data Pengguna</h2>

        <div>
          <label class="block text-sm mb-1 text-gray-700 dark:text-gray-300">Nama</label>
          <input type="text" name="name" value="{{ old('name') }}"
                 class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900/50 px-3 py-2"
                 required>
        </div>

        <div>
          <label class="block text-sm mb-1 text-gray-700 dark:text-gray-300">Email</label>
          <input type="email" name="email" value="{{ old('email') }}"
                 class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900/50 px-3 py-2"
                 required>
        </div>

        <div class="grid sm:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm mb-1 text-gray-700 dark:text-gray-300">Username (opsional)</label>
            <input type="text" name="username" value="{{ old('username') }}"
                   class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900/50 px-3 py-2">
          </div>
          <div>
            <label class="block text-sm mb-1 text-gray-700 dark:text-gray-300">No. HP (opsional)</label>
            <input type="tel" name="phone_number" value="{{ old('phone_number') }}"
                   class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900/50 px-3 py-2"
                   maxlength="15">
          </div>
        </div>

        <div class="grid sm:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm mb-1 text-gray-700 dark:text-gray-300">Password</label>
            <input type="password" name="password"
                   class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900/50 px-3 py-2"
                   required>
          </div>
          <div>
            <label class="block text-sm mb-1 text-gray-700 dark:text-gray-300">Konfirmasi Password</label>
            <input type="password" name="password_confirmation"
                   class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900/50 px-3 py-2"
                   required>
          </div>
        </div>

        <div class="flex gap-2 pt-2">
          <button class="px-4 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white">Simpan</button>
          <a href="{{ route('admin.users.index') }}" class="px-4 py-2 rounded-lg border dark:border-gray-600">Batal</a>
        </div>
      </form>
    </section>

    {{-- KANAN: ROLES + DIRECT PERMISSIONS (terikat ke form kiri via attribute "form") --}}
    <div class="lg:col-span-1 space-y-6">
      {{-- ROLES --}}
      <section class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="p-6">
          <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Roles</h2>
          <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">Pilih satu atau lebih role.</p>

          <div class="mt-4 max-h-56 overflow-auto border border-gray-200 dark:border-gray-700 rounded-lg p-3 grid sm:grid-cols-1 gap-2">
            @foreach ($roles as $r)
              <label class="inline-flex items-center gap-2 text-sm text-gray-700 dark:text-gray-200">
                {{-- perhatikan: form="createUserForm" --}}
                <input type="checkbox" name="roles[]" value="{{ $r->name }}" class="rounded" form="createUserForm"
                       @checked(collect(old('roles', []))->contains($r->name))>
                {{ $r->name }}
              </label>
            @endforeach
          </div>
        </div>
      </section>

      {{-- DIRECT PERMISSIONS --}}
      <section class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="p-6">
          <div class="flex items-start justify-between gap-3">
            <div>
              <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Direct Permissions</h2>
              <p class="text-xs text-gray-600 dark:text-gray-300 mt-1">
                Izin yang ditempel <em>langsung</em> ke user (untuk pengecualian/akses sementara).
                `can()` = gabungan izin dari role + direct permission.
              </p>
            </div>
            <span class="text-[11px] px-2 py-0.5 rounded-full bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-200 h-6">
              Opsional
            </span>
          </div>

          <div class="mt-4 max-h-56 overflow-auto border border-gray-200 dark:border-gray-700 rounded-lg p-3 grid sm:grid-cols-1 gap-2">
            @foreach ($permissions as $p)
              <label class="inline-flex items-center gap-2 text-sm text-gray-700 dark:text-gray-200">
                {{-- perhatikan: form="createUserForm" --}}
                <input type="checkbox" name="permissions[]" value="{{ $p->name }}" class="rounded" form="createUserForm"
                       @checked(collect(old('permissions', []))->contains($p->name))>
                {{ $p->name }}
              </label>
            @endforeach
          </div>
        </div>
      </section>
    </div>
  </div>
</div>
@endsection
