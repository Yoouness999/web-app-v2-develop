<?php namespace Modules\Datamanager\Http\Controllers;

use App;
use Arx\BootstrapHelper;
use Arxmin;
use Arxmin\helpers\DatacrudHelper;
use Arxmin\helpers\DatagridHelper;
use Arxmin\ModuleController;
use Input;
use Modules\Datamanager\Entities\Menu;
use Zofe\Rapyd\Facades\DataTree;

class MenuController extends BaseController {

	public function anyIndex(Menu $oMenu)
	{
		$title = 'Menus manager';

		$grid = DatagridHelper::source($oMenu->orderBy('updated_at'));

		$grid->title = '';

		$grid->add('name', trans("name"));
		$grid->add('uri', trans("uri"));
		$grid->add(BootstrapHelper::btn(moduleUrl('menu/tree/{{ $id }}'), 'structure'), trans("Structure"));
		$grid->addActions(moduleUrl("menu/crud"), trans("Actions"));

		$grid->link(moduleUrl("menu/crud?create=true"), __("Add a new Menu"), "TR");

		return $this->viewMake('arxmin::shared.datagrid', get_defined_vars());
	}

	public function anyTree($id){

		Menu::rebuild(true);

		$root = Menu::find($id) or App::abort(404);

		$tree = DataTree::source($root);
		$tree->add('name');
		$tree->add('uri');
		$tree->edit(moduleUrl("menu/crud"), 'Edit', 'modify|delete');
		$tree->submit('Save the order');

		return $this->viewMake('datamanager::menu-tree', get_defined_vars());
	}

	public function anyCrud(){

		$title = 'Add a new menu';

		if (request()->has('show')) {
			$source = Menu::find(request()->get('show'));
		} elseif (request()->has('modify')) {
			$source = Menu::find(request()->get('modify'));
		} elseif (request()->has('delete')) {
			$source = Menu::find(request()->get('delete'));
			$source->delete();
			return redirect(moduleUrl('menu'))->with('flash', __('Menu deleted'));
		} else {
			$source = new Menu;
		}

		$form = DatacrudHelper::source($source);

		$form->title = 'Edit menu';

		foreach ($source->getFillable() as $key) {
			$form->add($key, trans($key), 'text');
		}

		$form->addSelect('lang', 'lang')->options(Arxmin::getLocales('select'));

		$form->add('primary', 'primary', 'checkbox');

		if (request()->has('parent_id')) {
			$form->add('parent_id', 'Parent ID', 'text')->insertValue(request()->get('parent_id'));  //or
		}

		$treeUrl = '';

		if ($source->parent_id) {
			$treeUrl .= '/tree/'.$source->parent_id;
		}

		$form->link(moduleUrl('menu').$treeUrl, trans("Back"), "TR")->back();

		return $this->viewMake('arxmin::shared.datacrud', get_defined_vars());
	}

}
