<?php

namespace App\Http\Middleware;

use App\Traits\ResponseTrait;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Authenticate
{
    use ResponseTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $result = 'default'): Response
    {
        if(!Auth::check()) {
            if($result == 'response') {
                return $this->errorResponse('Session Expired', 'Please relogin your account to continue.');
            }

            return redirect('/');
        }
        
        return $next($request);
    }
}
