<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role = 'admin'): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('galat', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user();

        if ($user->role !== $role) {
            if ($request->expectsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Akses ditolak: Anda tidak memiliki hak akses untuk fitur ini.'
                ], 403);
            }

            return redirect()->route('lapangan.index')
                ->with('galat_akses', 'Akses ditolak! Fitur ini hanya dapat diakses oleh peran: ' . strtoupper($role) . '. Akun Anda saat ini memiliki peran: ' . strtoupper($user->role) . '.');
        }

        return $next($request);
    }
}
