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
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // Vérifier si la session contient un employé et si son rôle correspond
        if ($request->session()->has('employe') && $request->session()->get('employe')[0]->role === $role) {
            return $next($request); // Continuer vers la route
        }

        // Si l'utilisateur n'a pas le bon rôle, rediriger vers une page de non-autorisation
        return redirect('/unauthorized'); // Vous pouvez personnaliser cette redirection
    }
}
