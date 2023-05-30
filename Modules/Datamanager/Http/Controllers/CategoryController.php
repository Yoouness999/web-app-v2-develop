<?php namespace Modules\Datamanager\Http\Controllers;

use App;
use Arx\BootstrapHelper;
use Arx\classes\Date;
use Arxmin;
use Arxmin\helpers\DatacrudHelper;
use Arxmin\helpers\DatagridHelper;
use Arxmin\ModuleController;
use Input;
use Modules\Datamanager\Entities\Category;
use Zofe\Rapyd\Facades\DataTree;

class CategoryController extends BaseController {

    public $layout = 'arxmin::layouts.admin';

    public $data = array();

    /**
     * Category list
     */
    public function anyIndex()
    {
        $title = 'Category manager';

        $grid = DatagridHelper::source(Category::orderBy('created_at'));

        $grid->title = '';

        $grid->add('name', trans("name"));
        $grid->add('parent_id', trans("parent_id"));
        $grid->add(BootstrapHelper::btn(moduleUrl('category/tree/{{ $id }}'), 'structure'), trans("Structure"));
        $grid->addActions('category/crud', trans("Actions"));

        $grid->link(moduleUrl("category/crud?create=true"), __("Add a new category"), "TR");

        return $this->viewMake('arxmin::shared.datagrid', get_defined_vars());
    }

    /**
     * Category tree editor
     *
     * @param $id
     * @return \Illuminate\View\View
     */
    public function anyTree($id)
    {
        $title = 'Category manager';

        // load the root model
        $root = Category::find($id) or App::abort(404);

        $tree = DataTree::source($root);
        $tree->add('name');
        $tree->edit(moduleUrl('category/crud'), 'Edit', 'modify|delete');
        $tree->link(moduleUrl('category/crud?parent_id='.$id), 'Create', "BR", array(
            'class' => 'btn btn-primary'
        ));
        $tree->submit('Save the order');

        return $this->viewMake('datamanager::data-tree', get_defined_vars());
    }

    /**
     * @param null $id
     * @return mixed
     */
    public function anyCrud($id = null){

        $title = '';

        if (request()->has('show')) {
            $source = Category::find(request()->get('show'));
        } elseif (request()->has('edit')) {
            $source = Category::find(request()->get('edit'));
        } elseif (request()->has('delete')) {

            $source = Category::find(request()->get('delete'));
            $source->delete();

            return redirect(moduleUrl('category'))->with('flash', __('Category deleted'));

        } else {
            $source = new Category();
        }

        $form = DatacrudHelper::source($source);

        $form->title = 'Add a new category';

        $form->add('name', trans("name"), 'text')->rule('required');


        $treeUrl = '';

        if (request()->has('parent_id')) {
            $form->add('parent_id', 'Parent ID', 'text')->insertValue(request()->get('parent_id'));
            $treeUrl .= '/tree/'.request()->get('parent_id');
        }

        $form->link(moduleUrl('category').$treeUrl, trans("Back to categories"), "TR");

        return $this->viewMake('arxmin::shared.datacrud', get_defined_vars());
    }

}
