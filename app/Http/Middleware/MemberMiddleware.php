<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::user()->role !== 'member') {
          abort(403, 'Ton rôle actuel est : ' . Auth::user()->role . '. Tu n\'es pas reconnu comme member.');  
        }

        return $next($request);
    }
}