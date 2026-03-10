@extends('layouts.admin')
@section('title', 'Reports')

@section('content')
<h1 class="text-2xl font-extrabold text-white mb-6">Reports</h1>

<div class="bg-gray-800 rounded-xl p-4 mb-6 border border-gray-700">
    <form method="GET" action="{{ route('admin.reports') }}" class="flex gap-3">
        <select name="status" class="px-3 py-2 rounded-lg bg-gray-700 border border-gray-600 text-white text-sm">
            <option value="">All Status</option>
            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="reviewed" {{ request('status') === 'reviewed' ? 'selected' : '' }}>Reviewed</option>
            <option value="resolved" {{ request('status') === 'resolved' ? 'selected' : '' }}>Resolved</option>
        </select>
        <button type="submit" class="px-6 py-2 bg-primary rounded-lg text-white font-semibold text-sm hover:bg-primary-dark transition">Filter</button>
    </form>
</div>

<div class="bg-gray-800 rounded-xl border border-gray-700 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-700/50">
                <tr>
                    <th class="px-4 py-3 text-left text-gray-400">Reporter</th>
                    <th class="px-4 py-3 text-left text-gray-400">Reported User</th>
                    <th class="px-4 py-3 text-left text-gray-400">Reason</th>
                    <th class="px-4 py-3 text-left text-gray-400">Status</th>
                    <th class="px-4 py-3 text-left text-gray-400">Date</th>
                    <th class="px-4 py-3 text-right text-gray-400">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700/50">
                @forelse($reports as $r)
                <tr class="hover:bg-gray-700/30">
                    <td class="px-4 py-3 text-white">{{ $r->reporter->name ?? 'Deleted' }}</td>
                    <td class="px-4 py-3 text-white">{{ $r->reportedUser->name ?? 'Deleted' }}</td>
                    <td class="px-4 py-3 text-gray-400">{{ Str::limit($r->reason, 40) }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 rounded-full text-xs font-medium
                            {{ $r->status === 'pending' ? 'bg-yellow-900/30 text-yellow-400' : '' }}
                            {{ $r->status === 'reviewed' ? 'bg-blue-900/30 text-blue-400' : '' }}
                            {{ $r->status === 'resolved' ? 'bg-green-900/30 text-green-400' : '' }}">
                            {{ ucfirst($r->status) }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-gray-500">{{ $r->created_at->format('M d, Y') }}</td>
                    <td class="px-4 py-3 text-right">
                        <div class="flex gap-2 justify-end">
                            @if($r->status === 'pending')
                                <form method="POST" action="{{ route('admin.reports.review', $r->id) }}">
                                    @csrf
                                    <button class="px-3 py-1 bg-blue-900/30 text-blue-400 rounded-lg text-xs hover:bg-blue-900/50 transition">Review</button>
                                </form>
                            @endif
                            @if($r->status !== 'resolved')
                                <form method="POST" action="{{ route('admin.reports.resolve', $r->id) }}">
                                    @csrf
                                    <button class="px-3 py-1 bg-green-900/30 text-green-400 rounded-lg text-xs hover:bg-green-900/50 transition">Resolve</button>
                                </form>
                            @endif
                            @if($r->reportedUser)
                                <form method="POST" action="{{ route('admin.users.ban', $r->reported_user_id) }}">
                                    @csrf
                                    <button class="px-3 py-1 bg-red-900/30 text-red-400 rounded-lg text-xs hover:bg-red-900/50 transition"
                                            onclick="return confirm('Ban this user?')">Ban User</button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-4 py-8 text-center text-gray-500">No reports found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-4">{{ $reports->links() }}</div>
@endsection
