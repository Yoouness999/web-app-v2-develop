<?php

return [
	'name' => 'Datamanager',
	'entities' => [
		'form' => Modules\Datamanager\Entities\Form::class,
		'post' => Modules\Datamanager\Entities\Post::class,
		'category' => Modules\Datamanager\Entities\Category::class,
		'tags' => Modules\Datamanager\Entities\Tag::class,
		'menu' => Modules\Datamanager\Entities\Menu::class,
	]
];