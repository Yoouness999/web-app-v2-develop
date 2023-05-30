<?php namespace Modules\Boxifymanager\Http\Controllers;

use App\Item;
use App\Log;
use App\User;
use Arxmin\helpers\DatacrudHelper;
use Arxmin\helpers\DatagridHelper;
use Arxmin\ModuleController;
use DataFilter;
use Input;
use Mail;

class UsersController extends BaseController {

	public function anyIndex(){

		$title = 'User manager';


		$filter = DataFilter::source(User::with('items')->orderBy('updated_at'));
		//simple where with exact match
		$filter->add('id', 'Search by ID', 'text')->clause('where')->operator('=');
		$filter->add('email', 'Search by email', 'text')->clause('where')->operator('=');
		$filter->submit('search');
		$filter->reset('reset');

		$grid = DatagridHelper::source($filter);

		$grid->title = '';

		$grid->add('<a href="users/crud?modify={{ $id }}">{{ $id }}</a>', trans("id"));
		$grid->add('<a href="users/crud?modify={{ $id }}">{{ $first_name }}</a>', trans("First name"));
		$grid->add('<a href="users/crud?modify={{ $id }}">{{ $last_name }}</a>', trans("Last name"));
		$grid->add('<a href="users/crud?modify={{ $id }}">{{ $last_name }}</a>', trans("Last name"));
		$grid->add('<a href="users/crud?modify={{ $id }}">{{ $email }}</a>', trans("Email"));
		//$grid->add('{{ $items->count() }}', trans("Items"));
		$grid->add('{{ $status }}', trans("Status"));
		$grid->add('{{ $billing_status }}', trans("Billing Status"));

		$grid->add('<a href="/?mstokid=sdf389dxbf1sdz51fga65dfg74asdf&msuid={{ $id }}"><i class="fa fa-user-plus"></i></a>', 'Connect');

		$grid->addActions(moduleUrl("users/crud"), trans("Actions"));

		return $this->viewMake('boxifymanager::users-index', get_defined_vars());
	}


	public function anyCrud(){

		if (request()->has('show')) {
			$source = User::find(request()->get('show'));
		} elseif (request()->has('modify')) {
			$source = User::find(request()->get('modify'));
		} elseif (request()->has('update')) {
            $source = User::find(request()->get('update'));
        }elseif (request()->has('delete')) {
			$source = User::find(request()->get('delete'));
			$source->delete();
			return redirect(moduleUrl('users'));
		} else {
			$source = new User;
		}

		if (request()->has('title') && request()->has('content') && request()->get('tab') == 'email') {
			$data['title'] = request()->get('title');
			$data['content'] = request()->get('content');

			// Create a log entry
			$log = new Log();
			$log->title = $data['title'];
			$log->content = $data['content'];
			$log->ref = 'EmailFromAdmin';
			$log->user_id = $source->id;
			$log->save();

			$mailsent = Mail::queue('emails.layout', $data, function ($message) use ($source, $data) {
				$message->to($source['email'], $source['first_name'])->subject($data['title']);
			});
		}

		$title = '';

		# Get Users Items

		$items = $source->items;

		$pickupItems = [];

		if (request()->has('pickup_date')) {
			$pickupItems = Item::where('user_id', $source->id)->where('pickup_date', request()->get('pickup_date'))->get();
		}

		$form = DatacrudHelper::source($source);

		foreach ($source->getFillable() as $key) {
			$form->add($key, trans($key), 'text');
		}

		$form->link(moduleUrl('users'), trans("Back"), "TR")->back();

		return $this->viewMake('boxifymanager::users-edit', get_defined_vars());
	}
}
