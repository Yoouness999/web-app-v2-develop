<?php namespace Modules\Boxifymanager\Http\Controllers;

use App\Events\ItemUpdate;
use App\Item;
use Blok\Utils\Arr;
use Blok\Utils\Str;
use Arxmin\helpers\DatacrudHelper;
use Arxmin\helpers\DatagridHelper;
use Arxmin\ModuleController;
use HTML;
use Input;
use Session;
use Zofe\Rapyd\DataFilter\DataFilter;

class ItemsController extends BaseController
{

    public function anyIndex()
    {
        $title = 'Item manager';

        $filter = DataFilter::source(Item::with('user')->orderBy('updated_at', 'DESC'));

        //simple where with exact match
        $filter->add('id', 'ID', 'text')->clause('where')->operator('=');
        $filter->add('box_id', 'BY BOX ID', 'text')->clause('where')->operator('=');
        $filter->add('user_id', 'BY USER ID', 'text')->clause('where')->operator('=');

        $filter->submit('search');
        $filter->reset('reset');

        $grid = DatagridHelper::source($filter);

        $grid->title = '';
        $grid->add('<a href="items/crud?modify={{ $id }}">{{ $id }}</a>', trans("id"));
        $grid->add('box_id', trans("box id"));
        $grid->add('status', trans("status"));
        $grid->add('type', trans("type"));
        $grid->add('price', trans("price"));
        $grid->add('sealed_number', trans("sealed number"));
        $grid->add('weight', trans("weight"));
        $grid->add('<a href="users/crud?modify={{ $user_id }}">{{ $user->name }} (#{{$user_id}})</a>', 'User');
        $grid->add('type', trans("type"));
        $grid->add('updated_at', trans("updated at"));

        $grid->addActions(moduleUrl("items/crud"), trans("Actions"));
        //$grid->link(moduleUrl("items/crud?create=true"), __("Add a new item"), "TR");

        return $this->viewMake('boxifymanager::items-index', get_defined_vars());
    }

    /**
     * Scan qr code id
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function anyScan($id)
    {
        $item = Item::where('box_id', $id)->first();

        if ($item) {
            return redirect(moduleUrl('items/crud?modify=' . $item->id));
        }

        return redirect(moduleUrl('items/?search=1&box_id=' . $id));
    }


    /**
     * Handle item form process
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function anyCrud()
    {

        if (request()->has('show')) {
            $source = Item::find(request()->get('show'));
        } elseif (request()->has('modify')) {
            $source = Item::find(request()->get('modify'));
        } elseif (request()->has('update')) {
            $source = Item::find(request()->get('update'));
            // Fire update event
            event(new ItemUpdate($source, Input::all()));
        } elseif (request()->has('delete')) {
            $source = Item::find(request()->get('delete'));
            \Event::fire('ItemDelete', $source->toArray());
            $source->delete();
            return redirect(moduleUrl('items'));
        } else {
            $source = new Item;
        }

        if (request()->has('storage_date')) {
            $source->storage_date = request()->get('storage_date');
        }

        $form = DatacrudHelper::source($source);

        $title = '';

        $form->add('photo', 'Photo', 'image')->move($source->path())->preview(100, 100);


        if (request()->has('status')) {

            $redirect_back = moduleUrl('users/crud?tab=pickup&modify=' . $source->user_id . '&pickup_date=' . $source->pickup_date . '&item_success=' . $source->id);

            $status = request()->get('status');

            if ($status == Item::STATUS_STORED) {
                if ($source->picture_option) {
                    $instructions = [];
                    $instructions[] = "You must take a picture !";
                }
            }

            $form->add('status', trans('status'), 'select')->options(trans('items.status'))->updateValue($status);
        } else {
            $form->add('status', trans('status'), 'select')->options(trans('items.status'));
        }

        $fields = [
            'storage_date' => ['type' => 'date'],
            'box_id' => ['type' => 'text'],
            'picture_option' => ['type' => 'text'],
            'name' => ['type' => 'text'],
            'description' => ['type' => 'redactor'],
            'ending_date' => ['type' => 'datetime'],
            'pickup_date' => ['type' => 'datetime'],
            'user_id' => ['type' => 'text'],
            'price' => ['type' => 'text'],
            'sealed_number' => ['type' => 'text'],
            'storage_country' => ['type' => 'text'],
            'storage_warehouse' => ['type' => 'text'],
            'storage_floor' => ['type' => 'text'],
            'storage_row' => ['type' => 'text'],
            'storage_rack' => ['type' => 'text'],
            'storage_rack_floor' => ['type' => 'text'],
            'storage_pallet' => ['type' => 'text'],
            'updated_at' => ['type' => 'datetime'],
        ];

        foreach ($fields as $key => $field) {
            if ($field['type'] == 'date') {
                $form->add($key, @$field['name'] ?: trans($key), 'date')->format('Y-m-d', 'fr');
            } else {
                $form->add($key, @$field['name'] ?: trans($key), $field['type'] ?: 'text');
            }
        }

        if (request()->has('storage_date')) {
            $form->add('storage_date', 'storage_date', 'date')->format('Y-m-d', 'fr')->updateValue(request()->get('storage_date'));
        }


        return $this->viewMake('boxifymanager::items-edit', get_defined_vars());
    }
}
