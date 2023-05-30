<?php

namespace Modules\Datamanager\Traits;

use Blok\Utils\Arr;
use View;
use Illuminate\Http\Request;
use Request as Req;

trait DataControllerTrait
{
    /**
     * Return view if method not found
     *
     * @deprecated find a better solution to missingMethod in 5.2
     *
     * @param array $param
     * @return \Illuminate\View\View
     */
    public function missingMethod($param = array())
    {
        return $this->anyView(app('request'));
    }

    /**
     * Data post solver
     *
     * @param Request $request
     * @return \Illuminate\View\View
     * @internal param Request $request
     */
    public function anyIndex(Request $request)
    {
        $type = Datamanager::guessPostType();
        $types = str_plural($type);

        $data = Datamanager::getByType($request->segment(1));

        $tpl = $types . ".index";

        return $this->viewMake($tpl, get_defined_vars());
    }

    /**
     * Return View
     *
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function anyView(Request $request)
    {

        $request->session()->flush();

        $data = Datamanager::getBySlug($request->getUri());

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
