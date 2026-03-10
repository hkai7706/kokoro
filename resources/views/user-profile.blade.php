@extends('layouts.app')
@section('title', $user->name . ' - KOKORO')

@section('content')
<div class="max-w-2xl mx-auto">
    <a href="{{ url()->previous() }}" class="inline-flex items-center text-gray-400 hover:text-gray-600 mb-6 transition">
        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Back
    </a>

    <div class="bg-white rounded-3xl shadow-xl overflow-hidden animate-fade-in-up">
        {{-- Photo --}}
        <div class="h-80 bg-gradient-to-br from-pink-100 to-purple-100 relative">
            @if($user->profile && $user->profile->profile_photo)
                <img src="{{ asset('storage/' . $user->profile->profile_photo) }}" class="w-full h-full object-cover">
            @else
                <div class="w-full h-full flex items-center justify-center">
                    <svg class="w-32 h-32 text-pink-300" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                </div>
            @endif
            @if($isMatched)
                <div class="absolute top-4 left-4 bg-green-500 text-white font-bold px-4 py-1.5 rounded-full text-sm shadow">Matched!</div>
            @endif
            {{-- Compatibility score --}}
            @php $compat = auth()->user()->compatibilityWith($user); @endphp
            @if($compat > 0)
                <div class="absolute top-4 right-4 bg-white/90 backdrop-blur font-bold px-4 py-1.5 rounded-full text-sm shadow {{ $compat >= 60 ? 'text-green-600' : ($compat >= 30 ? 'text-yellow-600' : 'text-gray-500') }}">
                    {{ $compat }}% compatible
                </div>
            @endif
        </div>

        <div class="p-8">
            <div class="flex items-center justify-between mb-4">
                <h1 class="text-2xl font-extrabold">
                    {{ $user->name }}
                    @if($user->profile)
                        <span class="text-gray-400 font-normal">, {{ $user->profile->age }}</span>
                    @endif
                </h1>
                {{-- More menu (Block/Report) --}}
                <div class="relative">
                    <button onclick="this.nextElementSibling.classList.toggle('hidden')" class="text-gray-400 hover:text-gray-600 p-2 rounded-full hover:bg-gray-100 transition">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/></svg>
                    </button>
                    <div class="hidden absolute right-0 mt-1 w-48 bg-white rounded-xl shadow-xl border border-gray-100 py-2 z-50">
                        @if(auth()->user()->hasBlocked($user->id))
                            <form method="POST" action="{{ route('user.unblock') }}">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-green-600 hover:bg-green-50">Unblock User</button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('user.block') }}">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-500 hover:bg-red-50" onclick="return confirm('Block this user? This will also remove any likes and matches.')">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                                    Block User
                                </button>
                            </form>
                        @endif
                        <button onclick="document.getElementById('report-modal').classList.remove('hidden')" class="block w-full text-left px-4 py-2 text-sm text-orange-500 hover:bg-orange-50">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                            Report User
                        </button>
                    </div>
                </div>
            </div>

            @if($user->profile)
                <p class="text-gray-500 mb-4">
                    <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                    {{ $user->profile->location }}{{ $user->profile->prefecture ? ', ' . $user->profile->prefecture : '' }}
                    &middot; {{ ucfirst($user->profile->gender) }}
                </p>

                @if($user->profile->bio)
                    <div class="mb-6">
                        <h3 class="text-sm font-semibold text-gray-400 uppercase mb-2">About</h3>
                        <p class="text-gray-600 leading-relaxed">{{ $user->profile->bio }}</p>
                    </div>
                @endif

                @if($user->profile->hobbies)
                    <div class="mb-4">
                        <h3 class="text-sm font-semibold text-gray-400 uppercase mb-2">Hobbies</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($user->profile->hobbies_array as $hobby)
                                <span class="bg-pink-50 text-pink-600 px-3 py-1.5 rounded-full text-sm font-medium">{{ $hobby }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if($user->profile->interests)
                    <div class="mb-6">
                        <h3 class="text-sm font-semibold text-gray-400 uppercase mb-2">Interests</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($user->profile->interests_array as $interest)
                                <span class="bg-purple-50 text-purple-600 px-3 py-1.5 rounded-full text-sm font-medium">{{ $interest }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Compatibility breakdown --}}
                @if($compat > 0)
                    <div class="mb-6 p-4 rounded-xl bg-gradient-to-r {{ $compat >= 60 ? 'from-green-50 to-emerald-50 border border-green-100' : ($compat >= 30 ? 'from-yellow-50 to-amber-50 border border-yellow-100' : 'from-gray-50 to-slate-50 border border-gray-100') }}">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-sm font-semibold text-gray-600">Compatibility Score</h3>
                            <span class="text-lg font-bold {{ $compat >= 60 ? 'text-green-600' : ($compat >= 30 ? 'text-yellow-600' : 'text-gray-500') }}">{{ $compat }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="h-2 rounded-full transition-all {{ $compat >= 60 ? 'bg-green-500' : ($compat >= 30 ? 'bg-yellow-500' : 'bg-gray-400') }}" style="width: {{ $compat }}%"></div>
                        </div>
                    </div>
                @endif
            @endif

            {{-- Actions --}}
            @if(!auth()->user()->hasBlocked($user->id))
                <div class="flex gap-3 pt-4 border-t border-gray-100">
                    @if(!$hasLiked)
                        <form method="POST" action="{{ route('match.like') }}" class="flex-1">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                            <button type="submit" class="w-full btn-primary py-3 text-lg">
                                <svg class="w-5 h-5 inline mr-1" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                                Like
                            </button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('match.unlike') }}" class="flex-1">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                            <button type="submit" class="w-full bg-red-100 hover:bg-red-200 text-red-500 font-semibold py-3 rounded-full text-lg transition">Unlike</button>
                        </form>
                    @endif

                    @if($isMatched)
                        <a href="{{ route('messages.conversation', $user->id) }}" class="flex-1 text-center btn-secondary py-3 text-lg">
                            Message
                        </a>
                    @endif
                </div>
            @else
                <div class="pt-4 border-t border-gray-100 text-center">
                    <p class="text-gray-400 text-sm mb-3">You have blocked this user.</p>
                    <form method="POST" action="{{ route('user.unblock') }}">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                        <button type="submit" class="btn-secondary py-2 px-6 text-sm">Unblock</button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>

{{-- Report Modal --}}
<div id="report-modal" class="hidden fixed inset-0 z-[60] flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/50" onclick="document.getElementById('report-modal').classList.add('hidden')"></div>
    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md p-6 animate-fade-in-up">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Report {{ $user->name }}</h3>
        <form method="POST" action="{{ route('user.report') }}">
            @csrf
            <input type="hidden" name="user_id" value="{{ $user->id }}">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-600 mb-2">Reason for report</label>
                <select name="reason" required class="w-full px-3 py-2.5 rounded-lg border border-gray-200 text-sm focus:ring-primary focus:border-primary mb-3">
                    <option value="">Select a reason...</option>
                    <option value="Fake profile">Fake profile</option>
                    <option value="Inappropriate content">Inappropriate content</option>
                    <option value="Harassment">Harassment</option>
                    <option value="Spam">Spam</option>
                    <option value="Underage user">Underage user</option>
                    <option value="Other">Other</option>
                </select>
                <textarea name="details" rows="3" class="w-full px-3 py-2.5 rounded-lg border border-gray-200 text-sm focus:ring-primary focus:border-primary" placeholder="Additional details (optional)..."></textarea>
            </div>
            <div class="flex gap-3">
                <button type="button" onclick="document.getElementById('report-modal').classList.add('hidden')" class="flex-1 py-2.5 border border-gray-200 rounded-full text-sm font-medium text-gray-500 hover:bg-gray-50 transition">Cancel</button>
                <button type="submit" class="flex-1 py-2.5 bg-red-500 hover:bg-red-600 text-white rounded-full text-sm font-semibold transition">Submit Report</button>
            </div>
        </form>
    </div>
</div>
@endsection
