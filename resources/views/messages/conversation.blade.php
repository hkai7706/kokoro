@extends('layouts.app')
@section('title', 'Chat with ' . $partner->name . ' - KOKORO')

@section('content')
<div class="max-w-3xl mx-auto flex flex-col" style="height: calc(100vh - 10rem);">
    {{-- Chat Header --}}
    <div class="bg-white rounded-t-2xl border border-gray-100 p-4 flex items-center gap-4 shadow-sm">
        <a href="{{ route('messages.inbox') }}" class="text-gray-400 hover:text-gray-600 transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-pink-100 to-purple-100 overflow-hidden border-2 border-kokoro-yellow">
            @if($partner->profile && $partner->profile->profile_photo)
                <img src="{{ asset('storage/' . $partner->profile->profile_photo) }}" class="w-full h-full object-cover">
            @else
                <div class="w-full h-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-pink-300" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                </div>
            @endif
        </div>
        <div class="flex-1">
            <h2 class="font-bold text-gray-800">{{ $partner->name }}</h2>
            @if($partner->profile && $partner->profile->last_active_at)
                <p class="text-xs text-gray-400">
                    @if($partner->profile->last_active_at->diffInMinutes(now()) < 30)
                        <span class="text-green-500">Online now</span>
                    @else
                        Last seen {{ $partner->profile->last_active_at->diffForHumans() }}
                    @endif
                </p>
            @endif
        </div>
        <a href="{{ route('user.profile', $partner->id) }}" class="text-gray-400 hover:text-primary transition text-sm font-medium">View Profile</a>
        {{-- More menu --}}
        <div class="relative">
            <button onclick="this.nextElementSibling.classList.toggle('hidden')" class="text-gray-400 hover:text-gray-600 p-1.5 rounded-full hover:bg-gray-100 transition">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/></svg>
            </button>
            <div class="hidden absolute right-0 mt-1 w-48 bg-white rounded-xl shadow-xl border border-gray-100 py-2 z-50">
                <form method="POST" action="{{ route('user.block') }}">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $partner->id }}">
                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-500 hover:bg-red-50" onclick="return confirm('Block this user? This will remove your match and you won\'t be able to message them.')">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                        Block User
                    </button>
                </form>
                <button onclick="document.getElementById('report-modal-chat').classList.remove('hidden')" class="block w-full text-left px-4 py-2 text-sm text-orange-500 hover:bg-orange-50">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                    Report User
                </button>
            </div>
        </div>
    </div>

    {{-- Messages --}}
    <div id="chat-messages" class="flex-1 overflow-y-auto bg-gray-50 p-4 space-y-3 border-x border-gray-100">
        @forelse($messages as $msg)
            <div class="flex {{ $msg->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }} animate-fade-in-up">
                <div class="max-w-[75%] {{ $msg->sender_id === auth()->id() ? 'bg-primary text-white' : 'bg-white text-gray-800 border border-gray-100' }} rounded-2xl px-4 py-3 shadow-sm">
                    <p class="text-sm leading-relaxed">{{ $msg->message }}</p>
                    <p class="text-xs {{ $msg->sender_id === auth()->id() ? 'text-white/60' : 'text-gray-400' }} mt-1">
                        {{ $msg->created_at->format('H:i') }}
                        @if($msg->sender_id === auth()->id() && $msg->read_at)
                            <span class="ml-1">&#10003;&#10003;</span>
                        @endif
                    </p>
                </div>
            </div>
        @empty
            <div class="text-center py-10">
                <p class="text-gray-400 text-sm">No messages yet. Say hello!</p>
            </div>
        @endforelse
    </div>

    {{-- Input --}}
    <div class="bg-white rounded-b-2xl border border-gray-100 p-4 shadow-sm">
        <form method="POST" action="{{ route('messages.send', $partner->id) }}" id="chat-form" class="flex gap-3">
            @csrf
            <input type="text" name="message" id="message-input" required autocomplete="off"
                class="flex-1 px-4 py-3 rounded-full border border-gray-200 focus:ring-2 focus:ring-primary focus:border-primary transition text-sm"
                placeholder="Type a message...">
            <button type="submit" class="bg-primary hover:bg-primary-dark text-white rounded-full w-12 h-12 flex items-center justify-center shadow-md transition shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
            </button>
        </form>
    </div>
</div>

{{-- Report Modal --}}
<div id="report-modal-chat" class="hidden fixed inset-0 z-[60] flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/50" onclick="document.getElementById('report-modal-chat').classList.add('hidden')"></div>
    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md p-6 animate-fade-in-up">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Report {{ $partner->name }}</h3>
        <form method="POST" action="{{ route('user.report') }}">
            @csrf
            <input type="hidden" name="user_id" value="{{ $partner->id }}">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-600 mb-2">Reason for report</label>
                <select name="reason" required class="w-full px-3 py-2.5 rounded-lg border border-gray-200 text-sm focus:ring-primary focus:border-primary mb-3">
                    <option value="">Select a reason...</option>
                    <option value="Inappropriate messages">Inappropriate messages</option>
                    <option value="Harassment">Harassment</option>
                    <option value="Spam">Spam</option>
                    <option value="Fake profile">Fake profile</option>
                    <option value="Other">Other</option>
                </select>
                <textarea name="details" rows="3" class="w-full px-3 py-2.5 rounded-lg border border-gray-200 text-sm focus:ring-primary focus:border-primary" placeholder="Additional details (optional)..."></textarea>
            </div>
            <div class="flex gap-3">
                <button type="button" onclick="document.getElementById('report-modal-chat').classList.add('hidden')" class="flex-1 py-2.5 border border-gray-200 rounded-full text-sm font-medium text-gray-500 hover:bg-gray-50 transition">Cancel</button>
                <button type="submit" class="flex-1 py-2.5 bg-red-500 hover:bg-red-600 text-white rounded-full text-sm font-semibold transition">Submit Report</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Auto-scroll to bottom
    const chatBox = document.getElementById('chat-messages');
    chatBox.scrollTop = chatBox.scrollHeight;

    // Poll for new messages every 5 seconds
    let lastMsgId = {{ $messages->last() ? $messages->last()->id : 0 }};

    setInterval(async () => {
        try {
            const res = await fetch(`/messages/{{ $partner->id }}/new?after=${lastMsgId}`);
            const msgs = await res.json();
            msgs.forEach(msg => {
                if (msg.id > lastMsgId) {
                    lastMsgId = msg.id;
                    const div = document.createElement('div');
                    div.className = 'flex ' + (msg.is_mine ? 'justify-end' : 'justify-start') + ' animate-fade-in-up';
                    div.innerHTML = `
                        <div class="max-w-[75%] ${msg.is_mine ? 'bg-primary text-white' : 'bg-white text-gray-800 border border-gray-100'} rounded-2xl px-4 py-3 shadow-sm">
                            <p class="text-sm leading-relaxed">${msg.message}</p>
                            <p class="text-xs ${msg.is_mine ? 'text-white/60' : 'text-gray-400'} mt-1">${msg.time}</p>
                        </div>`;
                    chatBox.appendChild(div);
                    chatBox.scrollTop = chatBox.scrollHeight;
                }
            });
        } catch (e) {}
    }, 5000);

    // Focus input
    document.getElementById('message-input').focus();
</script>
@endsection
