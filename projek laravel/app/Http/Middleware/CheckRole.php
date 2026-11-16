<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role = 'admin'): Response
    {
        $currentRole = session('user_role', 'admin');

        if ($currentRole !== $role) {
            if ($request->expectsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Akses ditolak: Anda tidak memiliki hak akses untuk fitur ini.'
                ], 403);
            }

            return redirect()->route('lapangan.index')
                ->with('galat_akses', 'Akses ditolak! Fitur ini hanya dapat diakses oleh peran: ' . strtoupper($role) . '. Peran Anda saat ini adalah: ' . strtoupper($currentRole) . '.');
        }

        return $next($request);
    }
}
