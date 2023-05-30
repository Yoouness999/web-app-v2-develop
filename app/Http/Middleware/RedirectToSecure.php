<?php namespace App\Http\Middleware;

use Closure;

/**
 * Secure
 * Redirects any non-secure requests to their secure counterparts.
 *
 * @param request The request object.
 * @param $next The next closure.
 * @return redirects to the secure counterpart of the requested uri.
 */
class RedirectToSecure
{

    public function handle($request, Closure $next)
    {
        if (!$request->secure() && LEVEL_ENV > 2 && !preg_match('/arxmin|elfinder/i', $request->getUri())) {
            return redirect(null, 301)->secure($request->getRequestUri());
        }

        return $next($request);
    }

}
