<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>KOKORO - Find Your Perfect Partner | Japan's Modern Matching Platform</title>
    <meta name="description" content="KOKORO is Japan's premier partner matching platform. Connect with genuine people, build meaningful relationships, and find your perfect match today.">
    <meta name="keywords" content="dating, matching, partner, Japan, relationships, kokoro, love, connection">

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
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        .fade-in { opacity: 0; animation: fadeInUp 0.7s ease-out forwards; }
        .fade-in-d1 { animation-delay: 0.15s; }
        .fade-in-d2 { animation-delay: 0.3s; }
        .fade-in-d3 { animation-delay: 0.45s; }
    </style>
</head>
<body class="font-sans text-gray-800 antialiased bg-white">

    {{-- Navigation --}}
    <header class="fixed top-0 w-full z-50 bg-white/90 backdrop-blur-md border-b border-gray-100">
        <nav class="max-w-6xl mx-auto px-4 sm:px-6 flex items-center justify-between h-14">
            <span class="text-xl font-bold text-rose-500 tracking-tight">KOKORO</span>
            <div class="hidden md:flex items-center gap-6 text-sm">
                <a href="#how-it-works" class="text-gray-500 hover:text-gray-800 transition">How it Works</a>
                <a href="#features" class="text-gray-500 hover:text-gray-800 transition">Features</a>
                <a href="#testimonials" class="text-gray-500 hover:text-gray-800 transition">Stories</a>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="/auth" class="text-sm text-gray-500 hover:text-gray-800 transition hidden sm:block">Log in</a>
                <a href="/auth" class="bg-rose-500 hover:bg-rose-600 text-white text-sm font-semibold px-5 py-2 rounded-lg transition">Get Started</a>
            </div>
        </nav>
    </header>

    {{-- Hero Section --}}
    <section class="min-h-screen flex items-center pt-14 bg-gradient-to-b from-rose-50/50 to-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-20">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <div class="text-center lg:text-left">
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-gray-900 leading-tight fade-in">
                        Find Your<br>Perfect Match
                    </h1>
                    <p class="mt-5 text-lg text-gray-500 max-w-lg mx-auto lg:mx-0 fade-in fade-in-d1">
                        KOKORO connects hearts across Japan. Discover meaningful connections with people who share your values, interests, and dreams.
                    </p>
                    <div class="mt-8 flex flex-col sm:flex-row gap-3 justify-center lg:justify-start fade-in fade-in-d2">
                        <a href="/auth" class="bg-rose-500 hover:bg-rose-600 text-white font-semibold text-base px-8 py-3.5 rounded-xl transition text-center shadow-sm">
                            Start Matching
                        </a>
                        <a href="#how-it-works" class="border border-gray-200 text-gray-600 font-semibold text-base px-8 py-3.5 rounded-xl hover:bg-gray-50 transition text-center">
                            Learn More
                        </a>
                    </div>
                    <div class="mt-10 flex items-center gap-8 justify-center lg:justify-start fade-in fade-in-d3">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-gray-900">50K+</div>
                            <div class="text-gray-400 text-xs">Active Users</div>
                        </div>
                        <div class="w-px h-10 bg-gray-200"></div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-gray-900">12K+</div>
                            <div class="text-gray-400 text-xs">Matches Made</div>
                        </div>
                        <div class="w-px h-10 bg-gray-200"></div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-gray-900">98%</div>
                            <div class="text-gray-400 text-xs">Satisfaction</div>
                        </div>
                    </div>
                </div>
                <div class="hidden lg:flex justify-center">
                    <div class="relative">
                        <div class="w-72 h-[420px] bg-white rounded-2xl p-5 shadow-lg border border-gray-100">
                            <div class="w-full h-52 bg-gradient-to-br from-rose-100 to-rose-200 rounded-xl mb-4"></div>
                            <div class="h-4 bg-gray-100 rounded-full w-3/4 mb-2"></div>
                            <div class="h-3 bg-gray-100 rounded-full w-1/2 mb-4"></div>
                            <div class="h-3 bg-gray-50 rounded-full w-full mb-2"></div>
                            <div class="h-3 bg-gray-50 rounded-full w-5/6 mb-5"></div>
                            <div class="flex gap-2.5">
                                <div class="flex-1 h-9 bg-rose-500 rounded-lg"></div>
                                <div class="flex-1 h-9 bg-gray-100 rounded-lg"></div>
                            </div>
                        </div>
                        <div class="absolute -top-3 -right-3 w-14 h-14 bg-rose-500 rounded-xl flex items-center justify-center shadow-md">
                            <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- How It Works --}}
    <section id="how-it-works" class="py-20 bg-white">
        <div class="max-w-5xl mx-auto px-4 sm:px-6">
            <div class="text-center mb-14">
                <h2 class="text-3xl font-bold text-gray-900">How KOKORO Works</h2>
                <p class="mt-2.5 text-gray-400">Three simple steps to finding your perfect match</p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <article class="text-center p-6 rounded-xl border border-gray-100 hover:border-rose-200 hover:shadow-sm transition-all">
                    <div class="w-12 h-12 bg-rose-50 rounded-xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    <div class="text-xs font-semibold text-rose-500 mb-1.5">STEP 1</div>
                    <h3 class="text-base font-bold mb-2">Create Your Profile</h3>
                    <p class="text-sm text-gray-400">Sign up, add your photos, interests, and tell others what makes you unique.</p>
                </article>
                <article class="text-center p-6 rounded-xl border border-gray-100 hover:border-amber-200 hover:shadow-sm transition-all">
                    <div class="w-12 h-12 bg-amber-50 rounded-xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    </div>
                    <div class="text-xs font-semibold text-amber-500 mb-1.5">STEP 2</div>
                    <h3 class="text-base font-bold mb-2">Discover & Like</h3>
                    <p class="text-sm text-gray-400">Browse profiles, like people you connect with, and see who likes you back.</p>
                </article>
                <article class="text-center p-6 rounded-xl border border-gray-100 hover:border-violet-200 hover:shadow-sm transition-all">
                    <div class="w-12 h-12 bg-violet-50 rounded-xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                    </div>
                    <div class="text-xs font-semibold text-violet-500 mb-1.5">STEP 3</div>
                    <h3 class="text-base font-bold mb-2">Match & Chat</h3>
                    <p class="text-sm text-gray-400">When both of you like each other, it's a match! Start chatting and build something real.</p>
                </article>
            </div>
        </div>
    </section>

    {{-- Features --}}
    <section id="features" class="py-20 bg-gray-50/50">
        <div class="max-w-5xl mx-auto px-4 sm:px-6">
            <div class="text-center mb-14">
                <h2 class="text-3xl font-bold text-gray-900">Why Choose KOKORO</h2>
                <p class="mt-2.5 text-gray-400">Built for genuine connections, not just swipes</p>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach([
                    ['icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', 'title' => 'Safe & Secure', 'desc' => 'Advanced verification and moderation keeps our community safe and genuine.'],
                    ['icon' => 'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z', 'title' => 'Location Based', 'desc' => 'Find matches near you with prefecture-based search across all 47 prefectures.'],
                    ['icon' => 'M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z', 'title' => 'Mobile Friendly', 'desc' => 'Beautiful responsive design works perfectly on any device, anywhere.'],
                    ['icon' => 'M13 10V3L4 14h7v7l9-11h-7z', 'title' => 'Instant Matching', 'desc' => 'Mutual likes create instant matches so you can start chatting right away.'],
                    ['icon' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z', 'title' => 'Rich Profiles', 'desc' => 'Hobbies, interests, and bios help you find true compatibility.'],
                    ['icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', 'title' => '24/7 Support', 'desc' => 'Our dedicated team is always available to help with any questions.'],
                ] as $feature)
                <div class="bg-white p-5 rounded-xl border border-gray-100 hover:shadow-sm transition-all">
                    <div class="w-10 h-10 bg-rose-50 rounded-lg flex items-center justify-center mb-3">
                        <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $feature['icon'] }}"/></svg>
                    </div>
                    <h3 class="text-sm font-bold mb-1">{{ $feature['title'] }}</h3>
                    <p class="text-xs text-gray-400 leading-relaxed">{{ $feature['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Testimonials --}}
    <section id="testimonials" class="py-20 bg-white">
        <div class="max-w-5xl mx-auto px-4 sm:px-6">
            <div class="text-center mb-14">
                <h2 class="text-3xl font-bold text-gray-900">Love Stories</h2>
                <p class="mt-2.5 text-gray-400">Real people, real connections</p>
            </div>
            <div class="grid md:grid-cols-3 gap-6">
                @foreach([
                    ['name' => 'Yuki & Takeshi', 'location' => 'Tokyo', 'text' => 'We matched on KOKORO and instantly connected over our love for hiking. Six months later, we are planning our future together!', 'rating' => 5],
                    ['name' => 'Sakura & Kenji', 'location' => 'Osaka', 'text' => 'I was skeptical about online matching, but KOKORO felt different. The profiles are genuine, and I found someone truly special.', 'rating' => 5],
                    ['name' => 'Mika & Hiroshi', 'location' => 'Kyoto', 'text' => 'The prefecture search helped me find someone in my area. We went from chat to our first date in just one week!', 'rating' => 5],
                ] as $testimonial)
                <article class="p-5 rounded-xl border border-gray-100">
                    <div class="flex gap-0.5 mb-3">
                        @for($i = 0; $i < $testimonial['rating']; $i++)
                            <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        @endfor
                    </div>
                    <p class="text-sm text-gray-500 italic mb-4 leading-relaxed">"{{ $testimonial['text'] }}"</p>
                    <div class="flex items-center gap-2.5">
                        <div class="w-9 h-9 bg-rose-100 rounded-full flex items-center justify-center text-rose-500 text-sm font-bold">
                            {{ substr($testimonial['name'], 0, 1) }}
                        </div>
                        <div>
                            <div class="text-sm font-semibold">{{ $testimonial['name'] }}</div>
                            <div class="text-xs text-gray-400">{{ $testimonial['location'] }}</div>
                        </div>
                    </div>
                </article>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CTA Section --}}
    <section class="py-20 bg-rose-50">
        <div class="max-w-3xl mx-auto px-4 text-center">
            <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">Ready to Find Your Match?</h2>
            <p class="text-gray-500 mb-8 max-w-xl mx-auto">Join thousands of people who have already found meaningful connections on KOKORO.</p>
            <a href="/auth" class="inline-block bg-rose-500 hover:bg-rose-600 text-white font-semibold px-10 py-3.5 rounded-xl transition shadow-sm">
                Start Matching Now
            </a>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="bg-gray-900 text-gray-400 py-12">
        <div class="max-w-5xl mx-auto px-4 sm:px-6">
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <div>
                    <span class="text-lg font-bold text-white">KOKORO</span>
                    <p class="mt-3 text-xs leading-relaxed">Connecting hearts across Japan since 2024. Find your perfect match today.</p>
                </div>
                <div>
                    <h4 class="text-white text-sm font-semibold mb-3">Platform</h4>
                    <ul class="space-y-1.5 text-xs">
                        <li><a href="#how-it-works" class="hover:text-white transition">How it Works</a></li>
                        <li><a href="#features" class="hover:text-white transition">Features</a></li>
                        <li><a href="#testimonials" class="hover:text-white transition">Success Stories</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white text-sm font-semibold mb-3">Legal</h4>
                    <ul class="space-y-1.5 text-xs">
                        <li><a href="#" class="hover:text-white transition">Privacy Policy</a></li>
                        <li><a href="#" class="hover:text-white transition">Terms of Service</a></li>
                        <li><a href="#" class="hover:text-white transition">Cookie Policy</a></li>
                        <li><a href="#" class="hover:text-white transition">Community Guidelines</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white text-sm font-semibold mb-3">Support</h4>
                    <ul class="space-y-1.5 text-xs">
                        <li><a href="#" class="hover:text-white transition">Help Center</a></li>
                        <li><a href="#" class="hover:text-white transition">Contact Us</a></li>
                        <li><a href="#" class="hover:text-white transition">Safety Tips</a></li>
                    </ul>
                </div>
            </div>
            <div class="mt-10 pt-6 border-t border-gray-800 text-center text-xs">
                &copy; {{ date('Y') }} KOKORO. All rights reserved.
            </div>
        </div>
    </footer>

    {{-- Cookie Consent Banner --}}
    <div id="cookie-consent" class="fixed bottom-0 left-0 right-0 bg-gray-900/95 backdrop-blur-md text-white p-3.5 z-50" style="display:none;">
        <div class="max-w-5xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-3">
            <p class="text-xs text-gray-300">We use cookies to improve your experience. By continuing to use KOKORO, you agree to our cookie policy.</p>
            <div class="flex gap-2 shrink-0">
                <button onclick="declineCookies()" class="text-xs px-3.5 py-1.5 border border-gray-600 rounded-lg hover:bg-gray-800 transition">Decline</button>
                <button onclick="acceptCookies()" class="text-xs px-5 py-1.5 bg-rose-500 rounded-lg font-semibold hover:bg-rose-600 transition">Accept</button>
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
