<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') - KOKORO Admin</title>
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { theme: { extend: {
            colors: { primary: '#FF4D6D', 'primary-dark': '#E8435F', secondary: '#6C63FF', kokoro: { yellow: '#FFD700', pink: '#FF69B4', orange: '#FFA043' } },
            fontFamily: { sans: ['Plus Jakarta Sans', 'system-ui', 'sans-serif'] }
        }}}
    </script>
    <style>
        .admin-link { display:flex; align-items:center; gap:0.75rem; padding:0.75rem 1rem; border-radius:0.75rem; color:#9ca3af; font-size:0.875rem; transition:all 0.2s; }
        .admin-link:hover { background:#374151; color:#fff; }
        .admin-link.active { background:#374151; color:#fff; font-weight:600; }
    </style>
</head>
<body class="font-sans bg-gray-900 text-gray-200 antialiased min-h-screen">
    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        <aside class="hidden lg:flex flex-col w-64 bg-gray-800 border-r border-gray-700 p-4 shrink-0">
            <div class="mb-8 px-4 pt-2">
                <span class="text-2xl font-extrabold text-kokoro-pink tracking-wider">K&#9734;K&#9734;R&#9734;</span>
                <p class="text-xs text-gray-500 mt-1">Admin Panel</p>
            </div>
            <nav class="space-y-1 flex-1">
                <a href="{{ route('admin.dashboard') }}" class="admin-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                    Dashboard
                </a>
                <a href="{{ route('admin.users') }}" class="admin-link {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    Users
                </a>
                <a href="{{ route('admin.matches') }}" class="admin-link {{ request()->routeIs('admin.matches') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    Matches
                </a>
                <a href="{{ route('admin.reports') }}" class="admin-link {{ request()->routeIs('admin.reports') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.834-1.964-.834-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                    Reports
                </a>
                <a href="{{ route('admin.messages') }}" class="admin-link {{ request()->routeIs('admin.messages') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                    Messages
                </a>
            </nav>
            <div class="border-t border-gray-700 pt-4">
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="admin-link w-full text-red-400 hover:bg-red-900/30 hover:text-red-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        {{-- Main --}}
        <main class="flex-1 p-4 lg:p-8 overflow-auto">
            {{-- Mobile admin header --}}
            <div class="lg:hidden flex items-center justify-between mb-4 bg-gray-800 rounded-xl p-3 border border-gray-700">
                <span class="text-lg font-extrabold text-kokoro-pink">K&#9734;K&#9734;R&#9734; <span class="text-xs text-gray-500 font-normal">Admin</span></span>
                <div class="flex gap-2 text-sm">
                    <a href="{{ route('admin.dashboard') }}" class="px-3 py-1.5 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700 text-white' : 'text-gray-400' }}">Dashboard</a>
                    <a href="{{ route('admin.users') }}" class="px-3 py-1.5 rounded-lg {{ request()->routeIs('admin.users') ? 'bg-gray-700 text-white' : 'text-gray-400' }}">Users</a>
                    <a href="{{ route('admin.reports') }}" class="px-3 py-1.5 rounded-lg {{ request()->routeIs('admin.reports') ? 'bg-gray-700 text-white' : 'text-gray-400' }}">Reports</a>
                </div>
            </div>

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-900/30 border border-green-800 text-green-400 rounded-xl">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="mb-4 p-4 bg-red-900/30 border border-red-800 text-red-400 rounded-xl">{{ session('error') }}</div>
            @endif
            @yield('content')
        </main>
    </div>
</body>
</html>
