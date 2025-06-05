<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Sprawdza, czy użytkownik ma wymaganą rolę.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!$request->user() || $request->user()->role !== $role) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Brak uprawnień.'], 403);
            }
            
            return redirect()->route('dashboard')->with('error', 'Brak uprawnień do tej sekcji.');
        }

        return $next($request);
    }
}
