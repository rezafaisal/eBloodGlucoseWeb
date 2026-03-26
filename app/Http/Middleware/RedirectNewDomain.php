<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectNewDomain
{
    public function handle(Request $request, Closure $next)
    {
        if (str_contains($request->getHost(), 'temandigital.cloud')) {
            $newUrl = str_replace('temandigital.cloud', 'temanmomen.com', $request->fullUrl());
            return redirect()->away($newUrl, 301);
        }

        return $next($request);
    }
}
