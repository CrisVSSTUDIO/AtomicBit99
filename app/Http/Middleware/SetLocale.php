<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    
    public function handle(Request $request, Closure $next): Response
    {
        // Get the locale from the request segment
        $locale = $request->segment(1);

        // Set a default locale (e.g., 'pt' for Portuguese)
        $defaultLocale = 'pt';

        // Store the selected locale in the session
        session()->put('locale', $locale ?? $defaultLocale);

        // Set the application locale
        App::setLocale(session('locale'));

        // Update the default URL locale
        URL::defaults(['locale' => session('locale')]);
        $request->route()->forgetParameter('locale');

        return $next($request);
    }
}
