<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Reset Password - KOKORO</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="preconnect" href="https://fonts.bunny.net" crossorigin>
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,600,700,800&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: { extend: { fontFamily: { sans: ['Plus Jakarta Sans', 'system-ui', 'sans-serif'] } } }
        }
    </script>
</head>
<body class="font-sans bg-gray-50 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-sm">
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <div class="text-center mb-6">
                <span class="text-xl font-extrabold text-rose-500 tracking-tight">KOKORO</span>
                <p class="text-gray-500 text-sm mt-2" data-en="Reset your password" data-jp="パスワードをリセット">Reset your password</p>
            </div>

            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-100 text-emerald-600 text-xs rounded-lg p-3 mb-4">
                    <span data-en="We've emailed you a password reset link!" data-jp="パスワードリセットリンクをメールで送信しました！">We've emailed you a password reset link!</span>
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-50 border border-red-200/60 text-red-600 text-xs rounded-lg p-3 mb-4">
                    @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
                </div>
            @endif

            <p class="text-xs text-gray-600 mb-4" data-en="Enter your email address and we'll send you a link to reset your password." data-jp="メールアドレスを入力すると、パスワードリセットリンクが送信されます。">Enter your email address and we'll send you a link to reset your password.</p>

            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="space-y-3.5">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1" data-en="Email" data-jp="メールアドレス">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus
                            class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 focus:ring-2 focus:ring-rose-100 focus:border-rose-400 text-gray-800 text-sm transition"
                            placeholder="your@email.com" data-placeholder-en="your@email.com" data-placeholder-jp="メール@example.com">
                    </div>
                    <button type="submit" class="w-full py-2.5 bg-rose-500 hover:bg-rose-600 text-white font-semibold rounded-lg transition text-sm" data-en="Send reset link" data-jp="リセットリンクを送信">Send reset link</button>
                </div>
            </form>

            <p class="text-center text-sm text-gray-500 mt-5">
                <a href="{{ route('auth') }}" class="text-rose-500 font-semibold hover:text-rose-600" data-en="Back to login" data-jp="ログインに戻る">Back to login</a>
            </p>
        </div>
    </div>
    <script>
        const lang = localStorage.getItem('kokoro-lang') || 'en';
        document.querySelectorAll('[data-en][data-jp]').forEach(el => { el.textContent = lang === 'en' ? el.dataset.en : el.dataset.jp; });
        document.querySelectorAll('[data-placeholder-en][data-placeholder-jp]').forEach(el => { el.placeholder = lang === 'en' ? el.dataset.placeholderEn : el.dataset.placeholderJp; });
    </script>
</body>
</html>
