@extends('layouts.app')

@section('title', 'Roles')

@section('content')
<div class="max-w-7xl mx-auto">
  <div class="mb-4 flex items-center justify-between gap-3">
    <div>
      <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">Roles</h1>
      <p class="text-sm text-gray-600 dark:text-gray-300">Kelola role dan permissions.</p>
    </div>

    @can('roles.create')
    <a href="{{ route('admin.roles.create') }}"
       class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white shadow-sm">
      + Tambah Role
    </a>
    @endcan
  </div>

  @if (session('success'))
    <x-alert type="success" :message="session('success')" />
  @endif

  <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
        <thead class="bg-gray-50 dark:bg-gray-900/40">
          <tr>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">#</th>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Role</th>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Permissions</th>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Users</th>
            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
          @php $start = ($roles->currentPage() - 1) * $roles->perPage(); @endphp

          @forelse ($roles as $i => $role)
            <tr class="hover:bg-gray-50/60 dark:hover:bg-gray-900/40">
              <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-200">{{ $start + $i + 1 }}</td>
              <td class="px-4 py-3 text-sm font-medium text-gray-900 dark:text-gray-100">
                {{ $role->name }}
              </td>
              <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-200">
                {{ $role->permissions_count ?? $role->permissions()->count() }}
              </td>
              <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-200">
                {{ $role->users_count ?? \App\Models\User::role($role->name)->count() }}
              </td>
              <td class="px-4 py-3">
                <div class="flex justify-end gap-2">
                  @can('roles.view')
                  <a href="{{ route('admin.roles.show', $role) }}"
                     class="px-3 py-1.5 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-200 text-sm">
                    Lihat
                  </a>
                  @endcan

                  @can('roles.update')
                  <a href="{{ route('admin.roles.edit', $role) }}"
                     class="px-3 py-1.5 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white text-sm">
                    Edit
                  </a>
                  @endcan

                  @can('roles.delete')
                  <form action="{{ route('admin.roles.destroy', $role) }}" method="POST"
                        onsubmit="return confirm('Hapus role {{ $role->name }}?')">
                    @csrf @method('DELETE')
                    <button class="px-3 py-1.5 rounded-lg bg-rose-600 hover:bg-rose-700 text-white text-sm">
                      Hapus
                    </button>
                  </form>
                  @endcan
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="px-4 py-6 text-center text-sm text-gray-600 dark:text-gray-300">
                Belum ada role.
                @can('roles.create')
                <a href="{{ route('admin.roles.create') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">Buat role pertama</a>.
                @endcan
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div class="px-4 py-3 bg-gray-50 dark:bg-gray-900/40 border-t border-gray-200 dark:border-gray-700">
      {{ $roles->onEachSide(1)->links() }}
    </div>
  </div>
</div>
@endsection
