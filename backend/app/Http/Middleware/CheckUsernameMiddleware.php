<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUsernameMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $username = $request->header('Username');

        $user = User::where('username', $username)->first();

        if (!$user) {
            return response()->json(['error' => 'Invalid user'], 400);
        }

        $request->attributes->set('user', $user);
        return $next($request);
    }
}
