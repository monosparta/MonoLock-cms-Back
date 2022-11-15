<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EnsurePermissionIsRoot
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->header('token');
        if ($token == NULL) {
            return response("no_login", 401);
        }
        
        $user = DB::table('users')->where('remember_token', '=', $token);
        if ($user->first() == NULL) {
            return response("no_login", 401);
        }

        if ($user->first()->permission != 0 || strtotime($user->first()->token_expire_time) < time()) {
            return response("token_expired", 401);
        }

        $user->update(['token_expire_time' => date('Y-m-d H:i:s', time() + 60 * 60)]);
        return $next($request);
    }
}
