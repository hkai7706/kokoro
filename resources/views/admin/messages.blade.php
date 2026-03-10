@extends('layouts.admin')
@section('title', 'Messages')

@section('content')
<h1 class="text-2xl font-extrabold text-white mb-6">Messages</h1>

<div class="bg-gray-800 rounded-xl p-4 mb-6 border border-gray-700">
    <form method="GET" action="{{ route('admin.messages') }}" class="flex gap-3">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search messages..."
            class="flex-1 px-4 py-2 rounded-lg bg-gray-700 border border-gray-600 text-white text-sm focus:ring-primary focus:border-primary">
        <button type="submit" class="px-6 py-2 bg-primary rounded-lg text-white font-semibold text-sm hover:bg-primary-dark transition">Search</button>
    </form>
</div>

<div class="bg-gray-800 rounded-xl border border-gray-700 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-700/50">
                <tr>
                    <th class="px-4 py-3 text-left text-gray-400">From</th>
                    <th class="px-4 py-3 text-left text-gray-400">To</th>
                    <th class="px-4 py-3 text-left text-gray-400">Message</th>
                    <th class="px-4 py-3 text-left text-gray-400">Sent</th>
                    <th class="px-4 py-3 text-left text-gray-400">Read</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700/50">
                @forelse($messages as $msg)
                <tr class="hover:bg-gray-700/30">
                    <td class="px-4 py-3 text-white">{{ $msg->sender->name ?? 'Deleted' }}</td>
                    <td class="px-4 py-3 text-white">{{ $msg->receiver->name ?? 'Deleted' }}</td>
                    <td class="px-4 py-3 text-gray-400 max-w-xs truncate">{{ Str::limit($msg->message, 60) }}</td>
                    <td class="px-4 py-3 text-gray-500">{{ $msg->created_at->format('M d, H:i') }}</td>
                    <td class="px-4 py-3">
                        @if($msg->read_at)
                            <span class="text-green-400 text-xs">Read</span>
                        @else
                            <span class="text-gray-500 text-xs">Unread</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-4 py-8 text-center text-gray-500">No messages found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-4">{{ $messages->links() }}</div>
@endsection
