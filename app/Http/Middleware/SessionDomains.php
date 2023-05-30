<?php

namespace App\Http\Middleware;

use Closure;
use Request;

class SessionDomains
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->getHost() === 'fr.boxify.be') {
            config([
                'session.domain' => '.fr.boxify.be',
            ]);
        } elseif ($request->getHost() === 'nl.boxify.be') {
            config([
                'session.domain' => '.nl.boxify.be',
            ]);
        } elseif ($request->getHost() === 'en.boxify.be') {
            config([
                'session.domain' => '.en.boxify.be',
            ]);
        }

        return $next($request);
    }
}
