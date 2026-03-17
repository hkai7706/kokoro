<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Verify Email - KOKORO</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: { extend: { fontFamily: { sans: ['Plus Jakarta Sans', 'system-ui', 'sans-serif'] } } }
        }
    </script>
</head>
<body class="font-sans bg-gray-50 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-sm">
        <div class="bg-white rounded-xl border border-gray-200 p-6 text-center">
            <div class="mb-4">
                <span class="text-xl font-extrabold text-rose-500 tracking-tight">KOKORO</span>
            </div>
            <div class="w-16 h-16 bg-rose-50 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            </div>
            <h1 class="text-lg font-bold text-gray-800 mb-2" data-en="Verify your email" data-jp="メールを確認してください">Verify your email</h1>
            <p class="text-sm text-gray-400 mb-5" data-en="We've sent a verification link to your email. Please check your inbox and click the link to verify." data-jp="確認リンクをメールに送信しました。受信箱を確認し、リンクをクリックして確認してください。">We've sent a verification link to your email. Please check your inbox and click the link to verify.</p>

            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-100 text-emerald-600 text-xs rounded-lg p-3 mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="w-full py-2.5 bg-rose-500 hover:bg-rose-600 text-white font-semibold rounded-lg transition text-sm mb-3" data-en="Resend verification email" data-jp="確認メールを再送信">Resend verification email</button>
            </form>

            <a href="{{ route('home') }}" class="text-sm text-gray-400 hover:text-gray-500 transition" data-en="Skip for now" data-jp="後で確認する">Skip for now</a>
        </div>
    </div>
    <script>
        const lang = localStorage.getItem('kokoro-lang') || 'en';
        document.querySelectorAll('[data-en][data-jp]').forEach(el => {
            el.textContent = lang === 'en' ? el.dataset.en : el.dataset.jp;
        });
    </script>
</body>
</html>
