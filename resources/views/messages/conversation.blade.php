@extends('layouts.app')
@section('title', 'Chat with ' . $partner->name . ' - KOKORO')

@section('content')
<div class="max-w-3xl mx-auto flex flex-col" style="height: calc(100vh - 10rem);">
    {{-- Chat Header --}}
    <div class="card rounded-b-none border-b-0 px-4 py-3 flex items-center gap-3">
        <a href="{{ route('messages.inbox') }}" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <div class="w-9 h-9 rounded-full bg-gray-100 dark:bg-gray-700 overflow-hidden border border-gray-200 dark:border-gray-600">
            @if($partner->profile && $partner->profile->profile_photo)
                <img src="{{ asset('storage/' . $partner->profile->profile_photo) }}" class="w-full h-full object-cover">
            @else
                <div class="w-full h-full flex items-center justify-center">
                    <svg class="w-5 h-5 text-gray-300 dark:text-gray-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                </div>
            @endif
        </div>
        <div class="flex-1 min-w-0">
            <h2 class="font-semibold text-sm text-gray-800 dark:text-gray-100">{{ $partner->name }}</h2>
            @if($partner->profile && $partner->profile->last_active_at)
                <p class="text-[11px] text-gray-400">
                    @if($partner->profile->last_active_at->diffInMinutes(now()) < 30)
                        <span class="text-emerald-500" data-en="Online now" data-jp="オンライン中">Online now</span>
                    @else
                        <span data-en="Last seen {{ $partner->profile->last_active_at->diffForHumans() }}" data-jp="最終ログイン {{ $partner->profile->last_active_at->diffForHumans() }}">Last seen {{ $partner->profile->last_active_at->diffForHumans() }}</span>
                    @endif
                </p>
            @endif
        </div>
        <a href="{{ route('user.profile', $partner->id) }}" class="text-xs text-gray-400 hover:text-rose-500 font-medium transition" data-en="View Profile" data-jp="プロフィール">View Profile</a>
        {{-- More menu --}}
        <div class="relative">
            <button onclick="this.nextElementSibling.classList.toggle('hidden')" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 p-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/></svg>
            </button>
            <div class="hidden absolute right-0 mt-1 w-44 bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 py-1 z-50">
                <form method="POST" action="{{ route('user.block') }}">@csrf<input type="hidden" name="user_id" value="{{ $partner->id }}"><button type="submit" class="block w-full text-left px-3.5 py-2 text-sm text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20" onclick="return confirm('Block this user?')"><span data-en="Block User" data-jp="ブロック">Block User</span></button></form>
                <button onclick="document.getElementById('report-modal-chat').classList.remove('hidden')" class="block w-full text-left px-3.5 py-2 text-sm text-amber-600 hover:bg-amber-50 dark:hover:bg-amber-900/20">
                    <span data-en="Report User" data-jp="通報する">Report User</span>
                </button>
            </div>
        </div>
    </div>

    {{-- Messages --}}
    <div id="chat-messages" class="flex-1 overflow-y-auto bg-gray-50 dark:bg-gray-900 p-4 space-y-2.5 border-x border-gray-100 dark:border-gray-700/50">
        @forelse($messages as $msg)
            <div class="flex {{ $msg->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }} animate-in">
                <div class="max-w-[75%] {{ $msg->sender_id === auth()->id() ? 'bg-rose-500 text-white' : 'bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 border border-gray-100 dark:border-gray-700' }} rounded-2xl px-3.5 py-2.5 shadow-sm">
                    <p class="text-sm leading-relaxed">{{ $msg->message }}</p>
                    <p class="text-[11px] {{ $msg->sender_id === auth()->id() ? 'text-white/60' : 'text-gray-400' }} mt-0.5">
                        {{ $msg->created_at->format('H:i') }}
                        @if($msg->sender_id === auth()->id() && $msg->read_at)
                            <span class="ml-0.5">&#10003;&#10003;</span>
                        @endif
                    </p>
                </div>
            </div>
        @empty
            <div class="text-center py-10">
                <p class="text-gray-400 text-xs" data-en="No messages yet. Say hello!" data-jp="まだメッセージがありません。挨拶しましょう!">No messages yet. Say hello!</p>
            </div>
        @endforelse
    </div>

    {{-- Input --}}
    <div class="card rounded-t-none border-t-0 px-4 py-3">
        <form method="POST" action="{{ route('messages.send', $partner->id) }}" id="chat-form" class="flex gap-2.5">
            @csrf
            <input type="text" name="message" id="message-input" required autocomplete="off"
                class="flex-1 px-3.5 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:ring-2 focus:ring-rose-200 focus:border-rose-400 transition text-sm"
                placeholder="Type a message..." data-placeholder-en="Type a message..." data-placeholder-jp="メッセージを入力...">
            <button type="submit" class="bg-rose-500 hover:bg-rose-600 text-white rounded-xl w-10 h-10 flex items-center justify-center transition shrink-0">
                <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
            </button>
        </form>
    </div>
</div>

{{-- Report Modal --}}
<div id="report-modal-chat" class="hidden fixed inset-0 z-[60] flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="document.getElementById('report-modal-chat').classList.add('hidden')"></div>
    <div class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-xl w-full max-w-md p-5 animate-in">
        <h3 class="text-base font-bold text-gray-800 dark:text-gray-100 mb-3"><span data-en="Report {{ $partner->name }}" data-jp="{{ $partner->name }}を通報">Report {{ $partner->name }}</span></h3>
        <form method="POST" action="{{ route('user.report') }}">
            @csrf
            <input type="hidden" name="user_id" value="{{ $partner->id }}">
            <div class="mb-4">
                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1" data-en="Reason for report" data-jp="通報理由">Reason for report</label>
                <select name="reason" required class="w-full px-3 py-2 rounded-lg border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 text-sm focus:ring-2 focus:ring-rose-200 focus:border-rose-400 mb-2.5">
                    <option value="" data-en="Select a reason..." data-jp="理由を選択...">Select a reason...</option>
                    <option value="Inappropriate messages" data-en="Inappropriate messages" data-jp="不適切なメッセージ">Inappropriate messages</option>
                    <option value="Harassment" data-en="Harassment" data-jp="嫌がらせ">Harassment</option>
                    <option value="Spam" data-en="Spam" data-jp="スパム">Spam</option>
                    <option value="Fake profile" data-en="Fake profile" data-jp="偽プロフィール">Fake profile</option>
                    <option value="Other" data-en="Other" data-jp="その他">Other</option>
                </select>
                <textarea name="details" rows="3" class="w-full px-3 py-2 rounded-lg border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 text-sm focus:ring-2 focus:ring-rose-200 focus:border-rose-400" placeholder="Additional details (optional)..." data-placeholder-en="Additional details (optional)..." data-placeholder-jp="詳細（任意）..."></textarea>
            </div>
            <div class="flex gap-2.5">
                <button type="button" onclick="document.getElementById('report-modal-chat').classList.add('hidden')" class="flex-1 btn btn-ghost" data-en="Cancel" data-jp="キャンセル">Cancel</button>
                <button type="submit" class="flex-1 btn bg-red-500 hover:bg-red-600 text-white" data-en="Submit Report" data-jp="通報を送信">Submit Report</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const chatBox = document.getElementById('chat-messages');
    chatBox.scrollTop = chatBox.scrollHeight;

    let lastMsgId = {{ $messages->last() ? $messages->last()->id : 0 }};

    setInterval(async () => {
        try {
            const res = await fetch(`/messages/{{ $partner->id }}/new?after=${lastMsgId}`);
            const msgs = await res.json();
            msgs.forEach(msg => {
                if (msg.id > lastMsgId) {
                    lastMsgId = msg.id;
                    const div = document.createElement('div');
                    div.className = 'flex ' + (msg.is_mine ? 'justify-end' : 'justify-start') + ' animate-in';
                    div.innerHTML = `
                        <div class="max-w-[75%] ${msg.is_mine ? 'bg-rose-500 text-white' : 'bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 border border-gray-100 dark:border-gray-700'} rounded-2xl px-3.5 py-2.5 shadow-sm">
                            <p class="text-sm leading-relaxed">${msg.message}</p>
                            <p class="text-[11px] ${msg.is_mine ? 'text-white/60' : 'text-gray-400'} mt-0.5">${msg.time}</p>
                        </div>`;
                    chatBox.appendChild(div);
                    chatBox.scrollTop = chatBox.scrollHeight;
                }
            });
        } catch (e) {}
    }, 5000);

    document.getElementById('message-input').focus();
</script>
@endsection
