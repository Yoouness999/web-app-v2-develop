<?php namespace Modules\Boxifymanager\Http\Controllers;

use \App\Item;
use \App\User;
use Modules\Boxifymanager\Http\Requests\Request;

class BoxifyManagerController extends BaseController {

	/**
	 * Dashboard page
	 *
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function anyIndex()
	{
		$actionsForToday = Item::where('status', '!=', Item::STATUS_STORED)
			->where('pickup_date', 'LIKE', date('Y-m-d') . '%')
			->orderBy('pickup_date', 'ASC')
			->groupBy('pickup_date')
			->paginate(10);

		$actionsToCome = Item::where('status', '!=', Item::STATUS_STORED)
			->where('pickup_date', '>', date('Y-m-d', strtotime('+1 day')).' 00:00:00')
			->orderBy('pickup_date', 'ASC')
			->paginate(10);

		$customerToCheck = User::where('billing_status', User::BILLING_STATUS_UNPAID)->paginate(10);

		return $this->viewMake('boxifymanager::dashboard', get_defined_vars());
	}

	/**
	 * Import user from an Excel
	 * @param Request $request
	 * @return
	 */
	public function anyImport(Request $request){

		if ($request->has('user_id')) {

			$items = [];
			$results = [];
			$errors = false;

			if ($request->hasFile('file')) {
                $items = $request->get('items');
			} elseif($request->has('items')) {
                $items = $request->get('items');
			}

			if (count($items)) {

				foreach ($items as $item) {
					$data = $item;
                    $data['name'] = @$item['description'] ?: trans('types.'.$item['type'].'.name');
					$data['user_id'] = $request['user_id'];
                    $data['pickup_date'] = date('Y-m-d H:i:s');
                    $data['storage_date'] = date('Y-m-d');
                    $data['status'] = Item::STATUS_STORED;
                    $item = Item::create($data);
                    $results[] = $item->toArray();
				}

                $success = true;
			} else {
				$errors = true;
			}

            return response()->json($results);
		}

        $types = [];

        foreach(trans('types') as $key => $type){
            $types[$key] = $type['name'];
        }

        $usersInfo = collect(User::orderBy('id', 'ASC')->get()->toArray())->keyBy('id');
        $users = User::orderBy('id', 'ASC')->get()->pluck('name', 'id');

        foreach ($users as $key => $name){
            $users[$key] = $key .' - '.$name;
        }

		return $this->viewMake('boxifymanager::import', get_defined_vars());
	}

	/**
	 * Import user from an Excel
	 */
	public function anyStats(){
		return $this->viewMake('boxifymanager::stats', get_defined_vars());
	}

	/**
	 * QR Code generator page
	 *
	 * @return \Illuminate\View\View
	 */
	public function anyQrcode(){
		return $this->viewMake('boxifymanager::qrcode', get_defined_vars());
	}
}
