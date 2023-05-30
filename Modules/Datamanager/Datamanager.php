<?php namespace Modules\Datamanager;

use App;
use Blok\Utils\Arr;
use Blok\Utils\Str;
use Blok\Utils\Traits\SingletonTrait;
use File;
use Illuminate\Support\Facades\Schema;
use Modules\Datamanager\Entities\Category;
use Modules\Datamanager\Entities\Form;
use Modules\Datamanager\Entities\Menu;
use Modules\Datamanager\Entities\Post;
use Modules\Datamanager\Entities\Tag;
use Config;

/**
 * Class Datamanager
 *
 * @package Modules\Datamanager
 */
class Datamanager
{
    public $local = null;

    use SingletonTrait;

    /**
     * @todo fix Entities autoloading
     */
    public function __construct(){
        /**
         * @var $post Modules\Datamanager\Entities\Post
         */
        $post = Config::get('datamanager::name', Post::class);
        $this->post = new $post();

        /**
         * @var $form Modules\Datamanager\Entities\Form
         */
        $form = Config::get('datamanager::entities.form', Form::class);
        $this->form = new $form();

        /**
         * @var $tag Modules\Datamanager\Entities\Tag
         */
        $tag = Config::get('datamanager::entities.tag', Tag::class);
        $this->tag = new $tag();

        /**
         * @var $category Modules\Datamanager\Entities\Category
         */
        $category = Config::get('datamanager::entities.category', Category::class);
        $this->category = new $category();

        /**
         * @var $menu Modules\Datamanager\Entities\Menu
         */
        $menu = Config::get('datamanager::entities.menu', Menu::class);
        $this->menu = new $menu();

        // Init local
        $this->local = App::getLocale();
    }

    /**
     * Get menus dynamically
     */
    public static function getMenu()
    {
        $menu = [];

        if (Schema::hasTable('forms')) {

            $forms = Form::where('type', '!=', 'custom')->get();

            foreach ($forms as $form) {
                $menu[] = array(
                    'name' => $form->title,
                    'ico' => 'fa-file-o',
                    'type' => 'module',
                    'link' => url('/arxmin/modules/datamanager/data?type='.$form->type)
                );
            }
        }

        $menu[] = [
                'name' => 'Forms',
                'ico' => 'fa-plus',
                'type' => 'module',
                'link' => url('/arxmin/modules/datamanager/form')
            ];

        $menu[] = [
                'name' => 'Categories',
                'ico' => 'fa-list',
                'type' => 'module',
                'link' => url('/arxmin/modules/datamanager/category')
            ];

        $menu[] = [
                'name' => 'Tags',
                'ico' => 'fa-tags',
                'type' => 'module',
                'link' => url('/arxmin/modules/datamanager/tag')
            ];

        $menu[] = [
                'name' => 'Menu',
                'ico' => 'fa-reorder',
                'type' => 'module',
                'link' => url('/arxmin/modules/datamanager/menu')
            ];

        return $menu;
    }

    /**
     * Get post by slug
     *
     * @param $uri
     * @param array $params
     * @return array
     * @throws \Exception
     */
    public static function getBySlug($uri, $params = ['format' => 'array'], $lang = null, $hide_if_not_published = false)
    {
        return call_user_func_array([self::getInstance()->post, 'getBySlug'], func_get_args());
    }

    /**
     * Get Post by a reference
     *
     * @param $ref
     * @param array $params
     * @param null $lang
     * @return array
     * @throws \Exception
     * @internal param $uri
     */
    public static function getByRef($ref, $params = ['format' => 'array'], $lang = null, $hide_if_not_published = false)
    {
        return call_user_func_array([self::getInstance()->post, "getByRef"], func_get_args());
    }

    /**
     * Get post by type
     *
     * @param $type
     * @param array $params
     * @return array|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getByType($type, $params = ['format' => 'array', 'hide_if_not_published' => false])
    {
        return call_user_func_array([self::getInstance()->post, 'getByType'], func_get_args());
    }

    public static function getCategories($params = []){
        Arr::mergeWithDefaultParams($params);
        return Category::all();
    }


    public static function getArchives($params = ['groupBy' => 'month', 'lang' => null, 'type' => null]){

        Arr::mergeWithDefaultParams($params);

        $query = self::getInstance()->post;

        if (!$params['lang']) {
            $params['lang'] = \App::getLocale();
        }

        if ($params['type']) {
            $query = $query->where('type', $params['type']);
        }

        if ($params['groupBy'] == 'month') {
            $query->where('lang', $params['lang'])->orderBy('updated_at')->groupBy(function($item){
                return $item->created_at->format('d-M-y');
            });
        }

        return $query;
    }

    public static function getTags($params = ['ref' => null, 'lang' => null]){

        Arr::mergeWithDefaultParams($params);

        $query = self::getInstance()->tag;

        if (!$params['lang']) {
            $params['lang'] = App::getLocale();
        }

        $query = $query->where('lang', $params['lang']);

        if ($params['ref']) {
            $query = $query->where('ref', $params['ref']);
        }

        return $query->get();
    }


    /**
     * Guess post type from uri
     *
     * @param null $segment
     * @return mixed
     */
    public static function guessPostType($segment = null){
        return call_user_func_array([self::getInstance()->form, 'guessPostType'], func_get_args());
    }

    /**
     * Get the prefix uri from a post type
     *
     * @param $type
     * @return mixed
     */
    public function getTypePrefix($type)
    {
        return call_user_func_array([self::getInstance()->form, "getTypePrefix"], func_get_args());
    }

    /**
     * Get list of all views availables
     *
     * @param null $path if defined will list only specific folder
     * @return array
     */
    public static function listViews($path = null, $params = ['type' => 'list'])
    {
        Arr::mergeWithDefaultParams($params);

        if ($path) {
            $path = Str::mustBeginWith('/', $path);
        }

        $appView = app('view');

        $paths = $appView->getFinder()->getPaths();
        $extensions = array_keys($appView->getExtensions());

        array_walk($extensions, function (&$item) {
            $item = Str::mustBeginWith('.', $item);
        });

        $views = [
            '' => \Lang::get('No template assigned'),
        ];

        foreach ($paths as $viewpath) {

            $list = File::allFiles($viewpath.$path);

            foreach ($list as $item) {

                $path = str_replace(base_path(), '', $item);

                $ref = str_replace([Str::mustEndWith('/', $viewpath), '/'], ['', '.'], $item);
                $ref = str_replace($extensions, [''], $ref);

                if ($params['type'] == 'array') {
                    $item = [
                        'path' => $path,
                        'ref' => $ref
                    ];
                    $views[] = $item;
                } else {
                    $views[$ref] = $ref;
                }
            }
        }

        return $views;
    }
}
