<?php namespace App\Http\Middleware;

use Closure, Session, Auth;
use Illuminate\Http\Request;

class ForceLangByParam {

    /**
     * The availables languages.
     *
     * @array $languages
     */
    protected $languages = ['en','fr', 'nl'];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->has('locale') && in_array($request->get('locale'), $this->languages)) {
            app()->setLocale($request->get('locale'));
            unset($request['locale']);
        }

        return $next($request);
    }

}
