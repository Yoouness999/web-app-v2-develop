<?php

/*
 * APi Helper
 *
 * $ php artisan apidocs:generate api/v3
 */

namespace App\Api\v3;

use App;
use App\Item;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Response;
use Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Pickup;
use Config;

class ApiHelper {
	/**
	 * Response wrapper helper
	 *
	 * @param mixed $data
	 * @param int $status
	 *
	 * @return array
	 */
	public static function response($data, $status = 200) {
		return new Response($data, $status);
	}

	/**
	 * Get helper
	 *
	 * @param \Illuminate\Database\Eloquent\Builder $query
	 * @param array $params
	 *
	 * @return \Illuminate\Support\Collection
	 */
	public static function get($query, $params = []) {
		if (isset($params['filters'])) {
			foreach ($params['filters'] as $filter) {
				if (!isset($filter['operator'])) {
					$filter['operator'] = '=';
				}

				$query = $query->where($filter['attribute'], $filter['operator'], $filter['value']);
			}
		}

		if (isset($params['order'])) {
			if (!isset($params['order']['way'])) {
				$params['order']['way'] = 'asc';
			}

			$query = $query->orderBy($params['order']['attribute'], $params['order']['way']);
		}


		$itemsTotalCount = null;

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
                    $items[$i] = $item->toArrayApi();
                }
            }
        }

		if (isset($params['pagination'])) {
			return [
				'items' => $items,
				'page' => $params['pagination']['page'],
				'items_by_page' => $params['pagination']['items_by_page'],
				'items_total_count' => $itemsTotalCount
			];
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
	public static function getParamsFromRequest($request) {
		$params = ['restricted' => true];

		if ($request->has('lang')) {
			App::setLocale($request->get('lang'));
		}

		if ($request->has('filters')) {
			$filters = explode(';', $request->get('filters'));

			foreach ($filters as $filter) {
				$filter = explode(':', $filter);

				if (count($filter) == 3) {
					list($attribute, $operator, $value) = $filter;
				} else {
					list($attribute, $value) = $filter;
					$operator = '=';
				}

				$params['filters'][] = [
					'attribute' => $attribute,
					'operator' => $operator,
					'value' => $value
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
    public static function uploadBase64Files($modelName, $modelId, array $files)
    {
        $toReturn = [];

        foreach ($files as $key => $file) {
            //data name type
            if (array_key_exists('data', $file) && array_key_exists('name', $file) && array_key_exists('type', $file)) {
                $path = '/files/'.$modelName.'/'.$modelId.'/';
            }


            if (!file_exists(Config::get('app.boxify_project_folder')  . $path)) {
                mkdir(Config::get('app.boxify_project_folder') .$path, 0777, true);
            }

            $originalName = explode('.', $file['name']);
            $fileName = $key.'.'.end($originalName);

            $f = finfo_open();
            $mime_type = finfo_buffer($f, base64_decode($file['data']), FILEINFO_MIME_TYPE);

            if ($mime_type === 'image/png' || $mime_type === 'image/jpeg' || $mime_type === 'image/jpg' || $mime_type === 'application/octet-stream') {
                $toReturn[] = $path.$fileName;

                try {
                    file_put_contents(public_path($path).$fileName, file_get_contents('data:image/png;base64,'.$file['data']));
                } catch (\Exception $e) {
                    try {
                        file_put_contents(public_path($path).$fileName, file_get_contents($file['data']));
                    } catch (\Exception $e) {
                        \Log::error('error to upload file', [$e->getMessage()]);
                    }
                }

                if ($modelName == 'pickups') {
                    $pickup = Pickup::find($modelId);
                    $pickup->sign_photo = $path.$fileName;
                    $pickup->save();
                }

                if ($modelName == 'items') {
                    $item = Item::find($modelId);
                    $item->photo = $path.$fileName;
                    $item->save();
                }

            }
        }

        return $toReturn;
    }

	/**
	 * Get files from request
	 *
	 * @param array $params
	 *
	 * @return array files
	 */
	public static function uploadFiles($modelName, $modelId) {
		$files = [];

		foreach (Request::all() as $key => $value) {
			if ($value instanceof UploadedFile && Request::file($key)->isValid()) {
				$path = '/files/' . $modelName . '/' . $modelId . '/';
				$destinationPath = public_path($path);

                if (!file_exists('/home/boxify/web/prod/public' . $path)) {
                    mkdir('/home/boxify/web/prod/public' .$path, 0777, true);
                }

				$originalName = explode('.', $value->getClientOriginalName());
				$fileName = $key . '.' . end($originalName);

				Request::file($key)->move($destinationPath, $fileName);
				$files[$key] = $path . $fileName;

                /**
                 * If upload file is an item and key = photo => need to save it in db
                 */
                if ($modelName == 'items' && $key == 'photo') {
                    $item = Item::find($modelId);
                    $item->photo = $files[$key];
                    $item->save();
                }

                if ($modelName == 'users' && $key == 'photo') {
                    $item = User::find($modelId);
                    $item->photo = $files[$key];
                    $item->save();
                }
			}
		}

		return $files;
	}
}
