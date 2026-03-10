@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
<h1 class="text-2xl font-extrabold text-white mb-8">Dashboard</h1>

{{-- Stats Cards --}}
<div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
    <div class="bg-gray-800 rounded-2xl p-6 border border-gray-700">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-400">Total Users</p>
                <p class="text-3xl font-extrabold text-white mt-1">{{ number_format($stats['total_users']) }}</p>
            </div>
            <div class="w-12 h-12 bg-blue-500/20 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            </div>
        </div>
    </div>
    <div class="bg-gray-800 rounded-2xl p-6 border border-gray-700">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-400">Total Matches</p>
                <p class="text-3xl font-extrabold text-white mt-1">{{ number_format($stats['total_matches']) }}</p>
            </div>
            <div class="w-12 h-12 bg-pink-500/20 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
            </div>
        </div>
    </div>
    <div class="bg-gray-800 rounded-2xl p-6 border border-gray-700">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-400">Total Messages</p>
                <p class="text-3xl font-extrabold text-white mt-1">{{ number_format($stats['total_messages']) }}</p>
            </div>
            <div class="w-12 h-12 bg-purple-500/20 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
            </div>
        </div>
    </div>
    <div class="bg-gray-800 rounded-2xl p-6 border border-gray-700">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-400">Pending Reports</p>
                <p class="text-3xl font-extrabold text-white mt-1">{{ $stats['total_reports'] }}</p>
            </div>
            <div class="w-12 h-12 bg-red-500/20 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.834-1.964-.834-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
            </div>
        </div>
    </div>
    <div class="bg-gray-800 rounded-2xl p-6 border border-gray-700">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-400">Banned Users</p>
                <p class="text-3xl font-extrabold text-white mt-1">{{ $stats['banned_users'] }}</p>
            </div>
            <div class="w-12 h-12 bg-yellow-500/20 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
            </div>
        </div>
    </div>
    <div class="bg-gray-800 rounded-2xl p-6 border border-gray-700">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-400">Active Today</p>
                <p class="text-3xl font-extrabold text-white mt-1">{{ $stats['active_today'] }}</p>
            </div>
            <div class="w-12 h-12 bg-green-500/20 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.636 18.364a9 9 0 010-12.728m12.728 0a9 9 0 010 12.728m-9.9-2.829a5 5 0 010-7.07m7.072 0a5 5 0 010 7.07M13 12a1 1 0 11-2 0 1 1 0 012 0z"/></svg>
            </div>
        </div>
    </div>
</div>

<div class="grid lg:grid-cols-2 gap-6">
    {{-- Recent Users --}}
    <div class="bg-gray-800 rounded-2xl p-6 border border-gray-700">
        <h2 class="text-lg font-bold text-white mb-4">Recent Users</h2>
        <div class="space-y-3">
            @forelse($recentUsers as $u)
                <div class="flex items-center justify-between py-2 border-b border-gray-700/50 last:border-0">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-gray-700 flex items-center justify-center text-sm font-bold text-primary">{{ strtoupper(substr($u->name, 0, 1)) }}</div>
                        <div>
                            <p class="text-sm font-medium text-white">{{ $u->name }}</p>
                            <p class="text-xs text-gray-500">{{ $u->email }}</p>
                        </div>
                    </div>
                    <span class="text-xs px-2 py-1 rounded-full {{ $u->status === 'active' ? 'bg-green-900/30 text-green-400' : 'bg-red-900/30 text-red-400' }}">{{ $u->status }}</span>
                </div>
            @empty
                <p class="text-gray-500 text-sm">No users yet.</p>
            @endforelse
        </div>
        <a href="{{ route('admin.users') }}" class="inline-block mt-4 text-sm text-primary hover:text-pink-400 transition">View all users &rarr;</a>
    </div>

    {{-- Recent Reports --}}
    <div class="bg-gray-800 rounded-2xl p-6 border border-gray-700">
        <h2 class="text-lg font-bold text-white mb-4">Recent Reports</h2>
        <div class="space-y-3">
            @forelse($recentReports as $r)
                <div class="flex items-center justify-between py-2 border-b border-gray-700/50 last:border-0">
                    <div>
                        <p class="text-sm text-white">{{ $r->reporter->name ?? 'Unknown' }} reported {{ $r->reportedUser->name ?? 'Unknown' }}</p>
                        <p class="text-xs text-gray-500">{{ $r->reason }} &middot; {{ $r->created_at->diffForHumans() }}</p>
                    </div>
                    <span class="text-xs px-2 py-1 rounded-full {{ $r->status === 'pending' ? 'bg-yellow-900/30 text-yellow-400' : 'bg-green-900/30 text-green-400' }}">{{ $r->status }}</span>
                </div>
            @empty
                <p class="text-gray-500 text-sm">No reports yet.</p>
            @endforelse
        </div>
        <a href="{{ route('admin.reports') }}" class="inline-block mt-4 text-sm text-primary hover:text-pink-400 transition">View all reports &rarr;</a>
    </div>
</div>

{{-- Recent Admin Logs --}}
<div class="bg-gray-800 rounded-2xl p-6 border border-gray-700 mt-6">
    <h2 class="text-lg font-bold text-white mb-4">Admin Activity Log</h2>
    <div class="space-y-2">
        @forelse($recentLogs as $log)
            <div class="flex items-center justify-between py-2 border-b border-gray-700/50 last:border-0 text-sm">
                <div>
                    <span class="text-gray-300">{{ $log->admin->name ?? 'Admin' }}</span>
                    <span class="text-gray-500">&middot; {{ $log->action }}</span>
                    @if($log->details) <span class="text-gray-600">- {{ $log->details }}</span> @endif
                </div>
                <span class="text-xs text-gray-500">{{ $log->created_at->diffForHumans() }}</span>
            </div>
        @empty
            <p class="text-gray-500 text-sm">No activity yet.</p>
        @endforelse
    </div>
</div>
@endsection
