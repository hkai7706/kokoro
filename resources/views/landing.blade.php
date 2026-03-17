<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>KOKORO - Find Your Perfect Partner | Japan's Modern Matching Platform</title>
    <meta name="description" content="KOKORO is Japan's premier partner matching platform. Connect with genuine people, build meaningful relationships, and find your perfect match today.">
    <meta name="keywords" content="dating, matching, partner, Japan, relationships, kokoro, love, connection">

    {{-- Favicon --}}
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon-16x16.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/favicon-180x180.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">
    <meta name="theme-color" content="#e11d48">

    {{-- OpenGraph --}}
    <meta property="og:title" content="KOKORO - Find Your Perfect Partner">
    <meta property="og:description" content="Japan's modern partner matching platform. Connect with genuine people.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:image" content="{{ asset('images/og-image.jpg') }}">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="KOKORO - Find Your Perfect Partner">
    <meta name="twitter:description" content="Japan's modern partner matching platform.">

    <link rel="canonical" href="{{ url('/') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:300,400,500,600,700,800" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Plus Jakarta Sans', 'system-ui', 'sans-serif'] }
                }
            }
        }
    </script>
    <style>
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .fade-in { opacity: 0; animation: fadeInUp 0.5s ease-out forwards; }
        .fade-in-d1 { animation-delay: 0.1s; }
        .fade-in-d2 { animation-delay: 0.2s; }
        .fade-in-d3 { animation-delay: 0.3s; }
    </style>
</head>
<body class="font-sans text-gray-800 antialiased bg-white">

    {{-- Navigation --}}
    <header class="fixed top-0 w-full z-50 bg-white/90 backdrop-blur-md border-b border-gray-200/60">
        <nav class="max-w-5xl mx-auto px-4 sm:px-6 flex items-center justify-between h-14">
            <span class="text-lg font-extrabold text-rose-500 tracking-tight">KOKORO</span>
            <div class="hidden md:flex items-center gap-5 text-[13px]">
                <a href="#how-it-works" class="text-gray-500 hover:text-gray-800 transition">How it works</a>
                <a href="#features" class="text-gray-500 hover:text-gray-800 transition">Features</a>
                <a href="#stories" class="text-gray-500 hover:text-gray-800 transition">Stories</a>
            </div>
            <div class="flex items-center gap-3">
                <a href="/auth" class="text-[13px] text-gray-500 hover:text-gray-800 font-medium transition hidden sm:block">Log in</a>
                <a href="/auth" class="bg-rose-500 hover:bg-rose-600 text-white text-[13px] font-semibold px-4 py-2 rounded-lg transition">Get started</a>
            </div>
        </nav>
    </header>

    {{-- Hero --}}
    <section class="pt-14">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 py-20 sm:py-28">
            <div class="max-w-2xl">
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-gray-900 leading-[1.15] fade-in">
                    Real people.<br>Real connections.
                </h1>
                <p class="mt-4 text-base text-gray-500 max-w-md leading-relaxed fade-in fade-in-d1">
                    KOKORO is a matching platform for people in Japan who want something genuine. No games, no algorithms pushing quantity over quality.
                </p>
                <div class="mt-7 flex flex-wrap gap-3 fade-in fade-in-d2">
                    <a href="/auth" class="bg-rose-500 hover:bg-rose-600 text-white font-semibold text-sm px-6 py-3 rounded-lg transition">
                        Create free account
                    </a>
                    <a href="#how-it-works" class="border border-gray-200 text-gray-600 font-medium text-sm px-6 py-3 rounded-lg hover:bg-gray-50 transition">
                        See how it works
                    </a>
                </div>
            </div>

            <div class="mt-14 grid grid-cols-3 gap-6 max-w-sm fade-in fade-in-d3">
                <div>
                    <div class="text-xl font-bold text-gray-900">50K+</div>
                    <div class="text-gray-400 text-xs mt-0.5">Members</div>
                </div>
                <div>
                    <div class="text-xl font-bold text-gray-900">12K+</div>
                    <div class="text-gray-400 text-xs mt-0.5">Matches</div>
                </div>
                <div>
                    <div class="text-xl font-bold text-gray-900">4.8</div>
                    <div class="text-gray-400 text-xs mt-0.5">User rating</div>
                </div>
            </div>
        </div>
    </section>

    {{-- How It Works --}}
    <section id="how-it-works" class="py-16 border-t border-gray-100">
        <div class="max-w-5xl mx-auto px-4 sm:px-6">
            <h2 class="text-xl font-bold text-gray-900 mb-1">How it works</h2>
            <p class="text-sm text-gray-400 mb-10">Three steps. That's it.</p>

            <div class="grid md:grid-cols-3 gap-6">
                <div class="p-5 rounded-xl border border-gray-200/60">
                    <div class="w-8 h-8 bg-rose-50 rounded-lg flex items-center justify-center mb-3">
                        <span class="text-rose-500 text-sm font-bold">1</span>
                    </div>
                    <h3 class="text-sm font-semibold mb-1.5">Create your profile</h3>
                    <p class="text-xs text-gray-400 leading-relaxed">Add your photo, hobbies, and a short bio. Takes about 2 minutes.</p>
                </div>
                <div class="p-5 rounded-xl border border-gray-200/60">
                    <div class="w-8 h-8 bg-amber-50 rounded-lg flex items-center justify-center mb-3">
                        <span class="text-amber-500 text-sm font-bold">2</span>
                    </div>
                    <h3 class="text-sm font-semibold mb-1.5">Browse and like</h3>
                    <p class="text-xs text-gray-400 leading-relaxed">Search by prefecture, age, or interests. Like profiles that catch your eye.</p>
                </div>
                <div class="p-5 rounded-xl border border-gray-200/60">
                    <div class="w-8 h-8 bg-violet-50 rounded-lg flex items-center justify-center mb-3">
                        <span class="text-violet-500 text-sm font-bold">3</span>
                    </div>
                    <h3 class="text-sm font-semibold mb-1.5">Match and talk</h3>
                    <p class="text-xs text-gray-400 leading-relaxed">When you both like each other, you can message directly. No middleman.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Features --}}
    <section id="features" class="py-16 bg-gray-50/60 border-t border-gray-100">
        <div class="max-w-5xl mx-auto px-4 sm:px-6">
            <h2 class="text-xl font-bold text-gray-900 mb-1">Why people choose KOKORO</h2>
            <p class="text-sm text-gray-400 mb-10">Built for genuine connections, not engagement metrics.</p>

            <div class="grid sm:grid-cols-2 gap-5">
                <div class="flex gap-3.5 p-4 bg-white rounded-xl border border-gray-200/60">
                    <div class="w-9 h-9 bg-rose-50 rounded-lg flex items-center justify-center shrink-0 mt-0.5">
                        <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold mb-0.5">Verified profiles</h3>
                        <p class="text-xs text-gray-400 leading-relaxed">Moderation and reporting keep the community real. No bots, no spam.</p>
                    </div>
                </div>
                <div class="flex gap-3.5 p-4 bg-white rounded-xl border border-gray-200/60">
                    <div class="w-9 h-9 bg-emerald-50 rounded-lg flex items-center justify-center shrink-0 mt-0.5">
                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold mb-0.5">All 47 prefectures</h3>
                        <p class="text-xs text-gray-400 leading-relaxed">Find people near you or anywhere in Japan with location-based search.</p>
                    </div>
                </div>
                <div class="flex gap-3.5 p-4 bg-white rounded-xl border border-gray-200/60">
                    <div class="w-9 h-9 bg-violet-50 rounded-lg flex items-center justify-center shrink-0 mt-0.5">
                        <svg class="w-4 h-4 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold mb-0.5">Compatibility scores</h3>
                        <p class="text-xs text-gray-400 leading-relaxed">We compare hobbies, interests, and location to show how well you match.</p>
                    </div>
                </div>
                <div class="flex gap-3.5 p-4 bg-white rounded-xl border border-gray-200/60">
                    <div class="w-9 h-9 bg-amber-50 rounded-lg flex items-center justify-center shrink-0 mt-0.5">
                        <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold mb-0.5">Mutual matching</h3>
                        <p class="text-xs text-gray-400 leading-relaxed">Chat only opens when both people say yes. No unwanted messages.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Testimonials --}}
    <section id="stories" class="py-16 border-t border-gray-100">
        <div class="max-w-5xl mx-auto px-4 sm:px-6">
            <h2 class="text-xl font-bold text-gray-900 mb-1">People who found each other</h2>
            <p class="text-sm text-gray-400 mb-10">Real stories from KOKORO members.</p>

            <div class="grid md:grid-cols-3 gap-5">
                @foreach([
                    ['name' => 'Yuki & Takeshi', 'location' => 'Tokyo', 'text' => 'We matched on KOKORO and instantly connected over our love for hiking. Six months later, we are planning our future together.'],
                    ['name' => 'Sakura & Kenji', 'location' => 'Osaka', 'text' => 'I was skeptical about online matching, but KOKORO felt different. The profiles are genuine, and I found someone truly special.'],
                    ['name' => 'Mika & Hiroshi', 'location' => 'Kyoto', 'text' => 'The prefecture search helped me find someone in my area. We went from chat to our first date in just one week.'],
                ] as $story)
                <div class="p-5 rounded-xl border border-gray-200/60">
                    <p class="text-sm text-gray-500 leading-relaxed mb-4">"{{ $story['text'] }}"</p>
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 bg-rose-50 rounded-full flex items-center justify-center text-rose-500 text-xs font-bold">
                            {{ substr($story['name'], 0, 1) }}
                        </div>
                        <div>
                            <div class="text-xs font-semibold text-gray-700">{{ $story['name'] }}</div>
                            <div class="text-[11px] text-gray-400">{{ $story['location'] }}</div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="py-16 bg-gray-50 border-t border-gray-100">
        <div class="max-w-xl mx-auto px-4 text-center">
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Ready to meet someone?</h2>
            <p class="text-sm text-gray-400 mb-6">Creating an account takes less than a minute. Free to join.</p>
            <a href="/auth" class="inline-block bg-rose-500 hover:bg-rose-600 text-white font-semibold text-sm px-8 py-3 rounded-lg transition">
                Get started free
            </a>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="bg-gray-900 text-gray-400 py-10">
        <div class="max-w-5xl mx-auto px-4 sm:px-6">
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <div>
                    <span class="text-base font-bold text-white">KOKORO</span>
                    <p class="mt-2 text-xs leading-relaxed">Connecting hearts across Japan since 2024.</p>
                </div>
                <div>
                    <h4 class="text-white text-xs font-semibold mb-2.5">Platform</h4>
                    <ul class="space-y-1.5 text-xs">
                        <li><a href="#how-it-works" class="hover:text-white transition">How it works</a></li>
                        <li><a href="#features" class="hover:text-white transition">Features</a></li>
                        <li><a href="#stories" class="hover:text-white transition">Stories</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white text-xs font-semibold mb-2.5">Legal</h4>
                    <ul class="space-y-1.5 text-xs">
                        <li><a href="#" class="hover:text-white transition">Privacy Policy</a></li>
                        <li><a href="#" class="hover:text-white transition">Terms of Service</a></li>
                        <li><a href="#" class="hover:text-white transition">Community Guidelines</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white text-xs font-semibold mb-2.5">Support</h4>
                    <ul class="space-y-1.5 text-xs">
                        <li><a href="#" class="hover:text-white transition">Help Center</a></li>
                        <li><a href="#" class="hover:text-white transition">Contact Us</a></li>
                        <li><a href="#" class="hover:text-white transition">Safety Tips</a></li>
                    </ul>
                </div>
            </div>
            <div class="mt-8 pt-5 border-t border-gray-800 text-center text-[11px]">
                &copy; {{ date('Y') }} KOKORO. All rights reserved.
            </div>
        </div>
    </footer>

    {{-- Cookie Consent --}}
    <div id="cookie-consent" class="fixed bottom-0 left-0 right-0 bg-gray-900/95 backdrop-blur-md text-white p-3 z-50" style="display:none;">
        <div class="max-w-5xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-3">
            <p class="text-xs text-gray-300">We use cookies to improve your experience. By continuing, you agree to our cookie policy.</p>
            <div class="flex gap-2 shrink-0">
                <button onclick="declineCookies()" class="text-xs px-3 py-1.5 border border-gray-600 rounded-lg hover:bg-gray-800 transition">Decline</button>
                <button onclick="acceptCookies()" class="text-xs px-4 py-1.5 bg-rose-500 rounded-lg font-semibold hover:bg-rose-600 transition">Accept</button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (!localStorage.getItem('kokoro_cookies')) {
                document.getElementById('cookie-consent').style.display = 'block';
            }
        });
        function acceptCookies() {
            localStorage.setItem('kokoro_cookies', 'accepted');
            document.getElementById('cookie-consent').style.display = 'none';
        }
        function declineCookies() {
            localStorage.setItem('kokoro_cookies', 'declined');
            document.getElementById('cookie-consent').style.display = 'none';
        }

        document.querySelectorAll('a[href^="#"]').forEach(a => {
            a.addEventListener('click', function(e) {
                e.preventDefault();
                const el = document.querySelector(this.getAttribute('href'));
                if (el) el.scrollIntoView({ behavior: 'smooth' });
            });
        });
    </script>
</body>
</html>
