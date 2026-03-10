@extends('layouts.admin')
@section('title', 'Users')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-extrabold text-white">Users</h1>
    <span class="text-sm text-gray-400">{{ $users->total() }} total</span>
</div>

{{-- Search & Filter --}}
<div class="bg-gray-800 rounded-xl p-4 mb-6 border border-gray-700">
    <form method="GET" action="{{ route('admin.users') }}" class="flex flex-wrap gap-3">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or email..."
            class="flex-1 min-w-[200px] px-4 py-2 rounded-lg bg-gray-700 border border-gray-600 text-white text-sm focus:ring-primary focus:border-primary">
        <select name="status" class="px-3 py-2 rounded-lg bg-gray-700 border border-gray-600 text-white text-sm">
            <option value="">All Status</option>
            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
            <option value="banned" {{ request('status') === 'banned' ? 'selected' : '' }}>Banned</option>
        </select>
        <button type="submit" class="px-6 py-2 bg-primary rounded-lg text-white font-semibold text-sm hover:bg-primary-dark transition">Search</button>
    </form>
</div>

{{-- Users Table --}}
<div class="bg-gray-800 rounded-xl border border-gray-700 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-700/50">
                <tr>
                    <th class="px-4 py-3 text-left text-gray-400 font-semibold">User</th>
                    <th class="px-4 py-3 text-left text-gray-400 font-semibold hidden sm:table-cell">Email</th>
                    <th class="px-4 py-3 text-left text-gray-400 font-semibold hidden md:table-cell">Joined</th>
                    <th class="px-4 py-3 text-left text-gray-400 font-semibold">Status</th>
                    <th class="px-4 py-3 text-right text-gray-400 font-semibold">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700/50">
                @forelse($users as $u)
                <tr class="hover:bg-gray-700/30">
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-gray-700 flex items-center justify-center text-xs font-bold text-primary">
                                {{ strtoupper(substr($u->name, 0, 1)) }}
                            </div>
                            <span class="text-white font-medium">{{ $u->name }}</span>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-gray-400 hidden sm:table-cell">{{ $u->email }}</td>
                    <td class="px-4 py-3 text-gray-500 hidden md:table-cell">{{ $u->created_at->format('M d, Y') }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 rounded-full text-xs font-medium {{ $u->status === 'active' ? 'bg-green-900/30 text-green-400' : 'bg-red-900/30 text-red-400' }}">
                            {{ ucfirst($u->status) }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-right">
                        <div class="flex gap-2 justify-end">
                            @if($u->status === 'active')
                                <form method="POST" action="{{ route('admin.users.ban', $u->id) }}">
                                    @csrf
                                    <button type="submit" class="px-3 py-1 bg-yellow-900/30 text-yellow-400 rounded-lg text-xs hover:bg-yellow-900/50 transition"
                                            onclick="return confirm('Ban this user?')">Ban</button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('admin.users.unban', $u->id) }}">
                                    @csrf
                                    <button type="submit" class="px-3 py-1 bg-green-900/30 text-green-400 rounded-lg text-xs hover:bg-green-900/50 transition">Unban</button>
                                </form>
                            @endif
                            <form method="POST" action="{{ route('admin.users.delete', $u->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1 bg-red-900/30 text-red-400 rounded-lg text-xs hover:bg-red-900/50 transition"
                                        onclick="return confirm('Permanently delete this user? This cannot be undone.')">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-4 py-8 text-center text-gray-500">No users found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4">{{ $users->links() }}</div>
@endsection
