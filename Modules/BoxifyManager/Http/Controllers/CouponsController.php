<?php namespace Modules\Boxifymanager\Http\Controllers;

use App;
use App\Coupon;
use App\User;
use Arxmin\helpers\DatacrudHelper;
use Arxmin\helpers\DatagridHelper;
use DataFilter;
use Input;

class CouponsController extends BaseController {

	public function anyIndex(){

		$title = 'Promocodes manager';
		$filter = DataFilter::source(Coupon::orderBy('updated_at'));
		//simple where with exact match
		$filter->add('id', 'Search by ID', 'text')->clause('where')->operator('=');
		$filter->submit('search');
		$filter->reset('reset');

		$grid = DatagridHelper::source($filter);

		$grid->title = '';

		$grid->add('<a href="coupons/crud?modify={{ $id }}">{{ $id }}</a>', trans("id"));
		$grid->add('<a href="coupons/crud?modify={{ $id }}">{{ $code }}</a>', trans("Promocode"));
		$grid->add('<a href="coupons/crud?modify={{ $id }}">-{{ $promo_applied }}€</a>', trans("Promo Applied"));
		$grid->add('<a href="coupons/crud?modify={{ $id }}">{{ $user_id }}</a>', trans("User_ID"));
		$grid->add('{{ $used }}', trans("Used"));

		$grid->addActions(moduleUrl("coupons/crud"), trans("Actions"));
        $grid->link(moduleUrl('/coupons/create'), __('Add a new coupon'), 'TR');

		return $this->viewMake('arxmin::shared.datagrid', get_defined_vars());
	}

    /**
     * Create Coupon form
     *
     * @param null $type
     * @return \Illuminate\View\View
     */
    public function anyCreate($type = null)
    {
        $source = new Coupon();

        $form = DatacrudHelper::source($source);

        $form->title = 'Create Promo';

        $form->add('code', trans("code"), 'text')->rule('required');
        //$form->add('user_id', trans("user_id"), 'text');
        $form->add('promo_applied', trans("Amount"), 'text')->rule('required');
        $form->add('expiry_date', trans("Expiration date"), 'datetime')->rule('required');

        return $this->viewMake('arxmin::shared.datacrud', get_defined_vars());
    }

	public function anyCrud(){

		if (request()->has('show')) {
			$source = Coupon::find(request()->get('show'));
		} elseif (request()->has('modify')) {
			$source = Coupon::find(request()->get('modify'));
		}  elseif (request()->has('delete')) {
			$source = Coupon::find(request()->get('delete'));
			$source->delete();
			return redirect(moduleUrl('coupons'));
		} else {
			$source = new Coupon;
		}

		$title = '';

		$form = DatacrudHelper::source($source);

        $form->add('code', trans("code"), 'text')->rule('required');
        $form->add('promo_applied', trans("Amount"), 'text')->rule('required');
        $form->add('expiry_date', trans("Expiration date"), 'datetime')->rule('required');

		$form->link(moduleUrl('coupons'), trans("Back"), "TR")->back();

		return $this->viewMake('arxmin::shared.datacrud', get_defined_vars());
	}

}
