<?php namespace Modules\Datamanager\Entities;

use Arr;
use Blok\Utils\Str;
use Arxmin\Api;
use Blok\Utils\Traits\HasModelUtilityTrait;
use Modules\Datamanager\Traits\getCatsTrait;
use Modules\Datamanager\Traits\getTagsTrait;
use Modules\Datamanager\Traits\ModelFilesHandlingTrait;
use URL;

class Post extends \Eloquent
{

    protected $table = "posts";

    use HasModelUtilityTrait, getCatsTrait, getTagsTrait, ModelFilesHandlingTrait;

    protected static $filepath = null;

    protected $fillable = [
        'slug',
        'title',
        'content',
        'meta',
        'meta_type',
        'ref',
        'lang',
        'type',
        'version',
        'level',
        'position',
        'status',
        'context',
        'logs',
        'template',
		'published_at',
		'is_public',
		'is_highlighted'
    ];

    protected $casts = [
        'meta' => 'array',
    ];

#C
    public function categories()
    {
		return $this->belongsToMany(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

	public function postsLinked()
    {
        return $this->belongsToMany(Post::class, 'posts_posts', 'from_post_id', 'to_post_id');
    }

    /**
     * Check if Slug is correct
     *
     * @return static
     */
    public function checkSlug()
    {
        if (empty($this->slug)) {
            $slug = Str::slug($this->title);
            if ($this->whereRaw('slug = ? and type = ? and id != ?', [$slug, $this->type, $this->id])->first(['id'])) {
                $slug = $slug . '-' . $this->id;
            }

            $this->slug = $slug;

            $this->save();
        }

        return $this;
    }

    /**
     * Returns a formatted post content entry, this ensures that
     * line breaks are returned.
     *
     * @return string
     */
    public function content()
    {
        return nl2br($this->content);
    }

    /**
     * Save a new model and return the instance.
     *
     * @param  array $attributes
     * @return \Illuminate\Database\Eloquent\Model|static
     */
    public static function create(array $attributes = [])
    {
        $model = new static($attributes);

        $model->save();

        $model->checkSlug();

        return $model;
    }

#F
    /**
     * Scope form
     */
    public function form()
    {
        return Form::where('type', $this->type)->first();
    }

#G
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
        Arr::mergeWithDefaultParams($params);

        $uri = Str::mustBeginWith('/', str_replace([url('/')], "", $uri));

        $data = self::where('slug', $uri)->where('lang', $lang ?: \App::getLocale())->first();

		if (!$data) {
			$post = self::where('slug', $uri)->first();
			if ($post) {
				$data = $post->postsLinked()->where('lang', $lang ?: \App::getLocale())->first();
			}
        }

        if (!$data) {
            return false;
        }

		if ($hide_if_not_published && ($data->published_at > date('Y-m-d H:i:s', time()) || !$data->published_at)) {
			return false;
		}

		if ($hide_if_not_published && !$data->is_public) {
			return false;
		}

        if ($params['format'] == 'array') {
            return $data->toArray();
        }

        return $data;
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
        Arr::mergeWithDefaultParams($params);

        $ref = Str::mustBeginWith('/', str_replace([url('/')], "", $ref));

        $data = self::where('ref', $ref)->where('lang', $lang ?: \App::getLocale())->first();

        if (!$data) {
            $data = self::where('slug', $ref)->first();
        }

        if (!$data) {
            return false;
        }

		if ($hide_if_not_published && ($data->published_at > date('Y-m-d H:i:s', time()) || !$data->published_at)) {
			return false;
		}

		if ($hide_if_not_published && !$data->is_public) {
			return false;
		}

        if ($params['format'] == 'array') {
            return $data->toArray();
        }

        return $data;
    }

    /**
     * Get posts by type
     *
     * @param $type
     * @param array $params
     * @return array|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getByType($type, $params = ['format' => 'array', 'current_lang' => true, 'hide_if_not_published' => false])
    {
        $type = Form::where('uri', '/' . $type)->first()->type;

		$data = self::where('type', $type);

		if (isset($params['hide_if_not_published']) && $params['hide_if_not_published']) {
			$data = $data->where('published_at', '<=', date('Y-m-d H:i:s', time()))
						->where('is_public', true);
		}

        if (isset($params['current_lang']) && $params['current_lang']) {
            $data = $data->where('lang', app()->getLocale())->orderBy('published_at', 'DESC')->get();
        } else {
            $data = $data->orderBy('published_at', 'DESC')->get();
        }

        if (isset($params['format']) && $params['format'] == 'array') {
            return $data->toArray();
        }

        return $data;
    }

    /**
     * Return metafields of the current post
     */
    public function getMetaFields()
    {
        return $this->form()->meta;
    }

    /**
     * Return the types
     *
     * @param $data
     * @return string
     */
    public function getTypesAttribute($data)
    {
        return str_plural($this->type);
    }


    public function getForms()
    {
        $data = [];

        $data[] = Form::where('type', $this->type)->get();

        return $data;
    }

    /**
     * Return types used in table Data
     *
     * @param array $params
     * @return array
     * @throws \Exception
     */
    public static function getUsedTypes(array $params = [])
    {
        $params = Arr::merge([
            'format' => 'array'
        ], $params);

        $response = self::select('type')->groupBy('type')->get()->toArray();

        $response = array_map(function ($item) {
            return $item['type'];
        }, $response);

        if ($params['format'] == 'array') {
            return $response;
        }

        return Api::response($response, 200, 'Ok');
    }

#S
    public static function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Search param
     *
     * @param array $param
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function search($param = [])
    {
        $query = static::select();

        if (isset($param['type']) && !empty($param['type'])) {
            $query->where('type', $param['type']);
        }


        return $query->get();
    }
#T
    /**
     * Return the post thumbnail image url.
     *
     * @return string
     */
    public function thumbnail()
    {
        # you should save the image url on the database
        # and return that url here.

        return 'http://lorempixel.com/130/90/business/';
    }

    public function typesAttribute($data)
    {
        return str_plural($this->type);
    }

    public function toArray()
    {
        $data = parent::toArray();
        $data['types'] = $this->types;
		$data['tags'] = $this->tags()->get()->toArray();
		$data['categories'] = $this->categories()->get()->toArray();
        return $data;
    }
#U
    /**
     * Return the URL to the post.
     *
     * @return string
     */
    public function url()
    {
        return URL::route('view-post', $this->slug);
    }
}
