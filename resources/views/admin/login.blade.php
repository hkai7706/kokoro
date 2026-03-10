<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Login - KOKORO</title>
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { theme: { extend: {
            colors: { primary: '#FF4D6D', kokoro: { yellow: '#FFD700', pink: '#FF69B4' } },
            fontFamily: { sans: ['Plus Jakarta Sans', 'system-ui', 'sans-serif'] }
        }}}
    </script>
</head>
<body class="font-sans bg-gray-900 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="bg-gray-800 rounded-3xl shadow-2xl p-8 sm:p-10 border border-gray-700">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-extrabold text-kokoro-pink tracking-wider">K&#9734;K&#9734;R&#9734;</h1>
                <p class="text-gray-400 font-medium mt-2">Admin Panel</p>
            </div>

            @if($errors->any())
                <div class="bg-red-900/30 border border-red-800 text-red-400 text-sm rounded-xl p-3 mb-4">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-900/30 border border-red-800 text-red-400 text-sm rounded-xl p-3 mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.post') }}">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-300 mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            class="w-full px-4 py-3 rounded-xl bg-gray-700 border border-gray-600 text-white focus:ring-2 focus:ring-primary focus:border-primary transition placeholder-gray-500"
                            placeholder="admin@kokoro.app">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-300 mb-1">Password</label>
                        <input type="password" name="password" required
                            class="w-full px-4 py-3 rounded-xl bg-gray-700 border border-gray-600 text-white focus:ring-2 focus:ring-primary focus:border-primary transition placeholder-gray-500"
                            placeholder="Enter password">
                    </div>
                    <button type="submit"
                        class="w-full py-3.5 bg-primary hover:bg-pink-600 text-white font-bold rounded-full shadow-lg hover:shadow-xl transition-all text-lg">
                        Sign In
                    </button>
                </div>
            </form>
        </div>
        <div class="text-center mt-4">
            <a href="/" class="text-gray-500 hover:text-gray-400 text-sm">&larr; Back to KOKORO</a>
        </div>
    </div>
</body>
</html>
