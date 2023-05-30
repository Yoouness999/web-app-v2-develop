<?php
/**
 * Created by PhpStorm.
 * User: monkeymonk
 * Date: 3/02/16
 * Time: 12:11
 */

namespace Modules\Datamanager\Events;


use Modules\Datamanager\Entities\Post;

class onRedirectPost extends \Event
{
    public function __construct($id)
    {
        $this->post = Post::find($id);
        $this->redirect = redirect($this->post->slug);
    }
}