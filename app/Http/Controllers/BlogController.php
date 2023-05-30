<?php namespace App\Http\Controllers;

use Blok\Utils\Arr;
use Illuminate\Http\Request;

use Modules\Datamanager\Traits\DataControllerTrait;
use Modules\Datamanager\Datamanager;
use Modules\Datamanager\Entities\Post;
use Blok\Utils\Str;

class BlogController extends Controller
{
    public $data = array();
    use DataControllerTrait;

    public function anyIndex(Request $request)
    {
        $type = Datamanager::guessPostType();

        $data = Datamanager::getByType($request->segment(1), ['format' => 'object', 'current_lang' => true, 'hide_if_not_published' => true]);

        $types = str_plural($type);
        $tpl = $types . ".index";

        return $this->viewMake($tpl, get_defined_vars());
    }

    /**
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function anySearch(Request $request)
    {
        $type = Datamanager::guessPostType();

        $data = Post::where('type', 'post')->where('lang', app()->getLocale())->where('published_at', '<=', date('Y-m-d H:i:s', time()));

        if ($request->has('q')) {
            $data = $data->where(function ($query) use ($request) {
                /** @var $query Illuminate\Database\Query\Builder */
                return $query->where('title', 'LIKE', '%' . $request->get('q') . '%')->orWhere('content', 'LIKE', '%' . $request->get('q') . '%');
            });
        }

        /**
         * @TODO check structure for that ?
         */
        if ($request->has('cat')) {

        }

        $data = $data->get();

        $types = str_plural($type);
        $tpl = $types . ".index";

        return $this->viewMake($tpl, get_defined_vars());
    }

    public function anyView(Request $request)
    {
        $data = Datamanager::getInstance()->post->where('slug', $request->getPathInfo())->first();

        if (!$data) {
            $data['title'] = '404';
            $data['name'] = 'Page not found';
            return response()
                ->view('errors.404', $data, 404);
        }

        $data = $data->toArray();

        $slug = Str::mustBeginWith('/', str_replace([url('/')], "", $request->getUri()));

        if (!$data) {
            // If not found => try to load data from lang
            $segments = $request->segments();
            $types = str_plural($segments[0]);
            $segments[0] = $types;
            $labelref = implode('/', $segments);
            $data = \Lang::get($labelref);

            // If not found => trigger not found error
            if ($data == $labelref) {
                app()->abort(404);
            }

            $data['id'] = null;
            $data['template'] = str_replace('/', '.', $labelref);

        } elseif ($data['slug'] != $slug) {
            return redirect($data['slug']);
        } else {
            $types = $data['types'];

            // Try to merge data by ref if it exist
            if ($data['ref']) {
                $label = \Lang::get($data['ref']);
                if (is_array($label)) {
                    $data = Arr::merge($label, $data);
                }
            }
        }

        if (\View::exists($tpl = $data['template'])) {
            return $this->viewMake($tpl, $data);
        } elseif (\View::exists($tpl = $types . '.view-' . $data['id'])) {
            return $this->viewMake($tpl, $data);
        } elseif (\View::exists($tpl = $types . '.view')) {
            return $this->viewMake($tpl, $data);
        } else {
            $tpl = $types;
        }

        return $this->viewMake($tpl, $data);
    }


}
