<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserMatch;
use App\Models\Message;
use App\Models\Report;
use App\Models\AdminLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // ── Auth ──

    public function showLogin()
    {
        if (Auth::check() && Auth::user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            return back()->withErrors(['email' => 'Invalid credentials.'])->withInput();
        }

        if (!Auth::user()->isAdmin()) {
            Auth::logout();
            return back()->withErrors(['email' => 'Access denied. Admin only.'])->withInput();
        }

        $request->session()->regenerate();
        $this->log('admin_login', Auth::id());

        return redirect()->route('admin.dashboard');
    }

    public function logout(Request $request)
    {
        $this->log('admin_logout', Auth::id());
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }

    // ── Dashboard ──

    public function dashboard()
    {
        $stats = [
            'total_users' => User::where('role', 'user')->count(),
            'total_matches' => UserMatch::count(),
            'total_messages' => Message::count(),
            'total_reports' => Report::where('status', 'pending')->count(),
            'banned_users' => User::where('status', 'banned')->count(),
            'active_today' => User::whereHas('profile', function ($q) {
                $q->where('last_active_at', '>=', now()->subDay());
            })->count(),
        ];

        $recentUsers = User::where('role', 'user')->latest()->take(5)->get();
        $recentReports = Report::with(['reporter', 'reportedUser'])->latest()->take(5)->get();
        $recentLogs = AdminLog::with('admin')->latest()->take(10)->get();

        return view('admin.dashboard', compact('stats', 'recentUsers', 'recentReports', 'recentLogs'));
    }

    // ── Users ──

    public function users(Request $request)
    {
        $query = User::with('profile')->where('role', 'user');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")
                  ->orWhere('email', 'like', "%{$s}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $users = $query->latest()->paginate(20)->withQueryString();
        return view('admin.users', compact('users'));
    }

    public function banUser($id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => 'banned']);
        $this->log('ban_user', $id);
        return back()->with('success', 'User has been banned.');
    }

    public function unbanUser($id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => 'active']);
        $this->log('unban_user', $id);
        return back()->with('success', 'User has been unbanned.');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $this->log('delete_user', $id, 'Deleted user: ' . $user->email);
        $user->delete();
        return back()->with('success', 'User has been deleted.');
    }

    // ── Reports ──

    public function reports(Request $request)
    {
        $query = Report::with(['reporter', 'reportedUser', 'message']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $reports = $query->latest()->paginate(20)->withQueryString();
        return view('admin.reports', compact('reports'));
    }

    public function resolveReport($id)
    {
        $report = Report::findOrFail($id);
        $report->update(['status' => 'resolved']);
        $this->log('resolve_report', $id);
        return back()->with('success', 'Report resolved.');
    }

    public function reviewReport($id)
    {
        $report = Report::findOrFail($id);
        $report->update(['status' => 'reviewed']);
        $this->log('review_report', $id);
        return back()->with('success', 'Report marked as reviewed.');
    }

    // ── Matches ──

    public function matches(Request $request)
    {
        $matches = UserMatch::with(['user1.profile', 'user2.profile'])
            ->latest()
            ->paginate(20);

        return view('admin.matches', compact('matches'));
    }

    // ── Messages ──

    public function messages(Request $request)
    {
        $query = Message::with(['sender', 'receiver']);

        if ($request->filled('search')) {
            $query->where('message', 'like', '%' . $request->search . '%');
        }

        $messages = $query->latest()->paginate(30)->withQueryString();
        return view('admin.messages', compact('messages'));
    }

    // ── Helper ──

    private function log(string $action, int $targetId = null, string $details = null): void
    {
        AdminLog::create([
            'admin_id' => Auth::id(),
            'action' => $action,
            'target_id' => $targetId,
            'details' => $details,
        ]);
    }
}
