<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Set New Password - KOKORO</title>
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
                <p class="text-gray-500 text-sm mt-2" data-en="Set your new password" data-jp="新しいパスワードを設定">Set your new password</p>
            </div>

            @if($errors->any())
                <div class="bg-red-50 border border-red-200/60 text-red-600 text-xs rounded-lg p-3 mb-4">
                    @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="space-y-3.5">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1" data-en="Email" data-jp="メールアドレス">Email</label>
                        <input type="email" name="email" value="{{ old('email', $email) }}" required
                            class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 focus:ring-2 focus:ring-rose-100 focus:border-rose-400 text-gray-800 text-sm transition"
                            placeholder="your@email.com">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1" data-en="New Password" data-jp="新しいパスワード">New Password</label>
                        <div class="relative">
                            <input type="password" name="password" id="reset-password" required
                                class="w-full px-3.5 py-2.5 pr-10 rounded-lg border border-gray-200 focus:ring-2 focus:ring-rose-100 focus:border-rose-400 text-gray-800 text-sm transition"
                                placeholder="Min 8 characters, mixed case + numbers" data-placeholder-en="Min 8 characters, mixed case + numbers" data-placeholder-jp="8文字以上、大小文字+数字">
                            <button type="button" onclick="togglePassword('reset-password', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition" aria-label="Toggle password visibility">
                                <svg class="w-4 h-4 eye-open" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                <svg class="w-4 h-4 eye-closed hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L6.59 6.59m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>
                            </button>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1" data-en="Confirm New Password" data-jp="新しいパスワード確認">Confirm New Password</label>
                        <div class="relative">
                            <input type="password" name="password_confirmation" id="reset-password-confirm" required
                                class="w-full px-3.5 py-2.5 pr-10 rounded-lg border border-gray-200 focus:ring-2 focus:ring-rose-100 focus:border-rose-400 text-gray-800 text-sm transition"
                                placeholder="Re-enter your password" data-placeholder-en="Re-enter your password" data-placeholder-jp="パスワードを再入力">
                            <button type="button" onclick="togglePassword('reset-password-confirm', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition" aria-label="Toggle password visibility">
                                <svg class="w-4 h-4 eye-open" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                <svg class="w-4 h-4 eye-closed hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L6.59 6.59m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>
                            </button>
                        </div>
                    </div>
                    <button type="submit" class="w-full py-2.5 bg-rose-500 hover:bg-rose-600 text-white font-semibold rounded-lg transition text-sm" data-en="Reset password" data-jp="パスワードをリセット">Reset password</button>
                </div>
            </form>
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
        const lang = localStorage.getItem('kokoro-lang') || 'en';
        document.querySelectorAll('[data-en][data-jp]').forEach(el => { el.textContent = lang === 'en' ? el.dataset.en : el.dataset.jp; });
        document.querySelectorAll('[data-placeholder-en][data-placeholder-jp]').forEach(el => { el.placeholder = lang === 'en' ? el.dataset.placeholderEn : el.dataset.placeholderJp; });
    </script>
</body>
</html>
