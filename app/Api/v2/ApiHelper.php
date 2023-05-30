<?php

/*
 * APi Helper
 *
 * $ php artisan apidocs:generate
 */

namespace App\Api\v2;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Response;
use Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ApiHelper
{
    /**
     * Response wrapper helper
     *
     * @param mixed $data
     * @param int $status
     * @param string $message
     *
     * @return Response
     */
    public static function response($data, $status = 200, $message = 'OK')
    {
		return new Response([
            'data' => $data,
            'status' => $status,
            'message' => $message
        ], $status);
    }

    /**
     * Get helper
     *
     * @param $query
     * @param array $params
     *
     * @return array
     */
    public static function get($query, $params = [])
    {
        /**
         * @var $query Builder
         */
        $itemsTotalCount = null;

        if (isset($params['filters'])) {
			$query = $query->where(function($query) use ($params) {
				foreach ($params['filters'] as $filter) {

					if (!isset($filter['operator'])) {
						$filter['operator'] = '=';
					}

					if (isset($filter['whereType']) && strtolower($filter['whereType']) === 'or') {
						$query->orWhere($filter['attribute'], $filter['operator'], $filter['value']);
					} else {
						$query->where($filter['attribute'], $filter['operator'], $filter['value']);
					}
				}
			});
        }

        if (isset($params['order'])) {
            if (!isset($params['order']['way'])) {
                $params['order']['way'] = 'asc';
            }

            $query = $query->orderBy($params['order']['attribute'], $params['order']['way']);
        } else {
            $query = $query->orderBy('id', 'desc');
        }

        if (isset($params['pagination'])) {
            $itemsTotalCount = $query->count();

            if (!isset($params['pagination']['page'])) {
                $params['pagination']['page'] = 1;
            }

            if (!isset($params['pagination']['items_by_page'])) {
                $params['pagination']['items_by_page'] = $itemsTotalCount;
            }

            $items = $query->limit($params['pagination']['items_by_page'])
                ->offset(($params['pagination']['page'] - 1) * $params['pagination']['items_by_page'])
                ->get();

			if (isset($params['restricted'])) {
				foreach ($items as $i => $item) {
					if (method_exists($item, 'toArrayApi')) {
						$items[$i] = $item->toArrayApi($params['deep']);
					}
				}
			}

            return [
                'items' => $items,
                'page' => $params['pagination']['page'],
                'items_by_page' => $params['pagination']['items_by_page'],
                'items_total_count' => $itemsTotalCount
            ];
        }

		$items = $query->get();

        if (isset($params['restricted'])) {
            foreach ($items as $i => $item) {
                if (method_exists($item, 'toArrayApi')) {
                    $items[$i] = $item->toArrayApi($params['deep']);
                }
            }
        }

        if (isset($params['first'])) {
            return $items->first();
        }

        return $items;
    }

    /**
     * Get params from request
     *
     * @param Illuminate\Http\Request $request
     *
     * @return array
     */
    public static function getParamsFromRequest($request)
    {
        $params = ['restricted' => true];

        if ($request->has('filters')) {
            $filters = explode(';', $request->get('filters'));

            foreach ($filters as $filter) {
                $filter = explode(':', $filter);

                $whereType = 'AND';

                if (count($filter) == 4) {
                    list($whereType, $attribute, $operator, $value) = $filter;
                } elseif (count($filter) == 3) {
                    list($attribute, $operator, $value) = $filter;
                } else {
                    list($attribute, $value) = $filter;
                    $operator = '=';
                }

                $params['filters'][] = [
                    'attribute' => $attribute,
                    'operator' => $operator,
                    'value' => $value,
                    'whereType' => $whereType
                ];
            }
        }

        if ($request->has('order')) {
            if (strpos($request->get('order'), ':') === false) {
                $params['order']['attribute'] = $request->get('order');
            } else {
                list($params['order']['attribute'], $params['order']['way']) = explode(':', $request->get('order'));
            }
        }

        if ($request->has('page')) {
            $params['pagination']['page'] = $request->get('page');
        }

        if ($request->has('items_by_page')) {
            $params['pagination']['items_by_page'] = $request->get('items_by_page');
        }

        if (isset($request->all()['first'])) {
            $params['first'] = true;
        }

        $params['deep'] = 1;
        if ($request->has('deep')) {
            $params['deep'] = $request->get('deep');;
        }

        return $params;
    }

    /**
     * Get files from request
     *
     * @param array $params
     *
     * @return array files
     */
    public static function uploadFiles($modelName, $modelId)
    {
        $files = [];

        foreach (Request::all() as $key => $value) {
            if ($value instanceof UploadedFile && Request::file($key)->isValid()) {
                $path = '/files/' . $modelName . '/' . $modelId . '/';
                $destinationPath = public_path($path);

                $originalName = explode('.', $value->getClientOriginalName());
                $fileName = $key . '.' . end($originalName);

                Request::file($key)->move($destinationPath, $fileName);
                $files[$key] = $path . $fileName;
            }
        }

        return $files;
    }

    /**
     * Delete files from request
     *
     * @param $file
     * @param $modelName
     * @param $modelId
     * @return bool
     * @internal param array $params
     *
     */
    public static function deleteFile($file, $modelName, $modelId)
    {

        $file = str_replace(url('/'), '', $file);

        $path = '/files/' . $modelName . '/' . $modelId;

        # Check if the file is related to model id
        if (preg_match('/' . preg_quote($path, '/') . '/i', $file)) {

            # Fix error of double // path (just in case of)
            $file = str_replace('//', '/', public_path($file));

            if ($response = unlink($file)) {
                return true;
            }
        }

        return false;
    }
}
