<?php namespace Modules\Datamanager\Http\Controllers;

use Arxmin;
use Arxmin\helpers\DatacrudHelper;
use Arxmin\helpers\DatagridHelper;
use Arxmin\ModuleController;
use Input;
use Modules\Datamanager\Entities\Tag;

class TagController extends BaseController {

    public $layout = 'arxmin::layouts.admin';

    public $data = array();

    /**
     * Tag manager
     */
    public function anyIndex()
    {
        $title = 'Tag manager';

        $grid = DatagridHelper::source(Tag::orderBy('created_at'));

        $grid->title = '';

        $grid->add('name', trans("name"));
        $grid->add('created_at', trans("created_at"));
        $grid->add('updated_at', trans("updated_at"));
        $grid->addActions('tag/crud', trans("Actions"));

        $grid->link(moduleUrl("tag/crud?create=true"), __("Add a new Tag"), "TR");

        return $this->viewMake('arxmin::shared.datagrid', get_defined_vars());
    }

    /**
     * @param null $id
     * @return mixed
     */
    public function anyCrud($id = null){

        $title = 'Add a new tag';

        if (request()->has('show')) {
            $source = Tag::find(request()->get('show'));
        } elseif (request()->has('edit')) {
            $source = Tag::find(request()->get('edit'));
        } elseif (request()->has('delete')) {

            $source = Tag::find(request()->get('delete'));
            $source->delete();

            return redirect(moduleUrl('tag'))->with('flash', __('Tag deleted'));

        } else {
            $source = new Tag();
        }

        $form = DatacrudHelper::source($source);

        $form->title = 'Edit form';
        $form->link(moduleUrl("tag"), trans("Back to tags"), "TR")->back();
        $form->add('name', trans("name"), 'text')->rule('required');
        $form->add('lang', trans("lang"), 'text')->rule('required');

        return $this->viewMake('arxmin::shared.datacrud', get_defined_vars());
    }

}
