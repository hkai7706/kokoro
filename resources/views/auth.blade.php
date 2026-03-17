<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>KOKORO - Log In / Sign Up</title>
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
            theme: { extend: { fontFamily: { sans: ['Plus Jakarta Sans', 'system-ui', 'sans-serif'] } } }
        }
    </script>
    <style>
        @keyframes fadeIn { from { opacity:0; transform: translateY(6px); } to { opacity:1; transform: translateY(0); } }
        .animate-in { animation: fadeIn 0.25s ease-out; }
    </style>
</head>
<body class="font-sans bg-gray-50 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-sm">
        {{-- Language --}}
        <div class="text-center mb-5">
            <button onclick="toggleAuthLang()" class="inline-flex items-center text-[11px] font-semibold px-2.5 py-1.5 rounded-md border border-gray-200 text-gray-500 hover:bg-gray-100 transition cursor-pointer" id="auth-lang-toggle" aria-label="Switch language">
                <span id="auth-lang-label">ENG</span>
            </button>
        </div>

        {{-- Login --}}
        <div id="login-form" class="animate-in">
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <div class="text-center mb-6">
                    <span class="text-xl font-extrabold text-rose-500 tracking-tight">KOKORO</span>
                    <p class="text-gray-500 text-sm mt-2" data-en="Welcome back" data-jp="おかえりなさい">Welcome back</p>
                </div>

                @if($errors->any() && !old('is_register'))
                    <div class="bg-red-50 border border-red-200/60 text-red-600 text-xs rounded-lg p-3 mb-4">
                        @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" autocomplete="off">
                    @csrf
                    <div class="space-y-3.5">
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1" data-en="Email" data-jp="メールアドレス">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}" required autocomplete="new-email"
                                class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 focus:ring-2 focus:ring-rose-100 focus:border-rose-400 text-gray-800 text-sm transition"
                                placeholder="your@email.com" data-placeholder-en="your@email.com" data-placeholder-jp="メール@example.com">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1" data-en="Password" data-jp="パスワード">Password</label>
                            <div class="relative">
                                <input type="password" name="password" id="login-password" required autocomplete="new-password"
                                    class="w-full px-3.5 py-2.5 pr-10 rounded-lg border border-gray-200 focus:ring-2 focus:ring-rose-100 focus:border-rose-400 text-gray-800 text-sm transition"
                                    placeholder="Enter your password" data-placeholder-en="Enter your password" data-placeholder-jp="パスワードを入力">
                                <button type="button" onclick="togglePassword('login-password', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition" aria-label="Toggle password visibility">
                                    <svg class="w-4 h-4 eye-open" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    <svg class="w-4 h-4 eye-closed hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L6.59 6.59m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>
                                </button>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <input type="checkbox" name="remember" id="remember" class="rounded border-gray-300 text-rose-500 focus:ring-rose-400">
                                <label for="remember" class="text-xs text-gray-500" data-en="Remember me" data-jp="ログイン状態を保持">Remember me</label>
                            </div>
                            <a href="{{ route('password.request') }}" class="text-xs text-rose-500 hover:text-rose-600 font-medium" data-en="Forgot password?" data-jp="パスワードを忘れた？">Forgot password?</a>
                        </div>
                        <button type="submit" class="w-full py-2.5 bg-rose-500 hover:bg-rose-600 text-white font-semibold rounded-lg transition text-sm" data-en="Log in" data-jp="ログイン">Log in</button>
                    </div>
                </form>
                <p class="text-center text-sm text-gray-500 mt-5">
                    <span data-en="No account?" data-jp="アカウントをお持ちでないですか?">No account?</span>
                    <button type="button" onclick="toggleForm()" class="text-rose-500 font-semibold hover:text-rose-600 ml-1" data-en="Sign up" data-jp="新規登録">Sign up</button>
                </p>
            </div>
        </div>

        {{-- Register --}}
        <div id="register-form" class="hidden animate-in">
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <div class="text-center mb-6">
                    <span class="text-xl font-extrabold text-rose-500 tracking-tight">KOKORO</span>
                    <p class="text-gray-500 text-sm mt-2" data-en="Create your account" data-jp="アカウントを作成">Create your account</p>
                </div>

                @if($errors->any() && old('is_register'))
                    <div class="bg-red-50 border border-red-200/60 text-red-600 text-xs rounded-lg p-3 mb-4">
                        @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" autocomplete="off">
                    @csrf
                    <input type="hidden" name="is_register" value="1">
                    <div class="space-y-3.5">
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1" data-en="Name" data-jp="名前">Name</label>
                            <input type="text" name="name" value="{{ old('name') }}" required autocomplete="off"
                                class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 focus:ring-2 focus:ring-rose-100 focus:border-rose-400 text-gray-800 text-sm transition"
                                placeholder="Your name" data-placeholder-en="Your name" data-placeholder-jp="お名前">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1" data-en="Email" data-jp="メールアドレス">Email</label>
                            <input type="email" name="email" value="{{ old('is_register') ? old('email') : '' }}" required autocomplete="new-email"
                                class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 focus:ring-2 focus:ring-rose-100 focus:border-rose-400 text-gray-800 text-sm transition"
                                placeholder="your@email.com" data-placeholder-en="your@email.com" data-placeholder-jp="メール@example.com">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1" data-en="Password" data-jp="パスワード">Password</label>
                            <div class="relative">
                                <input type="password" name="password" id="register-password" required autocomplete="new-password"
                                    class="w-full px-3.5 py-2.5 pr-10 rounded-lg border border-gray-200 focus:ring-2 focus:ring-rose-100 focus:border-rose-400 text-gray-800 text-sm transition"
                                    placeholder="Min 8 characters, mixed case + numbers" data-placeholder-en="Min 8 characters, mixed case + numbers" data-placeholder-jp="8文字以上、大小文字+数字">
                                <button type="button" onclick="togglePassword('register-password', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition" aria-label="Toggle password visibility">
                                    <svg class="w-4 h-4 eye-open" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    <svg class="w-4 h-4 eye-closed hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L6.59 6.59m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>
                                </button>
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1" data-en="Confirm Password" data-jp="パスワード確認">Confirm Password</label>
                            <div class="relative">
                                <input type="password" name="password_confirmation" id="register-password-confirm" required autocomplete="new-password"
                                    class="w-full px-3.5 py-2.5 pr-10 rounded-lg border border-gray-200 focus:ring-2 focus:ring-rose-100 focus:border-rose-400 text-gray-800 text-sm transition"
                                    placeholder="Re-enter your password" data-placeholder-en="Re-enter your password" data-placeholder-jp="パスワードを再入力">
                                <button type="button" onclick="togglePassword('register-password-confirm', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition" aria-label="Toggle password visibility">
                                    <svg class="w-4 h-4 eye-open" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    <svg class="w-4 h-4 eye-closed hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L6.59 6.59m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>
                                </button>
                            </div>
                        </div>
                        <button type="submit" class="w-full py-2.5 bg-rose-500 hover:bg-rose-600 text-white font-semibold rounded-lg transition text-sm" data-en="Create account" data-jp="アカウント作成">Create account</button>
                    </div>
                </form>
                <p class="text-center text-sm text-gray-500 mt-5">
                    <span data-en="Have an account?" data-jp="アカウントをお持ちですか?">Have an account?</span>
                    <button type="button" onclick="toggleForm()" class="text-rose-500 font-semibold hover:text-rose-600 ml-1" data-en="Log in" data-jp="ログイン">Log in</button>
                </p>
            </div>
        </div>

        <div class="text-center mt-5">
            <a href="/" class="text-gray-500 hover:text-gray-600 text-xs transition" data-en="Back to KOKORO" data-jp="KOKOROに戻る">&larr; Back to KOKORO</a>
        </div>
    </div>

    <script>
        function togglePassword(inputId, btn) {
            const input = document.getElementById(inputId);
            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';
            btn.querySelector('.eye-open').classList.toggle('hidden', isPassword);
            btn.querySelector('.eye-closed').classList.toggle('hidden', !isPassword);
        }

        function toggleForm() {
            document.getElementById('login-form').classList.toggle('hidden');
            document.getElementById('register-form').classList.toggle('hidden');
        }
        @if(old('is_register')) toggleForm(); @endif

        function toggleAuthLang() {
            const c = localStorage.getItem('kokoro-lang') || 'en';
            const n = c === 'en' ? 'jp' : 'en';
            localStorage.setItem('kokoro-lang', n);
            applyAuthLang(n);
        }
        function applyAuthLang(lang) {
            document.getElementById('auth-lang-label').textContent = lang === 'en' ? 'ENG' : 'JP';
            document.querySelectorAll('[data-en][data-jp]').forEach(el => { el.textContent = lang === 'en' ? el.dataset.en : el.dataset.jp; });
            document.querySelectorAll('[data-placeholder-en][data-placeholder-jp]').forEach(el => { el.placeholder = lang === 'en' ? el.dataset.placeholderEn : el.dataset.placeholderJp; });
        }
        applyAuthLang(localStorage.getItem('kokoro-lang') || 'en');
    </script>
</body>
</html>
