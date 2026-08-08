<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
class CekRole
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next,string $role): Response
    {
        if (!Auth::check()) {
            return redirect('/'); // Redirect to the home page or any other page you want
        }

        if ($request->user()->role !== $role) {
            abort(403, 'Unauthorized action.'); // You can customize the error message or redirect to a different page
        }
        
        return $next($request);
    }
}
