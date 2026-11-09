<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user || ! $user->hasAnyRole(['Admin', 'Editor'])) {
            if ($user) {
                auth()->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
            }

            abort(403, 'غير مصرح لك بالوصول إلى لوحة الإدارة. الدخول مخصص للمديرين والمشرفين فقط.');
        }

        return $next($request);
    }
}
