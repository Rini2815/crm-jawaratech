<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CekMenu
{
    /**
     * Parameter: kunci menu (misal data-konsumen) atau kata 'superadmin'
     */
    public function handle(Request $request, Closure $next, string $menu): Response
    {
        $user = $request->user();

        $boleh = $user && ($menu === 'superadmin' ? $user->isSuperadmin() : $user->hasMenu($menu));

        if (!$boleh) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}