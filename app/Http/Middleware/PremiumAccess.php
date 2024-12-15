<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
// use App\Models\User;

class PremiumAccess
{
    public function handle(Request $request, Closure $next): ?Response
    {
        return $next($request);
        // @TODO implement
        // $user = User::where('token', $request->token)->first();

        // if (empty($user)) return null;
        
        // //?-> checkarei an einai null (js ?.)
        // if ($user?->is_premium) return $next($request);
    }
}
