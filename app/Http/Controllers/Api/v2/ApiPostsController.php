<?php

namespace App\Http\Controllers\Api\v2;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Api\v2\ApiHelper;
use App\Api\v2\ApiPost;

class ApiPostsController extends Controller
{

    /**
     * Get posts
     *
     * @param string $filters (optionnal) Filter the results. Model: {attribute1}:{operator1}:{value1};{attribute2}:{operator2}:{value2}...
     * @param string $order (optionnal) Sort the result. Model: {attribute}:{way}
     * @param int $page (optionnal) Current page for pagination.
     * @param int $items_by_page (optionnal) Items by page for pagination.
     * @param boolean $first (optionnal) Force the results to only one item. Not working with pagination.
     */
    public function get(Request $request)
    {

        $params = ApiHelper::getParamsFromRequest($request);

        $data = ApiPost::get($params);

        return ApiHelper::response($data);
    }

    /**
     * Add a post.
     *
     * @param string $slug (optionnal) : slug of the post
     * @param string $title (required) : title of the post (for email = subject of the email)
     * @param text $content (required) : text field representing the content in html format
     * @param integer $ref (required) : the post id of reference (used when you translate a post in a different lang)
     * @param string $lang (required) : the lang of the post (fr,en or nl)
     * @param string $type (required) : type of post (actually the types are page, post and email
     * @param timestamp $updated_at (optionnal) : the updated date
     * @param json $meta (optionnal) : meta custom fields in a json format (not used in boxify)
     * @param string $meta_type (optionnal) : meta_type = type of custom meta (actually not used in boxify)
     * @param string $thumb (optionnal) : the default thumb link (not used in boxify)
     * @param json $version (optionnal) : the version of the edition (not used)
     * @param integer $level (optionnal) : hierarchical level of a post (deprecated)
     * @param string $position : position of the post for map (not used)
     * @param json $categories : (deprecated we use category_post table instead)
     * @param json $tags : (deprecated)
     * @param string $status (optionnal) : status of a post (published, draft, trashed) Not used in boxify
     * @param json $context : custom json when you can put anything (not used)
     * @param timestamp $created_at
     * @param integer $parent_id : used to define hierarchy (@see : https://github.com/etrepat/baum)
     * @param integer $lft : used to define hierarchy (@see : https://github.com/etrepat/baum)
     * @param integer $rgt : used to define hierarchy (@see : https://github.com/etrepat/baum)
     * @param integer $depth : used to define hierarchy (@see : https://github.com/etrepat/baum)
     * @param string $template :  template to apply for the post (not used in boxify)
     * @param timestamp $published_at : date of publication (not used)
     * @param boolean $is_public : define if the post is public or not (not used)
     * @param boolean $is_highlighted : define if the post should be highlighted or not (not used)
     * @param json $logs : not used
     */
    public function add(Request $request)
    {
        $item = ApiPost::add($request->all());

        return ApiHelper::response($item);
    }

    /**
     * Save an post.
     *
     * @param int $id id of the post.
     * @param string $slug (optionnal) : slug of the post
     * @param string $title (required) : title of the post (for email = subject of the email)
     * @param text $content (required) : text field representing the content in html format
     * @param integer $ref (required) : the post id of reference (used when you translate a post in a different lang)
     * @param string $lang (required) : the lang of the post (fr,en or nl)
     * @param string $type (required) : type of post (actually the types are page, post and email
     * @param timestamp $updated_at (optionnal) : the updated date
     * @param json $meta (optionnal) : meta custom fields in a json format (not used in boxify)
     * @param string $meta_type (optionnal) : meta_type = type of custom meta (actually not used in boxify)
     * @param string $thumb (optionnal) : the default thumb link (not used in boxify)
     * @param json $version (optionnal) : the version of the edition (not used)
     * @param integer $level (optionnal) : hierarchical level of a post (deprecated)
     * @param string $position : position of the post for map (not used)
     * @param json $categories : (deprecated we use category_post table instead)
     * @param json $tags : (deprecated)
     * @param string $status (optionnal) : status of a post (published, draft, trashed) Not used in boxify
     * @param json $context : custom json when you can put anything (not used)
     * @param timestamp $created_at
     * @param integer $parent_id : used to define hierarchy (@see : https://github.com/etrepat/baum)
     * @param integer $lft : used to define hierarchy (@see : https://github.com/etrepat/baum)
     * @param integer $rgt : used to define hierarchy (@see : https://github.com/etrepat/baum)
     * @param integer $depth : used to define hierarchy (@see : https://github.com/etrepat/baum)
     * @param string $template :  template to apply for the post (not used in boxify)
     * @param timestamp $published_at : date of publication (not used)
     * @param boolean $is_public : define if the post is public or not (not used)
     * @param boolean $is_highlighted : define if the post should be highlighted or not (not used)
     * @param json $logs : not used
     */
    public function save(Request $request)
    {
        $params = $request->all();
        $id = $params['id'];
        unset($params['id']);

        $item = ApiPost::save($id, $params);

        return ApiHelper::response($item);
    }


    /**
     * Delete an post.
     *
     * @param int $id (required) Id.
     */
    public function delete(Request $request)
    {
        $item = ApiPost::delete($request->get('id'));

        return ApiHelper::response($item);
    }
}