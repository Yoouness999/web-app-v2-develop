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

class RisksController extends BaseController {

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
}
