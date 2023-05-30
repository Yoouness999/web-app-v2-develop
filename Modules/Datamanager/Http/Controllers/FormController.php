<?php namespace Modules\Datamanager\Http\Controllers;

use Arxmin;
use Arxmin\helpers\DatacrudHelper;
use Arxmin\helpers\DatagridHelper;
use Arxmin\ModuleController;
use Input;
use Modules\Datamanager\Entities\Form;

class FormController extends BaseController
{
    public $layout = 'arxmin::layouts.admin';

    public $data = array();

    /**
     * Form manager
     */
    public function anyIndex()
    {
        $title = 'Forms manager';

        $grid = DatagridHelper::source(Form::orderBy('created_at'));

        $grid->title = '';

        $grid->add('title', trans("title"));
        $grid->add('description', trans("description"));
        $grid->add('manage', trans("manage"));
        $grid->add('created_at', trans("created_at"));
        $grid->add('updated_at', trans("updated_at"));
        $grid->addActions('form/crud', trans("Actions"));

        $grid->link(moduleUrl("/form/crud?create=true"), __("Add a new form"), "TR");

        return $this->viewMake('arxmin::shared.datagrid', get_defined_vars());
    }


    /**
     * @param null $id
     * @return mixed
     */
    public function anyCrud($id = null)
    {
        $title = 'Add a new form';

        if (request()->has('show')) {
            $source = Form::find(request()->get('show'));
        } elseif (request()->has('edit')) {
            $source = Form::find(request()->get('edit'));
        } elseif (request()->has('delete')) {
            $source = Form::find(request()->get('delete'));
            $source->delete();

            return redirect(moduleUrl('form'))->with('flash', __('Form deleted'));
        } else {
            $source = new Form();
            $source->type = 'form';
        }

        $form = DatacrudHelper::source($source);

        $form->title = 'Edit form';

        $form->link(moduleUrl("form"), trans("Back to forms"), "TR")->back();
        $form->add('title', trans("title"), 'text')->rule('required');
        $form->add('description', trans("description"), 'textarea')->rule('required');
        $form->add('manage', trans("manage"), 'textarea')->rule('required');
        $form->add('type', trans("Type"), 'text')->rule('required');

        return $this->viewMake('arxmin::shared.datacrud', get_defined_vars());
    }

}
