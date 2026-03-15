<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>KOKORO - Log In / Sign Up</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: { extend: { fontFamily: { sans: ['Plus Jakarta Sans', 'system-ui', 'sans-serif'] } } }
        }
    </script>
    <style>
        @keyframes fadeIn { from { opacity:0; transform: translateY(8px); } to { opacity:1; transform: translateY(0); } }
        .animate-in { animation: fadeIn 0.3s ease-out; }
    </style>
</head>
<body class="font-sans bg-gray-50 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-sm">
        {{-- Language Toggle --}}
        <div class="text-center mb-5">
            <button onclick="toggleAuthLang()" class="inline-flex items-center text-xs font-semibold px-3 py-1.5 rounded-lg border border-gray-200 text-gray-500 hover:bg-gray-100 transition cursor-pointer" id="auth-lang-toggle">
                <span id="auth-lang-label">ENG</span>
            </button>
        </div>

        {{-- Login Form --}}
        <div id="login-form" class="animate-in">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-7">
                <div class="text-center mb-7">
                    <span class="text-2xl font-extrabold text-rose-500 tracking-wide">KOKORO</span>
                    <span class="text-rose-300 text-xl ml-0.5">&#9825;</span>
                    <p class="text-gray-400 text-sm mt-2 font-medium" data-en="Welcome back" data-jp="おかえりなさい">Welcome back</p>
                </div>

                @if($errors->any() && !old('is_register'))
                    <div class="bg-red-50 border border-red-200 text-red-600 text-sm rounded-xl p-3 mb-4">
                        @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" autocomplete="off">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1" data-en="Email" data-jp="メールアドレス">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}" required autocomplete="new-email"
                                class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 focus:ring-2 focus:ring-rose-200 focus:border-rose-400 text-gray-800 text-sm transition"
                                placeholder="your@email.com" data-placeholder-en="your@email.com" data-placeholder-jp="メール@example.com">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1" data-en="Password" data-jp="パスワード">Password</label>
                            <input type="password" name="password" required autocomplete="new-password"
                                class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 focus:ring-2 focus:ring-rose-200 focus:border-rose-400 text-gray-800 text-sm transition"
                                placeholder="Enter your password" data-placeholder-en="Enter your password" data-placeholder-jp="パスワードを入力">
                        </div>
                        <div class="flex items-center gap-2">
                            <input type="checkbox" name="remember" id="remember" class="rounded border-gray-300 text-rose-500 focus:ring-rose-400">
                            <label for="remember" class="text-sm text-gray-500" data-en="Remember me" data-jp="ログイン状態を保持">Remember me</label>
                        </div>
                        <button type="submit" class="w-full py-2.5 bg-rose-500 hover:bg-rose-600 text-white font-semibold rounded-lg shadow-sm transition text-sm" data-en="Log in" data-jp="ログイン">Log in</button>
                    </div>
                </form>
                <p class="text-center text-sm text-gray-400 mt-5">
                    <span data-en="No account?" data-jp="アカウントをお持ちでないですか?">No account?</span>
                    <button type="button" onclick="toggleForm()" class="text-rose-500 font-semibold hover:text-rose-600 ml-1" data-en="Sign up" data-jp="新規登録">Sign up</button>
                </p>
            </div>
        </div>

        {{-- Register Form --}}
        <div id="register-form" class="hidden animate-in">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-7">
                <div class="text-center mb-7">
                    <span class="text-2xl font-extrabold text-rose-500 tracking-wide">KOKORO</span>
                    <span class="text-rose-300 text-xl ml-0.5">&#9825;</span>
                    <p class="text-gray-400 text-sm mt-2 font-medium" data-en="Create your account" data-jp="アカウントを作成">Create your account</p>
                </div>

                @if($errors->any() && old('is_register'))
                    <div class="bg-red-50 border border-red-200 text-red-600 text-sm rounded-xl p-3 mb-4">
                        @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" autocomplete="off">
                    @csrf
                    <input type="hidden" name="is_register" value="1">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1" data-en="Name" data-jp="名前">Name</label>
                            <input type="text" name="name" value="{{ old('name') }}" required autocomplete="off"
                                class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 focus:ring-2 focus:ring-rose-200 focus:border-rose-400 text-gray-800 text-sm transition"
                                placeholder="Your name" data-placeholder-en="Your name" data-placeholder-jp="お名前">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1" data-en="Email" data-jp="メールアドレス">Email</label>
                            <input type="email" name="email" value="{{ old('is_register') ? old('email') : '' }}" required autocomplete="new-email"
                                class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 focus:ring-2 focus:ring-rose-200 focus:border-rose-400 text-gray-800 text-sm transition"
                                placeholder="your@email.com" data-placeholder-en="your@email.com" data-placeholder-jp="メール@example.com">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1" data-en="Password" data-jp="パスワード">Password</label>
                            <input type="password" name="password" required autocomplete="new-password"
                                class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 focus:ring-2 focus:ring-rose-200 focus:border-rose-400 text-gray-800 text-sm transition"
                                placeholder="Min 8 characters" data-placeholder-en="Min 8 characters" data-placeholder-jp="8文字以上">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1" data-en="Confirm Password" data-jp="パスワード確認">Confirm Password</label>
                            <input type="password" name="password_confirmation" required autocomplete="new-password"
                                class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 focus:ring-2 focus:ring-rose-200 focus:border-rose-400 text-gray-800 text-sm transition"
                                placeholder="Confirm password" data-placeholder-en="Confirm password" data-placeholder-jp="パスワードを再入力">
                        </div>
                        <button type="submit" class="w-full py-2.5 bg-rose-500 hover:bg-rose-600 text-white font-semibold rounded-lg shadow-sm transition text-sm" data-en="Create account" data-jp="アカウント作成">Create account</button>
                    </div>
                </form>
                <p class="text-center text-sm text-gray-400 mt-5">
                    <span data-en="Have an account?" data-jp="アカウントをお持ちですか?">Have an account?</span>
                    <button type="button" onclick="toggleForm()" class="text-rose-500 font-semibold hover:text-rose-600 ml-1" data-en="Log in" data-jp="ログイン">Log in</button>
                </p>
            </div>
        </div>

        <div class="text-center mt-5">
            <a href="/" class="text-gray-400 hover:text-gray-500 text-sm transition" data-en="Back to KOKORO" data-jp="KOKOROに戻る">&larr; Back to KOKORO</a>
        </div>
    </div>

    <script>
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
