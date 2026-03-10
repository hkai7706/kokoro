@extends('layouts.admin')
@section('title', 'Matches')

@section('content')
<h1 class="text-2xl font-extrabold text-white mb-6">Matches</h1>

<div class="bg-gray-800 rounded-xl border border-gray-700 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-700/50">
                <tr>
                    <th class="px-4 py-3 text-left text-gray-400">User 1</th>
                    <th class="px-4 py-3 text-left text-gray-400">User 2</th>
                    <th class="px-4 py-3 text-left text-gray-400">Status</th>
                    <th class="px-4 py-3 text-left text-gray-400">Matched On</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700/50">
                @forelse($matches as $m)
                <tr class="hover:bg-gray-700/30">
                    <td class="px-4 py-3 text-white">{{ $m->user1->name ?? 'Deleted' }}</td>
                    <td class="px-4 py-3 text-white">{{ $m->user2->name ?? 'Deleted' }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 rounded-full text-xs font-medium {{ $m->status === 'active' ? 'bg-green-900/30 text-green-400' : 'bg-gray-700 text-gray-400' }}">{{ ucfirst($m->status) }}</span>
                    </td>
                    <td class="px-4 py-3 text-gray-500">{{ $m->created_at->format('M d, Y H:i') }}</td>
                </tr>
                @empty
                <tr><td colspan="4" class="px-4 py-8 text-center text-gray-500">No matches yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-4">{{ $matches->links() }}</div>
@endsection
