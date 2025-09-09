<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleManager
{
    public function handle(Request $request, Closure $next)
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        if (!$user || !$user->hasRole('quan-ly')) {
            // return response()->json([
            //     'error' => 'Bạn không có quyền truy cập chức năng này',
            // ], 403);
            flash()->error('Bạn không có quyền truy cập chức năng này');
            return redirect()->back();
        }
        return $next($request);
    }
}
