<?php namespace Modules\Datamanager\Http\Controllers;

use App;
use Arx\BootstrapHelper;
use Arxmin;
use Arxmin\helpers\DatacrudHelper;
use Arxmin\helpers\DatagridHelper;
use DataFilter;
use Hook;
use HTML;
use Modules\Datamanager\Datamanager;
use Modules\Datamanager\Entities\Category;
use Modules\Datamanager\Entities\Form;
use Modules\Datamanager\Entities\Tag;
use Input;
use Modules\Datamanager\Entities\Post;
use Modules\Datamanager\Events\onRedirectPost;

class DataController extends BaseController
{
    const PER_PAGE = '20';
    public $layout = 'arxmin::layouts.admin';
    public $data = array();


    public function __construct()
    {
        parent::__construct();

        $this->post = new Post();

        Hook::put('__app.api_url', moduleUrl('api') . '/', true);
    }


    /**
     * Form manager
     */
    public function anyIndex()
    {
        $type = request()->get('type');

		$data = Post::where('type', $type)->orderBy('published_at', 'DESC');

		/* Filter configuration
         ---------------------------------------------- */
		$filter = DataFilter::source($data);

		$filter->add('type', null, 'hidden')->insertValue($type);

		$filter->add('id', __('Search by ID'), 'text')->scope(function ($query, $value) {
			if ($value == '') {
				return $query;
			}

			return $query->where('id', $value);
		});

		$filter->add('lang', null, 'select')->options([
			'' => __('Search by language'),
			'en' => __('English'),
			'fr' => __('French'),
			'nl' => __('Dutch')
		])->scope(function ($query, $value) {
			if ($value == '') {
				return $query;
			}

			return $query->where('lang', $value);
		});

		$filter->add('tags', __('Search by tag'), 'text')->scope(function ($query, $value) {
			if ($value == '') {
				return $query;
			}

			return $query->whereHas('tags', function($query) use ($value) {
				$query->where('name', $value);
			});
		});

		$filter->add('categories', __('Search by category'), 'text')->scope(function ($query, $value) {
			if ($value == '') {
				return $query;
			}

			return $query->whereHas('categories', function($query) use ($value) {
				$query->where('name', $value);
			});
		});

		$filter->submit('search');
		$filter->reset('reset');

        /* Grid configuration
         ---------------------------------------------- */
        $grid = DatagridHelper::source($filter)->attributes(['class' => 'table table-bordered table-striped']);

        $grid->add('id', trans('ID'))->style('width: 30px');
        $grid->add('<a href="' . moduleUrl('data/edit/{{ $id }}') . '">{{ $title }}</a>', trans('Title'));
		$grid->add('<a href="' . moduleUrl('data/edit/{{ $id }}') . '">{{ $slug }}</a>', trans('Slug'));

        $grid->add('lang', trans('Language'))->style('width: 20px');
		$grid->add('published_at', trans('Published at'))->style('width: 150px');
		$grid->add('created_at', trans('Created at'))->style('width: 150px');

        $grid->add(
            '<div class="btn-group btn-group-sm">'
            . '<a class="btn btn-default" href="' . moduleUrl('data/edit/{{ $id }}') . '" target="_blank" title="' . trans('Edit') . '" data-toggle="tooltip"><i class="fa fa-pencil"></i></a>'
            . '<a class="btn btn-info" href="' . moduleUrl('data/redirect/{{ $id }}') . '" target="_blank" title="' . trans('View') . '" data-toggle="tooltip"><i class="fa fa-eye"></i></a>'
            . '<a class="btn btn-danger" href="' . moduleUrl('data/delete/{{ $id }}') . '" target="_blank" title="' . trans('Delete') . '" data-toggle="tooltip" data-confirm="' . __('Are you sure?') . '"><i class="fa fa-trash"></i></a>'
            . '</div>',
            trans('Actions')
        )->style('width: 120px');

        // @TODO Show create button only if $user->role is 'admin'
        $grid->link(moduleUrl('/data/create/' . $type), __('Add a new ' . $type), 'TR');

        $grid->paginate(self::PER_PAGE);


        /* Prepare render
         ---------------------------------------------- */
        $title = ucfirst(str_plural($type));

        return $this->viewMake('datamanager::list', get_defined_vars());
    }

    /**
     * Create a new post
     */
    public function anyCreate($type = null, $lang = 'en', $post_linked = null)
    {
        $source = new Post();
        $source->type = $type;
        $source->slug = '';
        $source->lang = $lang;
		$source->published_at = date('Y-m-d H:i:s');
		$source->save();

		if ($post_linked) {
			$postLinked = Post::find($post_linked);

			foreach ($postLinked->postsLinked()->get() as $subPostLinked) {
				$source->postsLinked()->attach($subPostLinked);
				$subPostLinked->postsLinked()->attach($source);
			}

			$source->postsLinked()->attach($postLinked);
			$postLinked->postsLinked()->attach($source);
		}

		return redirect(moduleUrl('data/edit/' . $source->id))->with('notify', lg('Post created'));
    }

    /**
     * Delete post
     *
     * @param $id
     * @return mixed
     */
    public function anyDelete($id)
    {
        $source = Post::find($id);

        if ($source) {
            $source->delete();
        }

        return redirect(moduleUrl('data'))->with('flash', __('Post deleted'));
    }

    /**
     * @param null $id
     * @return mixed
     */
    public function anyBuild($id = null)
    {

        $title = 'Data manager builder';

        if (request()->has('type')) {
            $form = Form::where('type', '=', request()->get('type'))->first();
            return moduleUrl('datamanager/data/build/' . $form->id);
        }

        /**
         * var $item Data
         */
        if ($id) {
            $item = Form::findOrFail($id);
        } else {
            $item = new Form();
        }

        $aForm = [];

        Hook::put('__app.scope.fields', $item['meta']);
        Hook::put('__app.scope.data', $item);

        return $this->viewMake('datamanager::data-builder', get_defined_vars());
    }

    /**
     *
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function getRedirect($id)
    {
        $result = new onRedirectPost($id);
        $events = event($result);

        if ($events) {
            $event = array_pop($events);
            return $event->redirect;
        }

        return $result->redirect;
    }

    /**
     * Edit form
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getEdit($id)
    {
        $item = $this->post->findOrFail($id);

        $tags = Tag::pluck('name', 'id');
		$categories = Category::pluck('name', 'id');
        $langs = Arxmin::getLocales('select');

        $templates = Datamanager::listViews($item->types);

        Hook::put('__app.scope.fields', $item->form()['meta']);
        Hook::put('__app.scope.data', $item->toArray());

        return $this->viewMake('datamanager::edit', get_defined_vars());
    }

    /**
     * Update data
     *
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postEdit($id)
    {
        // Check if we need to redirect or not to translation

        $item = $this->post->findOrFail($id);

        if (request()->has('action_translate') && request()->get('translate') != $item->lang) {

            $translate = request()->get('translate');
            // Check if post already exists
            if ($item->ref) {
                $post = Post::where('ref', $item->ref)->where('lang', $translate)->first();

                // if post already exist
                if ($post) {
                    return redirect(moduleUrl('data/edit/' . $post->id));
                }
            } else {
                $item->ref = $item->id;
                $item->save();
            }

            // Copy data to array
            $newItemData = array_except($item->toArray(), ['id', 'lang', 'tags', 'categories', 'meta', 'created_at', 'updated_at']);

            // force array to string
            foreach ($newItemData as $key => $data) {
                if (is_array($data)) {
                    $newItemData[$key] = json_encode($data);
                }
            }

            $newItem = $this->post->create($newItemData);
            $newItem->ref = $item->ref;
            $newItem->lang = $translate;
            $newItem->save();

            return redirect(moduleUrl('data/edit/' . $newItem->id));
        }

        // Compile data
        $data = array_filter(Input::only($this->post->getFillable()));

		$data['is_public'] = (isset($data['is_public']) && $data['is_public']) ? true : false;
		$data['is_highlighted'] = (isset($data['is_highlighted']) && $data['is_highlighted']) ? true : false;

        $item->update($data);
        $item->save();

		if (request()->has('tags')) {
			$tags = [];

			foreach (request()->get('tags') as $value) {
				$tag = Tag::find($value);

				if (!$tag) {
					$tag = Tag::where('name', $value)->first();

					if (!$tag) {
						$tag = new Tag();
						$tag->name = $value;
						$tag->ref = 'post';
						$tag->lang = $item->lang;
						$tag->save();
					}
				}

				$tags[] = $tag->id;
			}

			$item->tags()->sync($tags);
		} else {
			$item->tags()->detach();
		}

		if (request()->has('categories')) {
			$categories = [];

			foreach (request()->get('categories') as $value) {
				$category = Category::find($value);

				if (!$category) {
					$category = Category::where('name', $value)->first();

					if (!$category) {
						$category = new Category();
						$category->name = $value;
						$category->ref = 'post';
						$category->lang = $item->lang;
						$category->save();
					}
				}

				$categories[] = $category->id;
			}

			$item->categories()->sync($categories);
		} else {
			$item->categories()->detach();
		}

        notify(lg('Post updated'));

        return redirect()->back()->with('flash', __("Post updated"));
    }

}
