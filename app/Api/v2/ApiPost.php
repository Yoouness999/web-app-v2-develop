<?php
namespace App\Api\v2;

use Modules\Datamanager\Entities\Post;

class ApiPost {

	public static function get($params = []){
		return ApiHelper::get(Post::query(), $params);
	}
	
	public static function add($params = []) {
		$item = Post::create($params);
		$item->save();
		
		return $item;
	}
	
	public static function save($id, $params = []) {
		$item = Post::find($id);
		$item = $item->fill($params);
		$item->save();
		
		return $item;
	}

    public static function delete($id) {
        $item = Post::find($id);
        $item->delete();
        return true;
    }
}