<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserHasLocation
{

    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        //If the user has no locations and is not on the creation page
        if ($user->locations->isEmpty() && !$request->routeIs('locations.create')) {
            return redirect()->route('locations.create')
                ->with('error', 'To start tracking weather insights in the Dashboard, please add your first location.');
        }

        return $next($request);
    }
}
