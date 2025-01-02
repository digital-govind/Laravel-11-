<?php 

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Response as StatusCodeResponse;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $auth_key = $request->header('AuthKey');
        if (!$auth_key) {
            // Return JSON response correctly
            return response()->json("Unauthorized", StatusCodeResponse::HTTP_UNAUTHORIZED);
        }

        $user_id = Redis::get(getRedisKey('auth', $auth_key));
        if (!$user_id) {
            return response()->json("Auth Session Not Created", StatusCodeResponse::HTTP_UNAUTHORIZED);
        }

        $user = Redis::get(getRedisKey('user', $user_id));

        if (!$user) {
            return response()->json("User Not Found", StatusCodeResponse::HTTP_UNAUTHORIZED);
        }

        $userData = (array) json_decode($user, true); // Convert stdClass to array

        $request->merge(['user' => $userData]);

        return $next($request);
    }
}
