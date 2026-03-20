@extends('layouts.app')
@section('title', 'Chat with ' . $partner->name . ' - KOKORO')

@section('content')
<div class="max-w-2xl mx-auto flex flex-col" style="height: calc(100vh - 10rem);">
    {{-- Chat Header --}}
    <div class="card rounded-b-none border-b-0 px-3.5 py-2.5 flex items-center gap-2.5">
        <a href="{{ route('messages.inbox') }}" class="text-gray-500 hover:text-gray-600 dark:hover:text-gray-200 transition p-0.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <a href="{{ route('user.profile', $partner->id) }}" class="flex items-center gap-2.5 flex-1 min-w-0">
            <div class="w-8 h-8 rounded-full bg-gray-100 dark:bg-gray-700 overflow-hidden border border-gray-200 dark:border-gray-600 shrink-0">
                @if($partner->profile && $partner->profile->profile_photo)
                    <img src="{{ asset('storage/' . $partner->profile->profile_photo) }}" class="w-full h-full object-cover" loading="lazy" alt="{{ $partner->name }}'s profile photo">
                @else
                    <div class="w-full h-full flex items-center justify-center">
                        <span class="text-xs font-bold text-gray-300 dark:text-gray-500">{{ strtoupper(substr($partner->name, 0, 1)) }}</span>
                    </div>
                @endif
            </div>
            <div class="min-w-0">
                <h2 class="text-sm font-semibold text-gray-800 dark:text-gray-100 truncate">{{ $partner->name }}</h2>
                @if($partner->profile && $partner->profile->last_active_at)
                    <p class="text-[10px] text-gray-500 leading-tight">
                        @if($partner->profile->last_active_at->diffInMinutes(now()) < 30)
                            <span class="text-emerald-500" data-en="Online" data-jp="オンライン">Online</span>
                        @else
                            <span data-en="{{ $partner->profile->last_active_at->diffForHumans() }}" data-jp="{{ $partner->profile->last_active_at->diffForHumans() }}">{{ $partner->profile->last_active_at->diffForHumans() }}</span>
                        @endif
                    </p>
                @endif
            </div>
        </a>
        {{-- More menu --}}
        <div class="relative">
            <button onclick="this.nextElementSibling.classList.toggle('hidden')" class="text-gray-500 hover:text-gray-600 dark:hover:text-gray-200 p-1 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/></svg>
            </button>
            <div class="hidden absolute right-0 mt-1 w-36 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200/60 dark:border-gray-700 py-1 z-50">
                <form method="POST" action="{{ route('user.block') }}">@csrf<input type="hidden" name="user_id" value="{{ $partner->id }}"><button type="submit" class="block w-full text-left px-3 py-1.5 text-xs text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20" onclick="return confirm('Block this user?')"><span data-en="Block" data-jp="ブロック">Block</span></button></form>
                <button onclick="document.getElementById('report-modal-chat').classList.remove('hidden')" class="block w-full text-left px-3 py-1.5 text-xs text-amber-600 hover:bg-amber-50 dark:hover:bg-amber-900/20">
                    <span data-en="Report" data-jp="通報">Report</span>
                </button>
            </div>
        </div>
    </div>

    {{-- Messages --}}
    <div id="chat-messages" class="flex-1 overflow-y-auto bg-gray-50 dark:bg-gray-900 px-4 py-3 space-y-2 border-x border-gray-100 dark:border-gray-700/50">
        @forelse($messages as $msg)
            <div class="flex {{ $msg->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                <div class="max-w-[75%] {{ $msg->sender_id === auth()->id() ? 'bg-rose-500 text-white' : 'bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 border border-gray-100 dark:border-gray-700' }} rounded-2xl px-3 py-2 shadow-sm">
                    <p class="text-[13px] leading-relaxed">{{ $msg->message }}</p>
                    <p class="text-[10px] {{ $msg->sender_id === auth()->id() ? 'text-white/50' : 'text-gray-300 dark:text-gray-500' }} mt-0.5 text-right">
                        {{ $msg->created_at->format('H:i') }}
                        @if($msg->sender_id === auth()->id() && $msg->read_at)
                            <span class="ml-0.5 text-white/70">&#10003;&#10003;</span>
                        @endif
                    </p>
                </div>
            </div>
        @empty
            <div class="text-center py-12">
                <p class="text-gray-500 text-xs mb-1" data-en="This is the beginning of your conversation" data-jp="会話の始まりです">This is the beginning of your conversation</p>
                <p class="text-gray-300 dark:text-gray-500 text-[11px]" data-en="Say something nice to break the ice!" data-jp="何か素敵なメッセージを送りましょう！">Say something nice to break the ice!</p>
            </div>
        @endforelse
    </div>

    {{-- Input --}}
    <div class="card rounded-t-none border-t-0 px-3.5 py-2.5">
        <form method="POST" action="{{ route('messages.send', $partner->id) }}" id="chat-form" class="flex gap-2">
            @csrf
            <input type="text" name="message" id="message-input" required autocomplete="off"
                class="flex-1 px-3 py-2 rounded-xl border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:ring-2 focus:ring-rose-100 focus:border-rose-400 transition text-sm"
                placeholder="Type a message..." data-placeholder-en="Type a message..." data-placeholder-jp="メッセージを入力...">
            <button type="submit" class="bg-rose-500 hover:bg-rose-600 text-white rounded-xl w-9 h-9 flex items-center justify-center transition shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
            </button>
        </form>
    </div>
</div>

{{-- Report Modal --}}
<div id="report-modal-chat" class="hidden fixed inset-0 z-[60] flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="document.getElementById('report-modal-chat').classList.add('hidden')"></div>
    <div class="relative bg-white dark:bg-gray-800 rounded-xl shadow-xl w-full max-w-sm p-5 animate-in">
        <h3 class="text-sm font-bold text-gray-800 dark:text-gray-100 mb-3"><span data-en="Report {{ $partner->name }}" data-jp="{{ $partner->name }}を通報">Report {{ $partner->name }}</span></h3>
        <form method="POST" action="{{ route('user.report') }}">
            @csrf
            <input type="hidden" name="user_id" value="{{ $partner->id }}">
            <div class="mb-4">
                <select name="reason" required class="w-full px-3 py-2 rounded-lg border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 text-sm focus:ring-2 focus:ring-rose-100 focus:border-rose-400 mb-2">
                    <option value="" data-en="Select a reason" data-jp="理由を選択">Select a reason</option>
                    <option value="Inappropriate messages" data-en="Inappropriate messages" data-jp="不適切なメッセージ">Inappropriate messages</option>
                    <option value="Harassment" data-en="Harassment" data-jp="嫌がらせ">Harassment</option>
                    <option value="Spam" data-en="Spam" data-jp="スパム">Spam</option>
                    <option value="Fake profile" data-en="Fake profile" data-jp="偽プロフィール">Fake profile</option>
                    <option value="Other" data-en="Other" data-jp="その他">Other</option>
                </select>
                <textarea name="details" rows="2" class="w-full px-3 py-2 rounded-lg border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 text-sm focus:ring-2 focus:ring-rose-100 focus:border-rose-400" placeholder="Details (optional)" data-placeholder-en="Details (optional)" data-placeholder-jp="詳細（任意）"></textarea>
            </div>
            <div class="flex gap-2">
                <button type="button" onclick="document.getElementById('report-modal-chat').classList.add('hidden')" class="flex-1 btn btn-ghost btn-sm" data-en="Cancel" data-jp="キャンセル">Cancel</button>
                <button type="submit" class="flex-1 btn bg-red-500 hover:bg-red-600 text-white btn-sm" data-en="Report" data-jp="通報">Report</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const chatBox = document.getElementById('chat-messages');
    const chatForm = document.getElementById('chat-form');
    const msgInput = document.getElementById('message-input');
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content
        || document.querySelector('input[name="_token"]')?.value;

    chatBox.scrollTop = chatBox.scrollHeight;

    let lastMsgId = {{ $messages->last() ? $messages->last()->id : 0 }};

    // Send message via AJAX instead of form submit
    chatForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        const text = msgInput.value.trim();
        if (!text) return;

        // Immediately show the message in the chat (optimistic UI)
        const now = new Date();
        const timeStr = now.getHours().toString().padStart(2,'0') + ':' + now.getMinutes().toString().padStart(2,'0');
        appendMessage(text, true, timeStr);
        msgInput.value = '';
        msgInput.focus();

        try {
            const res = await fetch(`/messages/{{ $partner->id }}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ message: text })
            });
            const data = await res.json();
            if (data.message && data.message.id) {
                lastMsgId = Math.max(lastMsgId, data.message.id);
            }
        } catch (err) {
            console.error('Failed to send:', err);
        }
    });

    function appendMessage(text, isMine, time) {
        // Remove empty state if present
        const emptyState = chatBox.querySelector('.text-center.py-12');
        if (emptyState) emptyState.remove();

        const div = document.createElement('div');
        div.className = 'flex ' + (isMine ? 'justify-end' : 'justify-start');
        const escaped = text.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
        div.innerHTML = `
            <div class="max-w-[75%] ${isMine ? 'bg-rose-500 text-white' : 'bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 border border-gray-100 dark:border-gray-700'} rounded-2xl px-3 py-2 shadow-sm">
                <p class="text-[13px] leading-relaxed">${escaped}</p>
                <p class="text-[10px] ${isMine ? 'text-white/50' : 'text-gray-300 dark:text-gray-500'} mt-0.5 text-right">${time}</p>
            </div>`;
        chatBox.appendChild(div);
        chatBox.scrollTop = chatBox.scrollHeight;
    }

    // Poll for new messages
    setInterval(async () => {
        try {
            const res = await fetch(`/messages/{{ $partner->id }}/new?after=${lastMsgId}`);
            const msgs = await res.json();
            msgs.forEach(msg => {
                if (msg.id > lastMsgId) {
                    lastMsgId = msg.id;
                    if (!msg.is_mine) {
                        appendMessage(msg.message, false, msg.time);
                    }
                }
            });
        } catch (e) {}
    }, 5000);

    msgInput.focus();
</script>
@endsection
