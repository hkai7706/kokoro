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
            theme: {
                extend: {
                    colors: {
                        primary: '#FF4D6D',
                        kokoro: { yellow: '#FFD700', pink: '#FF69B4', orange: '#FFA043' }
                    },
                    fontFamily: { sans: ['Plus Jakarta Sans', 'system-ui', 'sans-serif'] }
                }
            }
        }
    </script>
    <style>
        .auth-gradient { background: linear-gradient(135deg, #FFB347 0%, #FFA043 50%, #FFB860 100%); }
        @keyframes fadeIn { from { opacity:0; transform: translateY(10px); } to { opacity:1; transform: translateY(0); } }
        .animate-fade { animation: fadeIn 0.4s ease-out; }
    </style>
</head>
<body class="font-sans bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md">
        {{-- Login Form --}}
        <div id="login-form" class="animate-fade">
            <div class="auth-gradient rounded-3xl shadow-2xl p-8 sm:p-10">
                {{-- Logo --}}
                <div class="text-center mb-8">
                    <h1 class="text-4xl font-extrabold tracking-wider" style="color: #FF69B4; text-shadow: 2px 2px 0px rgba(255,255,255,0.3);">
                        K&#9734;K&#9734;R&#9734;
                    </h1>
                    <p class="text-white/80 font-medium mt-2">LOG IN</p>
                </div>

                @if($errors->any() && !old('is_register'))
                    <div class="bg-red-50 border border-red-200 text-red-600 text-sm rounded-xl p-3 mb-4">
                        @foreach($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" autocomplete="off">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-1">Email address</label>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                autocomplete="new-email"
                                class="w-full px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-pink-400 text-gray-800 shadow-sm"
                                placeholder="your@email.com">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-1">Password</label>
                            <input type="password" name="password" required
                                autocomplete="new-password"
                                class="w-full px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-pink-400 text-gray-800 shadow-sm"
                                placeholder="Enter your password">
                        </div>

                        <div class="flex items-center gap-2">
                            <input type="checkbox" name="remember" id="remember" class="rounded border-gray-300 text-primary focus:ring-primary">
                            <label for="remember" class="text-sm text-gray-700">Remember me</label>
                        </div>

                        <p class="text-center text-sm text-gray-700">
                            Don't have an account?
                            <button type="button" onclick="toggleForm()" class="text-pink-700 font-bold hover:underline">Sign up</button>
                        </p>

                        <button type="submit"
                            class="w-full py-3.5 bg-kokoro-yellow hover:bg-yellow-400 text-gray-800 font-bold rounded-full shadow-lg hover:shadow-xl transition-all duration-200 text-lg">
                            Log in
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Register Form --}}
        <div id="register-form" class="hidden animate-fade">
            <div class="auth-gradient rounded-3xl shadow-2xl p-8 sm:p-10">
                <div class="text-center mb-8">
                    <h1 class="text-4xl font-extrabold tracking-wider" style="color: #FF69B4; text-shadow: 2px 2px 0px rgba(255,255,255,0.3);">
                        K&#9734;K&#9734;R&#9734;
                    </h1>
                    <p class="text-white/80 font-medium mt-2">Sign up</p>
                </div>

                @if($errors->any() && old('is_register'))
                    <div class="bg-red-50 border border-red-200 text-red-600 text-sm rounded-xl p-3 mb-4">
                        @foreach($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" autocomplete="off">
                    @csrf
                    <input type="hidden" name="is_register" value="1">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-1">Name</label>
                            <input type="text" name="name" value="{{ old('name') }}" required
                                autocomplete="off"
                                class="w-full px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-pink-400 text-gray-800 shadow-sm"
                                placeholder="Your name">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-1">Email address</label>
                            <input type="email" name="email" value="{{ old('is_register') ? old('email') : '' }}" required
                                autocomplete="new-email"
                                class="w-full px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-pink-400 text-gray-800 shadow-sm"
                                placeholder="your@email.com">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-1">Password</label>
                            <input type="password" name="password" required
                                autocomplete="new-password"
                                class="w-full px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-pink-400 text-gray-800 shadow-sm"
                                placeholder="Minimum 8 characters">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-1">Confirm Password</label>
                            <input type="password" name="password_confirmation" required
                                autocomplete="new-password"
                                class="w-full px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-pink-400 text-gray-800 shadow-sm"
                                placeholder="Confirm your password">
                        </div>

                        <p class="text-center text-sm text-gray-700">
                            Already have account?
                            <button type="button" onclick="toggleForm()" class="text-pink-700 font-bold hover:underline">Log in</button>
                        </p>

                        <button type="submit"
                            class="w-full py-3.5 bg-kokoro-yellow hover:bg-yellow-400 text-gray-800 font-bold rounded-full shadow-lg hover:shadow-xl transition-all duration-200 text-lg">
                            Sign up
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="text-center mt-6">
            <a href="/" class="text-gray-400 hover:text-gray-600 text-sm transition">
                &larr; Back to KOKORO
            </a>
        </div>
    </div>

    <script>
        function toggleForm() {
            document.getElementById('login-form').classList.toggle('hidden');
            document.getElementById('register-form').classList.toggle('hidden');
        }
        // Show register form if there were registration errors
        @if(old('is_register'))
            toggleForm();
        @endif
    </script>
</body>
</html>
