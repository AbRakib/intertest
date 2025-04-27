<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated {
    public function handle(Request $request, Closure $next, ...$guards): Response {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // Redirect based on guard
                if ($guard === 'web') {
                    return redirect()->route('admin.dashboard');
                }

                if($guard === 'customer') {
                    return redirect()->route('customer.dashboard');
                }
            }
        }

        return $next($request);
    }
}