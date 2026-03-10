<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureProfileComplete
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && !auth()->user()->isAdmin() && !auth()->user()->hasCompletedProfile()) {
            if (!$request->is('profile/create') && !$request->is('profile/store') && !$request->is('logout')) {
                return redirect()->route('profile.create')
                    ->with('info', 'Please complete your profile to start matching!');
            }
        }

        return $next($request);
    }
}
