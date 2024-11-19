<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Stevebauman\Location\Facades\Location;
use Symfony\Component\HttpFoundation\Response;

class GeoRestriction
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $position = Location::get($request->ip());
        if ($position) {
            $allowedCountries = ['USA', 'UK'];
            $userCountry = $position->countryCode;
            if (!in_array($userCountry, $allowedCountries)) {
                return redirect()->route('geo-restricted');
            }
        } else {
            return redirect()->route('geo-location-error');
        }
        return $next($request);
    }
}
