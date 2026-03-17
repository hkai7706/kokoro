<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'KOKORO - Find Your Match')</title>
    <meta name="description" content="@yield('description', 'KOKORO - Japan\'s modern partner matching platform.')">
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon-16x16.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/favicon-180x180.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">
    <meta name="theme-color" content="#e11d48">
    <link rel="preconnect" href="https://fonts.bunny.net" crossorigin>
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: { sans: ['Plus Jakarta Sans', 'system-ui', 'sans-serif'] }
                }
            }
        }
    </script>
    <script>
        (function() {
            if (localStorage.getItem('kokoro-dark-mode') === 'true') document.documentElement.classList.add('dark');
        })();
    </script>
    <style>
        /* Sidebar */
        .sidebar-link{display:flex;align-items:center;gap:.75rem;padding:.5rem .75rem;border-radius:.5rem;color:#6b7280;font-weight:500;font-size:.8125rem;transition:all .15s;letter-spacing:-.01em}
        .sidebar-link:hover{background:#f9fafb;color:#374151}
        .sidebar-link.active{background:#fff1f2;color:#e11d48;font-weight:600}
        .dark .sidebar-link{color:#9ca3af}
        .dark .sidebar-link:hover{background:#1f2937;color:#f9fafb}
        .dark .sidebar-link.active{background:rgba(225,29,72,.12);color:#fb7185}

        /* Cards — two variants for visual variety */
        .card{background:#fff;border:1px solid #e5e7eb;border-radius:.75rem;transition:box-shadow .2s}
        .card:hover{box-shadow:0 2px 8px rgba(0,0,0,.04)}
        .dark .card{background:#111827;border-color:#1f2937}
        .dark .card:hover{box-shadow:0 2px 8px rgba(0,0,0,.15)}

        .card-flat{background:#fff;border-radius:.75rem;transition:all .2s}
        .dark .card-flat{background:#111827}

        /* Buttons */
        .btn{display:inline-flex;align-items:center;justify-content:center;gap:.375rem;font-weight:600;font-size:.8125rem;padding:.5rem 1.125rem;border-radius:.5rem;transition:all .15s;cursor:pointer;letter-spacing:-.01em}
        .btn-rose{background:#e11d48;color:#fff}
        .btn-rose:hover{background:#be123c}
        .btn-outline{background:transparent;border:1.5px solid #d1d5db;color:#374151}
        .btn-outline:hover{background:#f9fafb;border-color:#9ca3af}
        .btn-ghost{background:#f3f4f6;color:#4b5563}
        .btn-ghost:hover{background:#e5e7eb}
        .btn-sm{font-size:.75rem;padding:.375rem .75rem}
        .dark .btn-outline{border-color:#374151;color:#d1d5db}
        .dark .btn-outline:hover{background:#1f2937;border-color:#4b5563}
        .dark .btn-ghost{background:#1f2937;color:#d1d5db}
        .dark .btn-ghost:hover{background:#374151}

        /* Tags */
        .tag{display:inline-flex;align-items:center;font-size:.6875rem;font-weight:500;padding:.1875rem .5rem;border-radius:.375rem;letter-spacing:.01em}

        /* Utility */
        .line-clamp-2{display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}
        @keyframes fadeIn{from{opacity:0;transform:translateY(6px)}to{opacity:1;transform:translateY(0)}}
        .animate-in{animation:fadeIn .25s ease-out both}

        /* Scrollbar */
        ::-webkit-scrollbar{width:4px}
        ::-webkit-scrollbar-track{background:transparent}
        ::-webkit-scrollbar-thumb{background:#d1d5db;border-radius:2px}
        .dark ::-webkit-scrollbar-thumb{background:#374151}

        /* Mobile nav */
        .mobile-nav-item{display:flex;flex-direction:column;align-items:center;gap:1px;font-size:.625rem;font-weight:500;padding:.375rem 0;color:#9ca3af;transition:color .15s;min-width:3rem}
        .mobile-nav-item.active{color:#e11d48}
        .mobile-nav-item:hover{color:#6b7280}
        .mobile-nav-item.active:hover{color:#e11d48}

        /* Section labels */
        .section-label{font-size:.6875rem;font-weight:600;color:#9ca3af;text-transform:uppercase;letter-spacing:.06em}
    </style>
    @yield('head')
</head>
<body class="font-sans bg-gray-50 dark:bg-gray-950 text-gray-800 dark:text-gray-200 antialiased min-h-screen">

    {{-- Header --}}
    <header class="bg-white dark:bg-gray-900 sticky top-0 z-50 border-b border-gray-200/60 dark:border-gray-800">
        <div class="max-w-screen-2xl mx-auto px-4 flex items-center justify-between h-14">
            <div class="flex items-center gap-3">
                <button onclick="document.getElementById('mobile-sidebar').classList.toggle('hidden')" class="lg:hidden text-gray-400 hover:text-gray-600 dark:hover:text-white -ml-1 p-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <a href="{{ route('home') }}" class="flex items-center gap-1">
                    <span class="text-lg font-extrabold tracking-tight text-rose-500">KOKORO</span>
                </a>
            </div>
            <div class="flex items-center gap-1">
                @auth
                @php $unreadCount = auth()->user()->unreadMessagesCount(); @endphp
                <a href="{{ route('messages.inbox') }}" class="relative p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                    @if($unreadCount > 0)
                        <span class="absolute top-1 right-1 bg-rose-500 text-white text-[9px] font-bold rounded-full w-4 h-4 flex items-center justify-center">{{ $unreadCount > 9 ? '9+' : $unreadCount }}</span>
                    @endif
                </a>
                <button onclick="toggleDarkMode()" class="p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                    <svg id="dark-icon" class="w-[18px] h-[18px] hidden" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    <svg id="light-icon" class="w-[18px] h-[18px] hidden" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                </button>
                <button onclick="toggleLanguage()" class="hidden sm:flex items-center text-[11px] font-semibold px-2 py-1 rounded-md cursor-pointer border border-gray-200 dark:border-gray-700 text-gray-400 dark:text-gray-500 hover:bg-gray-50 dark:hover:bg-gray-800 transition" id="lang-toggle">
                    <span id="lang-label">ENG</span>
                </button>
                <div class="relative ml-1">
                    <button onclick="this.nextElementSibling.classList.toggle('hidden')" class="flex items-center gap-1.5 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg pl-1 pr-2 py-1 transition cursor-pointer">
                        <div class="w-7 h-7 rounded-full bg-rose-50 dark:bg-rose-900/20 overflow-hidden border border-rose-200/60 dark:border-rose-800/40 flex items-center justify-center">
                            @if(auth()->user()->profile && auth()->user()->profile->profile_photo)
                                <img src="{{ asset('storage/' . auth()->user()->profile->profile_photo) }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-[11px] font-bold text-rose-400">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                            @endif
                        </div>
                        <svg class="w-3 h-3 text-gray-300 hidden sm:block" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div class="hidden absolute right-0 mt-1 w-44 bg-white dark:bg-gray-900 rounded-lg shadow-lg border border-gray-200 dark:border-gray-800 py-1 z-50">
                        <div class="px-3.5 py-2 border-b border-gray-100 dark:border-gray-800">
                            <p class="text-xs font-medium text-gray-800 dark:text-gray-200 truncate">{{ auth()->user()->name }}</p>
                            <p class="text-[11px] text-gray-400 truncate">{{ auth()->user()->email }}</p>
                        </div>
                        <a href="{{ route('profile.show') }}" class="block px-3.5 py-2 text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800" data-en="My Profile" data-jp="プロフィール">My Profile</a>
                        <a href="{{ route('messages.inbox') }}" class="block px-3.5 py-2 text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800">
                            <span data-en="Messages" data-jp="メッセージ">Messages</span>
                            @if($unreadCount > 0)<span class="ml-1 bg-rose-500 text-white text-[10px] px-1.5 py-0.5 rounded-full">{{ $unreadCount }}</span>@endif
                        </a>
                        <hr class="my-1 border-gray-100 dark:border-gray-800">
                        <form method="POST" action="{{ route('logout') }}">@csrf
                            <button type="submit" class="block w-full text-left px-3.5 py-2 text-sm text-gray-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/10" data-en="Log out" data-jp="ログアウト">Log out</button>
                        </form>
                    </div>
                </div>
                @endauth
            </div>
        </div>
    </header>

    <div class="flex min-h-[calc(100vh-3.5rem)] max-w-screen-2xl mx-auto w-full">
        {{-- Desktop Sidebar --}}
        @auth
        <aside class="hidden lg:flex flex-col w-48 shrink-0 border-r border-gray-200/60 dark:border-gray-800 px-3 py-5 sticky top-14 h-[calc(100vh-3.5rem)] overflow-y-auto">
            <nav class="space-y-0.5">
                <a href="{{ route('home') }}" class="sidebar-link {{ request()->routeIs('home') ? 'active' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    <span data-en="Home" data-jp="ホーム">Home</span>
                </a>
                <a href="{{ route('search') }}" class="sidebar-link {{ request()->routeIs('search') ? 'active' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <span data-en="Discover" data-jp="探す">Discover</span>
                </a>

                <div class="pt-3 pb-1"><span class="section-label px-3" data-en="Activity" data-jp="アクティビティ">Activity</span></div>

                <a href="{{ route('liked') }}" class="sidebar-link {{ request()->routeIs('liked') ? 'active' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    <span data-en="Liked" data-jp="いいね">Liked</span>
                </a>
                <a href="{{ route('who.liked.me') }}" class="sidebar-link {{ request()->routeIs('who.liked.me') ? 'active' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    <span data-en="Who Liked Me" data-jp="いいねされた">Who Liked Me</span>
                </a>
                <a href="{{ route('messages.inbox') }}" class="sidebar-link {{ request()->routeIs('messages.*') ? 'active' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                    <span data-en="Messages" data-jp="メッセージ">Messages</span>
                    @if(isset($unreadCount) && $unreadCount > 0)
                        <span class="ml-auto bg-rose-500 text-white text-[9px] font-bold rounded-full w-[18px] h-[18px] flex items-center justify-center">{{ $unreadCount }}</span>
                    @endif
                </a>

                <div class="pt-3 pb-1"><span class="section-label px-3" data-en="Account" data-jp="アカウント">Account</span></div>

                <a href="{{ route('profile.show') }}" class="sidebar-link {{ request()->routeIs('profile.show') ? 'active' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    <span data-en="Profile" data-jp="プロフィール">Profile</span>
                </a>
            </nav>
            <div class="mt-auto pt-4 border-t border-gray-100 dark:border-gray-800">
                <form method="POST" action="{{ route('logout') }}">@csrf
                    <button type="submit" class="sidebar-link w-full text-left text-gray-400 hover:text-red-500 hover:bg-red-50/50 dark:hover:bg-red-900/10">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        <span data-en="Log out" data-jp="ログアウト">Log out</span>
                    </button>
                </form>
            </div>
        </aside>
        @endauth

        {{-- Mobile Sidebar --}}
        <div id="mobile-sidebar" class="hidden fixed inset-0 z-50 lg:hidden">
            <div class="absolute inset-0 bg-black/30 backdrop-blur-sm" onclick="document.getElementById('mobile-sidebar').classList.add('hidden')"></div>
            <div class="absolute left-0 top-0 bottom-0 w-60 bg-white dark:bg-gray-900 shadow-xl p-4 overflow-y-auto animate-in">
                <div class="flex items-center justify-between mb-5">
                    <span class="text-lg font-extrabold text-rose-500 tracking-tight">KOKORO</span>
                    <button onclick="document.getElementById('mobile-sidebar').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 p-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                @auth
                <nav class="space-y-0.5">
                    <a href="{{ route('home') }}" class="sidebar-link {{ request()->routeIs('home') ? 'active' : '' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        <span data-en="Home" data-jp="ホーム">Home</span>
                    </a>
                    <a href="{{ route('search') }}" class="sidebar-link {{ request()->routeIs('search') ? 'active' : '' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <span data-en="Discover" data-jp="探す">Discover</span>
                    </a>
                    <a href="{{ route('liked') }}" class="sidebar-link {{ request()->routeIs('liked') ? 'active' : '' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                        <span data-en="Liked" data-jp="いいね">Liked</span>
                    </a>
                    <a href="{{ route('who.liked.me') }}" class="sidebar-link {{ request()->routeIs('who.liked.me') ? 'active' : '' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        <span data-en="Who Liked Me" data-jp="いいねされた">Who Liked Me</span>
                    </a>
                    <a href="{{ route('messages.inbox') }}" class="sidebar-link {{ request()->routeIs('messages.*') ? 'active' : '' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                        <span data-en="Messages" data-jp="メッセージ">Messages</span>
                    </a>
                    <a href="{{ route('profile.show') }}" class="sidebar-link {{ request()->routeIs('profile.show') ? 'active' : '' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        <span data-en="Profile" data-jp="プロフィール">Profile</span>
                    </a>
                    <hr class="my-2.5 border-gray-100 dark:border-gray-800">
                    <button onclick="toggleLanguage()" class="sidebar-link w-full">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/></svg>
                        <span id="mobile-lang-label" data-en="English" data-jp="日本語">English</span>
                    </button>
                    <form method="POST" action="{{ route('logout') }}">@csrf
                        <button type="submit" class="sidebar-link w-full text-gray-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/10">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                            <span data-en="Log out" data-jp="ログアウト">Log out</span>
                        </button>
                    </form>
                </nav>
                @endauth
            </div>
        </div>

        {{-- Main Content --}}
        <main class="flex-1 p-4 sm:p-6 lg:p-8 pb-24 lg:pb-8 min-w-0 overflow-auto">
            @if(session('success'))
                <div class="mb-5 px-4 py-3 bg-emerald-50 dark:bg-emerald-900/15 border border-emerald-200/60 dark:border-emerald-800/40 text-emerald-700 dark:text-emerald-400 rounded-lg text-sm animate-in flex items-center justify-between" id="flash-success">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ session('success') }}
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-emerald-600 ml-3 text-lg leading-none">&times;</button>
                </div>
            @endif
            @if(session('error'))
                <div class="mb-5 px-4 py-3 bg-red-50 dark:bg-red-900/15 border border-red-200/60 dark:border-red-800/40 text-red-600 dark:text-red-400 rounded-lg text-sm animate-in flex items-center justify-between">
                    <span>{{ session('error') }}</span>
                    <button onclick="this.parentElement.remove()" class="text-red-400 hover:text-red-600 ml-3 text-lg leading-none">&times;</button>
                </div>
            @endif
            @if(session('info'))
                <div class="mb-5 px-4 py-3 bg-blue-50 dark:bg-blue-900/15 border border-blue-200/60 dark:border-blue-800/40 text-blue-600 dark:text-blue-400 rounded-lg text-sm animate-in flex items-center justify-between">
                    <span>{{ session('info') }}</span>
                    <button onclick="this.parentElement.remove()" class="text-blue-400 hover:text-blue-600 ml-3 text-lg leading-none">&times;</button>
                </div>
            @endif
            @yield('content')
        </main>
    </div>

    {{-- Mobile Bottom Navigation --}}
    @auth
    <nav class="lg:hidden fixed bottom-0 left-0 right-0 bg-white dark:bg-gray-900 border-t border-gray-200/60 dark:border-gray-800 z-40 safe-area-bottom">
        <div class="flex items-center justify-around py-1.5 max-w-md mx-auto">
            <a href="{{ route('home') }}" class="mobile-nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
                <svg class="w-[22px] h-[22px]" fill="{{ request()->routeIs('home') ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                <span data-en="Home" data-jp="ホーム">Home</span>
            </a>
            <a href="{{ route('search') }}" class="mobile-nav-item {{ request()->routeIs('search') ? 'active' : '' }}">
                <svg class="w-[22px] h-[22px]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <span data-en="Discover" data-jp="探す">Discover</span>
            </a>
            <a href="{{ route('liked') }}" class="mobile-nav-item {{ request()->routeIs('liked') ? 'active' : '' }}">
                <svg class="w-[22px] h-[22px]" fill="{{ request()->routeIs('liked') ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                <span data-en="Liked" data-jp="いいね">Liked</span>
            </a>
            <a href="{{ route('messages.inbox') }}" class="mobile-nav-item {{ request()->routeIs('messages.*') ? 'active' : '' }}">
                <div class="relative">
                    <svg class="w-[22px] h-[22px]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                    @if(isset($unreadCount) && $unreadCount > 0)
                        <span class="absolute -top-1 -right-2 bg-rose-500 text-white text-[8px] font-bold rounded-full w-3.5 h-3.5 flex items-center justify-center">{{ $unreadCount > 9 ? '!' : $unreadCount }}</span>
                    @endif
                </div>
                <span data-en="Chat" data-jp="チャット">Chat</span>
            </a>
            <a href="{{ route('profile.show') }}" class="mobile-nav-item {{ request()->routeIs('profile.show') ? 'active' : '' }}">
                <svg class="w-[22px] h-[22px]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                <span data-en="Me" data-jp="自分">Me</span>
            </a>
        </div>
    </nav>
    @endauth

    <script>
        function toggleDarkMode() {
            const h = document.documentElement;
            h.classList.toggle('dark');
            localStorage.setItem('kokoro-dark-mode', h.classList.contains('dark'));
            updateDarkModeIcons();
        }
        function updateDarkModeIcons() {
            const d = document.documentElement.classList.contains('dark');
            document.getElementById('dark-icon').classList.toggle('hidden', !d);
            document.getElementById('light-icon').classList.toggle('hidden', d);
        }
        updateDarkModeIcons();

        function toggleLanguage() {
            const c = localStorage.getItem('kokoro-lang') || 'en';
            const n = c === 'en' ? 'jp' : 'en';
            localStorage.setItem('kokoro-lang', n);
            applyLanguage(n);
        }
        function applyLanguage(lang) {
            const l = document.getElementById('lang-label');
            if (l) l.textContent = lang === 'en' ? 'ENG' : 'JP';
            const m = document.getElementById('mobile-lang-label');
            if (m) m.textContent = lang === 'en' ? 'English' : '日本語';
            document.querySelectorAll('[data-en][data-jp]').forEach(el => {
                el.textContent = lang === 'en' ? el.dataset.en : el.dataset.jp;
            });
            document.querySelectorAll('[data-placeholder-en][data-placeholder-jp]').forEach(el => {
                el.placeholder = lang === 'en' ? el.dataset.placeholderEn : el.dataset.placeholderJp;
            });
        }
        applyLanguage(localStorage.getItem('kokoro-lang') || 'en');

        setTimeout(() => {
            const f = document.getElementById('flash-success');
            if (f) { f.style.opacity = '0'; f.style.transition = 'opacity .4s'; setTimeout(() => f.remove(), 400); }
        }, 4000);

        document.addEventListener('click', e => {
            document.querySelectorAll('.relative > div:not(.hidden)').forEach(menu => {
                if (menu.previousElementSibling && menu.previousElementSibling.tagName === 'BUTTON' && !menu.parentElement.contains(e.target)) {
                    menu.classList.add('hidden');
                }
            });
        });
    </script>
    @yield('scripts')
</body>
</html>
