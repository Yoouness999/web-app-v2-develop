<?php namespace App\Http\Middleware;

use Closure, Session, Auth;
use Illuminate\Http\Request;

class RedirectLang {

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
        $isBot = isset($_SERVER['HTTP_USER_AGENT']) && preg_match('/bot|crawl|facebookexternalhit|Facebot|facebook|slurp|spider/i', $_SERVER['HTTP_USER_AGENT']);

        if ($isBot) {
            return $next($request);
        }

        if (!preg_match('/api/i', $request->getUri())) {

            $local = \App::getLocale();

            /**
             * If User has never been logged => it will be redirect to his local url
             */
            if(!Session::has('locale') && !$request->cookie('locale') && !$isBot)
            {
                $preferedLocal = $request->getPreferredLanguage($this->languages);

                if ($local !== $preferedLocal) {
                    Session::put('locale', $preferedLocal);
                    $url = ($request->isSecure()? 'https://': 'http://').\Config::get('app.locales.' . $preferedLocal . '.url');
                    // Forever store preferred language
                    return redirect($url.$request->getRequestUri(), 302, [], $request->isSecure())->withCookie(cookie()->forever('locale', Session::get('locale')));
                }
            }

            if ($request->has('force_locale')) {
                Session::put('locale', \App::getLocale());

                $user = $request->user();

                if ($user) {
                    $user->lang = app()->getLocale();
                    $user->save();
                }

                return $next($request)->withCookie(cookie()->forever('locale', Session::get('locale')));
            } elseif ($request->cookie('locale') && $request->cookie('locale') != $local) {
                $preferedLocal = $request->cookie('locale');
                Session::put('locale', $request->cookie('locale'));

                $url = ($request->isSecure()? 'https://': 'http://') .\Config::get('app.locales.' . $preferedLocal . '.url');

                return redirect($url.$request->getRequestUri(), 302, [], $request->isSecure())->withCookie(cookie()->forever('locale', Session::get('locale')));
            }
        }

        //app()->setLocale(Session::get('locale', 'en'));

        return $next($request);
    }

}
