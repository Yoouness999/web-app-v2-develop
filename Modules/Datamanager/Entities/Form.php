<?php namespace Modules\Datamanager\Entities;

use Modules\Datamanager\Traits\getMetaAttributeTrait;
use Request;

class Form extends \Eloquent {

    protected $table = "forms";
    protected $dates = [ 'updated_at', 'created_at' ];

    const TYPE_RULED = "ruled";

    use getMetaAttributeTrait;

    /**
     * Guess post type from uri
     *
     * @param null $segment
     * @return mixed
     */
    public static function guessPostType($segment = null){

        if (!$segment) {
            $segment = Request::segment(1);
        }

        $type = self::where('uri', '/'.$segment)->first()->type;

        return $type;
    }

    /**
     * Get the prefix uri from a post type
     *
     * @param $type
     * @return mixed
     */
    public function getTypePrefix($type)
    {
        $form = self::where('type', $type)->first();

        return $form->uri;
    }

}
