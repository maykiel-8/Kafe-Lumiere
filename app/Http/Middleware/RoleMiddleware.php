<?php
// app/Http/Middleware/RoleMiddleware.php
namespace App\Http\Middleware;
 
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
 
class RoleMiddleware
{
    /**
     * Restrict route access by user role.
     *
     * Usage:  Route::middleware('role:admin')
     *         Route::middleware('role:admin,cashier')
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
 
        if (!in_array(auth()->user()->role, $roles)) {
            abort(403, 'You are not authorized to access this area.');
        }
 
        return $next($request);
    }
}
