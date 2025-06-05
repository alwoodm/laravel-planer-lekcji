<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        if (!$request->user() || $request->user()->role !== $role) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Brak uprawnień.'], 403);
            }
            
            // Dla panelu administracyjnego Filament
            if (str_starts_with($request->path(), 'admin')) {
                abort(403, 'Brak uprawnień do dostępu do panelu administracyjnego.');
            }
            
            return redirect()->route('dashboard')->with('error', 'Brak uprawnień do tej sekcji.');
        }

        return $next($request);
    }
}
