<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CanManageEquipment
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login first.');
        }

        // Allow both admin and department staff
        if (!in_array(auth()->user()->role, ['admin', 'department'])) {
            abort(403, 'Unauthorized access. Admin or Department staff only.');
        }

        return $next($request);
    }
}