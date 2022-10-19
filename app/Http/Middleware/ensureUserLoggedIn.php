<?php

namespace App\Http\Middleware;

use App\Http\Controllers\CookieController;
use Closure;
use Illuminate\Http\Request;

class ensureUserLoggedIn
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next) {
        $token = $request->all( "token" );

        $userData = CookieController::UserData( $token[ "token" ] );
        if( ! exists( $userData ) ) return redirect( "/" );
        
        return $next($request);
    }
}
