<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\userMenu;

class CheckAuthAndRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (session()->get('login')==true && session()->has('userdata.email')) {
            // Session variable 'user' exists
            return $next($request);
        } else {
            // Session variable 'user_id' does not exist
            return redirect()->route('login');
        }
    }
}
