<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Page Not Found - KOKORO</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon-32x32.png') }}">
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
    <div class="text-center max-w-md">
        <div class="mb-6">
            <span class="text-6xl font-extrabold text-rose-500">404</span>
        </div>
        <h1 class="text-xl font-bold text-gray-800 mb-2" data-en="Page not found" data-jp="ページが見つかりません">Page not found</h1>
        <p class="text-sm text-gray-600 mb-6" data-en="The page you're looking for doesn't exist or has been moved." data-jp="お探しのページは存在しないか、移動されました。">The page you're looking for doesn't exist or has been moved.</p>
        <div class="flex items-center justify-center gap-3">
            <a href="/" class="inline-flex items-center px-4 py-2.5 bg-rose-500 hover:bg-rose-600 text-white font-semibold rounded-lg transition text-sm" data-en="Go home" data-jp="ホームへ">Go home</a>
            <a href="/auth" class="inline-flex items-center px-4 py-2.5 border border-gray-200 text-gray-600 hover:bg-gray-100 font-semibold rounded-lg transition text-sm" data-en="Log in" data-jp="ログイン">Log in</a>
        </div>
        <div class="mt-8">
            <span class="text-lg font-extrabold text-rose-500 tracking-tight">KOKORO</span>
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
