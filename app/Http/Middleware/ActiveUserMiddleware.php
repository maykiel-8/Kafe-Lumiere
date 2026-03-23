<?php
// app/Http/Middleware/ActiveUserMiddleware.php
namespace App\Http\Middleware;
 
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
 
class ActiveUserMiddleware
{
    /**
     * Block inactive users from accessing the application.
     * Applied globally to all authenticated + verified routes.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->status === 'inactive') {
            auth()->logout();
            return redirect()->route('login')
                ->withErrors(['email' => 'Your account has been deactivated. Contact your administrator.']);
        }
 
        return $next($request);
    }
}
