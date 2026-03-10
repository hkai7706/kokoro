<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'KOKORO - Find Your Match')</title>
    <meta name="description" content="@yield('description', 'KOKORO - Japan\'s modern partner matching platform.')">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:300,400,500,600,700,800" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#FF4D6D',
                        'primary-dark': '#E8435F',
                        secondary: '#6C63FF',
                        'secondary-dark': '#5A52E0',
                        kokoro: { yellow: '#FFD700', pink: '#FF69B4', orange: '#FFA043', 'light-pink': '#FFE4F0', 'light-yellow': '#FFF8DC' }
                    },
                    fontFamily: { sans: ['Plus Jakarta Sans', 'system-ui', 'sans-serif'] }
                }
            }
        }
    </script>
    <script>
        // Dark mode initialization - runs before render to avoid flash
        (function() {
            const dm = localStorage.getItem('kokoro-dark-mode');
            if (dm === 'true') {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>
    <style>
        .sidebar-link { display:flex; align-items:center; gap:0.75rem; padding:0.75rem 1rem; border-radius:0.75rem; color:#6b7280; font-weight:500; font-size:0.875rem; transition:all 0.2s; }
        .sidebar-link:hover { background:#FFF8DC; color:#92400e; }
        .sidebar-link.active { background:#FFD700; color:#92400e; font-weight:700; box-shadow:0 1px 3px rgba(0,0,0,0.08); }
        .dark .sidebar-link { color:#9ca3af; }
        .dark .sidebar-link:hover { background:#374151; color:#f9fafb; }
        .dark .sidebar-link.active { background:#4b5563; color:#fbbf24; }
        .card-hover { transition:all 0.3s ease; }
        .card-hover:hover { transform:translateY(-4px); box-shadow:0 12px 40px rgba(0,0,0,0.08); }
        .btn-primary { background:#FF4D6D; color:white; font-weight:600; padding:0.625rem 1.5rem; border-radius:9999px; transition:all 0.2s; box-shadow:0 4px 6px -1px rgba(255,77,109,0.25); }
        .btn-primary:hover { background:#E8435F; box-shadow:0 6px 12px -2px rgba(255,77,109,0.35); }
        .btn-secondary { background:#6C63FF; color:white; font-weight:600; padding:0.625rem 1.5rem; border-radius:9999px; transition:all 0.2s; }
        .btn-secondary:hover { background:#5A52E0; }
        .btn-pink { background:#FFE4F0; color:#db2777; font-weight:600; padding:0.5rem 1.25rem; border-radius:9999px; transition:all 0.2s; }
        .btn-pink:hover { background:#fcd5e7; }
        .gradient-text { background:linear-gradient(135deg,#FF4D6D,#6C63FF); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; }
        .line-clamp-2 { display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }
        ::-webkit-scrollbar { width:6px; }
        ::-webkit-scrollbar-track { background:transparent; }
        ::-webkit-scrollbar-thumb { background:#e5e7eb; border-radius:3px; }
        ::-webkit-scrollbar-thumb:hover { background:#d1d5db; }
        @keyframes fadeInUp { from{opacity:0;transform:translateY(20px)} to{opacity:1;transform:translateY(0)} }
        .animate-fade-in-up { animation:fadeInUp 0.5s ease-out; }
        .mobile-nav-link { display:flex; flex-direction:column; align-items:center; gap:2px; font-size:0.65rem; padding:0.4rem 0.5rem; color:#9ca3af; transition:color 0.2s; }
        .mobile-nav-link.active { color:#FF4D6D; }
        .mobile-nav-link:hover { color:#FF4D6D; }
        /* Dark mode transitions */
        .dark-transition { transition: background-color 0.3s, color 0.3s, border-color 0.3s; }
    </style>
    @yield('head')
</head>
<body class="font-sans bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200 antialiased min-h-screen dark-transition">

    {{-- Header --}}
    <header class="bg-kokoro-yellow dark:bg-gray-800 sticky top-0 z-50 shadow-sm dark-transition">
        <div class="max-w-screen-2xl mx-auto px-4 flex items-center justify-between h-14">
            <div class="flex items-center gap-3">
                <button onclick="document.getElementById('mobile-sidebar').classList.toggle('hidden')"
                        class="lg:hidden text-yellow-800 dark:text-gray-300 hover:text-yellow-900 dark:hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <a href="{{ route('home') }}" class="text-2xl sm:text-3xl font-extrabold tracking-wider" style="color:#FF69B4; text-shadow:1px 1px 0px rgba(255,255,255,0.4);">
                    K&#9734;K&#9734;R&#9734;
                </a>
            </div>
            <div class="flex items-center gap-2 sm:gap-3">
                @auth
                @php $unreadCount = auth()->user()->unreadMessagesCount(); @endphp
                <a href="{{ route('messages.inbox') }}" class="relative text-yellow-800 dark:text-gray-300 hover:text-yellow-900 dark:hover:text-white transition p-1">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                    @if($unreadCount > 0)
                        <span class="absolute -top-1 -right-1 bg-primary text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center">{{ $unreadCount > 9 ? '9+' : $unreadCount }}</span>
                    @endif
                </a>
                {{-- Dark Mode Toggle --}}
                <button onclick="toggleDarkMode()" class="text-yellow-800 dark:text-gray-300 hover:text-yellow-900 dark:hover:text-white transition p-1" title="Toggle Dark Mode">
                    <svg id="dark-icon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    <svg id="light-icon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                </button>
                <div class="relative">
                    <button onclick="this.nextElementSibling.classList.toggle('hidden')" class="flex items-center gap-2 bg-yellow-400/50 dark:bg-gray-700 hover:bg-yellow-400/70 dark:hover:bg-gray-600 rounded-full pl-1 pr-3 py-1 transition cursor-pointer">
                        <div class="w-8 h-8 rounded-full bg-white/80 dark:bg-gray-600 overflow-hidden border-2 border-white dark:border-gray-500 flex items-center justify-center">
                            @if(auth()->user()->profile && auth()->user()->profile->profile_photo)
                                <img src="{{ asset('storage/' . auth()->user()->profile->profile_photo) }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-sm font-bold text-primary">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                            @endif
                        </div>
                        <span class="text-sm font-semibold text-yellow-900 dark:text-gray-200 hidden sm:block">{{ auth()->user()->name }}</span>
                    </button>
                    <div class="hidden absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-xl shadow-xl border border-gray-100 dark:border-gray-700 py-2 z-50">
                        <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">My Profile</a>
                        <a href="{{ route('messages.inbox') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">Messages
                            @if($unreadCount > 0)<span class="ml-1 bg-primary text-white text-xs px-1.5 py-0.5 rounded-full">{{ $unreadCount }}</span>@endif
                        </a>
                        <hr class="my-1 border-gray-100 dark:border-gray-700">
                        <form method="POST" action="{{ route('logout') }}">@csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20">Logout</button>
                        </form>
                    </div>
                </div>
                @endauth
                {{-- ENG/JP Toggle --}}
                <button onclick="toggleLanguage()" class="hidden sm:inline-flex items-center bg-kokoro-pink dark:bg-purple-700 text-white text-xs font-bold px-3 py-1.5 rounded-lg cursor-pointer hover:bg-pink-500 dark:hover:bg-purple-600 transition" id="lang-toggle">
                    <span id="lang-label">ENG</span>
                </button>
            </div>
        </div>
    </header>

    <div class="flex min-h-[calc(100vh-3.5rem)] max-w-screen-2xl mx-auto w-full">
        {{-- Desktop Sidebar --}}
        @auth
        <aside class="hidden lg:flex flex-col w-56 shrink-0 bg-white dark:bg-gray-800 border-r border-gray-100 dark:border-gray-700 p-4 sticky top-14 h-[calc(100vh-3.5rem)] overflow-y-auto dark-transition">
            <nav class="space-y-1 mt-2">
                <a href="{{ route('home') }}" class="sidebar-link {{ request()->routeIs('home') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    <span data-en="Home" data-jp="ホーム">Home</span>
                </a>
                <a href="{{ route('search') }}" class="sidebar-link {{ request()->routeIs('search') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <span data-en="Search by area" data-jp="エリア検索">Search by area</span>
                </a>
                <a href="{{ route('liked') }}" class="sidebar-link {{ request()->routeIs('liked') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    <span data-en="Liked" data-jp="いいね">Liked</span>
                </a>
                <a href="{{ route('who.liked.me') }}" class="sidebar-link {{ request()->routeIs('who.liked.me') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    <span data-en="Who Liked Me" data-jp="誰がいいね">Who Liked Me</span>
                </a>
                <a href="{{ route('messages.inbox') }}" class="sidebar-link {{ request()->routeIs('messages.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                    <span data-en="Messages" data-jp="メッセージ">Messages</span>
                    @if(isset($unreadCount) && $unreadCount > 0)
                        <span class="ml-auto bg-primary text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center">{{ $unreadCount }}</span>
                    @endif
                </a>
                <a href="{{ route('profile.show') }}" class="sidebar-link {{ request()->routeIs('profile.show') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    <span data-en="Profile" data-jp="プロフィール">Profile</span>
                </a>
                <div class="border-t border-gray-100 dark:border-gray-700 my-4"></div>
                <form method="POST" action="{{ route('logout') }}">@csrf
                    <button type="submit" class="sidebar-link w-full text-left text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        <span data-en="Logout" data-jp="ログアウト">Logout</span>
                    </button>
                </form>
            </nav>
        </aside>
        @endauth

        {{-- Mobile Sidebar --}}
        <div id="mobile-sidebar" class="hidden fixed inset-0 z-50 lg:hidden">
            <div class="absolute inset-0 bg-black/40" onclick="document.getElementById('mobile-sidebar').classList.add('hidden')"></div>
            <div class="absolute left-0 top-0 bottom-0 w-64 bg-white dark:bg-gray-800 shadow-2xl p-4 overflow-y-auto dark-transition">
                <div class="flex items-center justify-between mb-6">
                    <span class="text-xl font-extrabold" style="color:#FF69B4;">K&#9734;K&#9734;R&#9734;</span>
                    <button onclick="document.getElementById('mobile-sidebar').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                @auth
                <nav class="space-y-1">
                    <a href="{{ route('home') }}" class="sidebar-link {{ request()->routeIs('home') ? 'active' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        <span data-en="Home" data-jp="ホーム">Home</span>
                    </a>
                    <a href="{{ route('search') }}" class="sidebar-link {{ request()->routeIs('search') ? 'active' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <span data-en="Search" data-jp="検索">Search</span>
                    </a>
                    <a href="{{ route('liked') }}" class="sidebar-link {{ request()->routeIs('liked') ? 'active' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                        <span data-en="Liked" data-jp="いいね">Liked</span>
                    </a>
                    <a href="{{ route('who.liked.me') }}" class="sidebar-link {{ request()->routeIs('who.liked.me') ? 'active' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        <span data-en="Who Liked Me" data-jp="誰がいいね">Who Liked Me</span>
                    </a>
                    <a href="{{ route('messages.inbox') }}" class="sidebar-link {{ request()->routeIs('messages.*') ? 'active' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                        <span data-en="Messages" data-jp="メッセージ">Messages</span>
                    </a>
                    <a href="{{ route('profile.show') }}" class="sidebar-link {{ request()->routeIs('profile.show') ? 'active' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        <span data-en="Profile" data-jp="プロフィール">Profile</span>
                    </a>
                    <hr class="my-3 border-gray-100 dark:border-gray-700">
                    <form method="POST" action="{{ route('logout') }}">@csrf
                        <button type="submit" class="sidebar-link w-full text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                            <span data-en="Logout" data-jp="ログアウト">Logout</span>
                        </button>
                    </form>
                </nav>
                @endauth
            </div>
        </div>

        {{-- Main Content --}}
        <main class="flex-1 p-4 sm:p-6 lg:p-8 pb-24 lg:pb-8 min-w-0 overflow-auto">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-400 rounded-xl text-sm animate-fade-in-up flex items-center justify-between" id="flash-success">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ session('success') }}
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-green-400 hover:text-green-600 ml-2 text-lg">&times;</button>
                </div>
            @endif
            @if(session('error'))
                <div class="mb-4 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-400 rounded-xl text-sm animate-fade-in-up flex items-center justify-between">
                    <span>{{ session('error') }}</span>
                    <button onclick="this.parentElement.remove()" class="text-red-400 hover:text-red-600 ml-2 text-lg">&times;</button>
                </div>
            @endif
            @if(session('info'))
                <div class="mb-4 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 text-blue-700 dark:text-blue-400 rounded-xl text-sm animate-fade-in-up flex items-center justify-between">
                    <span>{{ session('info') }}</span>
                    <button onclick="this.parentElement.remove()" class="text-blue-400 hover:text-blue-600 ml-2 text-lg">&times;</button>
                </div>
            @endif
            @yield('content')
        </main>
    </div>

    {{-- Mobile Bottom Navigation --}}
    @auth
    <nav class="lg:hidden fixed bottom-0 left-0 right-0 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 z-40 dark-transition">
        <div class="flex items-center justify-around py-1.5 max-w-lg mx-auto">
            <a href="{{ route('home') }}" class="mobile-nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                <span data-en="Home" data-jp="ホーム">Home</span>
            </a>
            <a href="{{ route('search') }}" class="mobile-nav-link {{ request()->routeIs('search') ? 'active' : '' }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <span data-en="Search" data-jp="検索">Search</span>
            </a>
            <a href="{{ route('liked') }}" class="mobile-nav-link {{ request()->routeIs('liked') ? 'active' : '' }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                <span data-en="Liked" data-jp="いいね">Liked</span>
            </a>
            <a href="{{ route('messages.inbox') }}" class="mobile-nav-link {{ request()->routeIs('messages.*') ? 'active' : '' }}">
                <div class="relative">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                    @if(isset($unreadCount) && $unreadCount > 0)
                        <span class="absolute -top-1 -right-2 bg-primary text-white text-[10px] font-bold rounded-full w-4 h-4 flex items-center justify-center">{{ $unreadCount > 9 ? '9+' : $unreadCount }}</span>
                    @endif
                </div>
                <span data-en="Chat" data-jp="チャット">Chat</span>
            </a>
            <a href="{{ route('profile.show') }}" class="mobile-nav-link {{ request()->routeIs('profile.show') ? 'active' : '' }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                <span data-en="Profile" data-jp="自分">Profile</span>
            </a>
        </div>
    </nav>
    @endauth

    <script>
        // ── Dark Mode ──
        function toggleDarkMode() {
            const html = document.documentElement;
            html.classList.toggle('dark');
            localStorage.setItem('kokoro-dark-mode', html.classList.contains('dark'));
            updateDarkModeIcons();
        }
        function updateDarkModeIcons() {
            const isDark = document.documentElement.classList.contains('dark');
            document.getElementById('dark-icon').classList.toggle('hidden', !isDark);
            document.getElementById('light-icon').classList.toggle('hidden', isDark);
        }
        updateDarkModeIcons();

        // ── ENG/JP Language Toggle ──
        function toggleLanguage() {
            const currentLang = localStorage.getItem('kokoro-lang') || 'en';
            const newLang = currentLang === 'en' ? 'jp' : 'en';
            localStorage.setItem('kokoro-lang', newLang);
            applyLanguage(newLang);
        }
        function applyLanguage(lang) {
            const label = document.getElementById('lang-label');
            if (label) label.textContent = lang === 'en' ? 'ENG' : 'JP';
            document.querySelectorAll('[data-en][data-jp]').forEach(el => {
                el.textContent = lang === 'en' ? el.dataset.en : el.dataset.jp;
            });
        }
        applyLanguage(localStorage.getItem('kokoro-lang') || 'en');

        // ── Auto-dismiss flash ──
        setTimeout(() => { const f = document.getElementById('flash-success'); if (f) { f.style.opacity='0'; f.style.transition='opacity 0.5s'; setTimeout(()=>f.remove(),500); } }, 4000);

        // ── Close dropdowns on outside click ──
        document.addEventListener('click', e => {
            document.querySelectorAll('.relative > .hidden + *, .relative > div:not(.hidden)').forEach(menu => {
                if (menu.previousElementSibling && !menu.parentElement.contains(e.target)) menu.classList.add('hidden');
            });
        });
    </script>
    @yield('scripts')
</body>
</html>
