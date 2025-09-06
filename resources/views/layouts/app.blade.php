<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', config('app.name'))</title>
  <!-- Tailwind CDN (boleh ganti ke Vite) -->
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-900">
  <nav class="bg-white border-b border-gray-200">
    <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between">
      <div class="flex items-center gap-4">
        <a href="{{ route('dashboard') }}" class="font-semibold">Dashboard</a>
        @auth
        <a href="{{ route('admin.roles.index') }}" class="hover:underline">Roles</a>
        <a href="{{ route('admin.permissions.index') }}" class="hover:underline">Permissions</a>
        <a href="{{ route('admin.users.index') }}" class="hover:underline">Users</a>
        @endauth
      </div>
      <div class="flex items-center gap-3">
        @auth
          <span class="text-sm text-gray-600">{{ auth()->user()->name }}</span>
          <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="px-3 py-1.5 rounded bg-gray-900 text-white text-sm">Logout</button>
          </form>
        @else
          <a class="px-3 py-1.5 rounded bg-gray-900 text-white text-sm" href="{{ route('login') }}">Login</a>
        @endauth
      </div>
    </div>
  </nav>

  <main class="max-w-6xl mx-auto px-4 py-6">
    @if (session('success'))
      <div class="mb-4 rounded border border-green-200 bg-green-50 px-4 py-3 text-green-700">
        {{ session('success') }}
      </div>
    @endif

    @if ($errors->any())
      <div class="mb-4 rounded border border-red-200 bg-red-50 px-4 py-3 text-red-700">
        <div class="font-semibold mb-1">Terjadi kesalahan:</div>
        <ul class="list-disc ml-5">
          @foreach ($errors->all() as $err)
            <li>{{ $err }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    @yield('content')
  </main>
</body>
</html>
