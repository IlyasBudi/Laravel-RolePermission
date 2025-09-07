@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="grid gap-6 lg:grid-cols-2">

  {{-- Kartu: Data Profil --}}
  <section class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
    <div class="p-6">
      <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Data Profil</h2>
      <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">Perbarui nama, email, username, dan nomor HP.</p>

      {{-- status verifikasi email --}}
      <div class="mt-4">
        <span class="inline-flex items-center gap-2 text-xs">
          <span class="px-2 py-0.5 rounded-full {{ $user->email_verified_at ? 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300' : 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/40 dark:text-yellow-300' }}">
            {{ $user->email_verified_at ? 'Email terverifikasi' : 'Email belum terverifikasi' }}
          </span>
          @if($user->email_verified_at)
            <span class="text-gray-500 dark:text-gray-400">• diverifikasi {{ $user->email_verified_at->diffForHumans() }}</span>
          @endif
        </span>
      </div>

      <form action="{{ route('admin.profile.update') }}" method="POST" class="mt-6 space-y-4">
        @csrf
        @method('PUT')

        <div>
          <label class="block text-sm mb-1 text-gray-700 dark:text-gray-300">Nama</label>
          <input type="text" name="name" value="{{ old('name', $user->name) }}"
                 class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900/50 px-3 py-2 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                 required>
        </div>

        <div>
          <label class="block text-sm mb-1 text-gray-700 dark:text-gray-300">Email</label>
          <input type="email" name="email" value="{{ old('email', $user->email) }}"
                 class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900/50 px-3 py-2 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                 required>
          <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Mengubah email akan mengatur ulang status verifikasi.</p>
        </div>

        <div>
          <label class="block text-sm mb-1 text-gray-700 dark:text-gray-300">Username (opsional)</label>
          <input type="text" name="username" value="{{ old('username', $user->username) }}"
                 class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900/50 px-3 py-2 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                 maxlength="255">
        </div>

        <div>
          <label class="block text-sm mb-1 text-gray-700 dark:text-gray-300">No. HP (opsional)</label>
          <input type="tel" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}"
                 class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900/50 px-3 py-2 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                 maxlength="15">
        </div>

        <div class="flex items-center gap-2 pt-2">
          <button class="px-4 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white">Simpan Profil</button>
          <a href="{{ route('dashboard') }}" class="px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800">Kembali</a>
        </div>
      </form>
    </div>
  </section>

  {{-- Kartu: Ganti Password --}}
  <section class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
    <div class="p-6" x-data="{ showCur:false, showNew:false, showConf:false }">
      <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Ganti Password</h2>
      <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">Gunakan password yang kuat dan unik.</p>

      <form action="{{ route('admin.profile.password.update') }}" method="POST" class="mt-6 space-y-4">
        @csrf
        @method('PUT')

        <div>
          <label class="block text-sm mb-1 text-gray-700 dark:text-gray-300">Password Saat Ini</label>
          <div class="relative">
            <input :type="showCur ? 'text' : 'password'" name="current_password"
                   class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900/50 px-3 py-2 pr-12 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                   required>
            <button type="button" class="absolute inset-y-0 right-0 px-3 text-sm text-gray-600 dark:text-gray-300"
                    @click="showCur = !showCur">
              Tampil
            </button>
          </div>
        </div>

        <div>
          <label class="block text-sm mb-1 text-gray-700 dark:text-gray-300">Password Baru</label>
          <div class="relative">
            <input :type="showNew ? 'text' : 'password'" name="password"
                   class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900/50 px-3 py-2 pr-12 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                   required>
            <button type="button" class="absolute inset-y-0 right-0 px-3 text-sm text-gray-600 dark:text-gray-300"
                    @click="showNew = !showNew">
              Tampil
            </button>
          </div>
        </div>

        <div>
          <label class="block text-sm mb-1 text-gray-700 dark:text-gray-300">Konfirmasi Password Baru</label>
          <div class="relative">
            <input :type="showConf ? 'text' : 'password'" name="password_confirmation"
                   class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900/50 px-3 py-2 pr-12 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                   required>
            <button type="button" class="absolute inset-y-0 right-0 px-3 text-sm text-gray-600 dark:text-gray-300"
                    @click="showConf = !showConf">
              Tampil
            </button>
          </div>
        </div>

        <button class="px-4 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white">Ganti Password</button>
      </form>
    </div>
  </section>

</div>
@endsection
