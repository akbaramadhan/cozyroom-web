<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthenticateWithJWT
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            // Memeriksa token dan mengautentikasi pengguna
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return redirect()->route('login')->withErrors('Token tidak valid atau pengguna tidak ditemukan.');
            }
        } catch (\Exception $e) {
            // Menangani berbagai jenis kesalahan token
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return redirect()->route('login')->withErrors('Token telah kadaluarsa.');
            } elseif ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return redirect()->route('login')->withErrors('Token tidak valid.');
            } else {
                return redirect()->route('login')->withErrors('Token tidak ditemukan.');
            }
        }
        return $next($request);
    }
}
