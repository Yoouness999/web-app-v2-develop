<?php namespace Modules\Datamanager\Database\Seeders;

use App;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Datamanager\Entities\Form;
use Modules\Datamanager\Entities\Post;

class DatamanagerDatabaseSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        # Create default form
        $forms = [
            [
                'title' => 'Page builder',
                'description' => 'Page builder',
                'meta' => '[{"id":0,"component":"textInput","editable":true,"index":0,"label":"metatitle","description":"Meta title","placeholder":"(max 70 chars)","options":[],"required":false,"validation":"/.*/"},{"id":9,"component":"textArea","editable":true,"index":1,"label":"metadescription","description":"Meta description","placeholder":"(max 160 chars)","options":[],"required":false,"validation":"/.*/"}]',
                'type' => 'form',
                'status' => 'published',
                'lang' => App::getLocale()
            ],
            [
                'title' => 'Post builder',
                'description' => 'Page builder',
                'meta' => '[{"id":0,"component":"textInput","editable":true,"index":0,"label":"metatitle","description":"Meta title","placeholder":"(max 70 chars)","options":[],"required":false,"validation":"/.*/"},{"id":9,"component":"textArea","editable":true,"index":1,"label":"metadescription","description":"Meta description","placeholder":"(max 160 chars)","options":[],"required":false,"validation":"/.*/"}]',
                'type' => 'form',
                'status' => 'published',
                'lang' => App::getLocale()
            ]
        ];

        foreach ($forms as $data) {
            Form::create($data);
        }

        # Create default post
        $posts = [
            [
                'slug' => 'about',
                'title' => 'About example',
                'content' => 'This is an about example',
                'lang' => App::getLocale(),
                'type' => 'page'
            ],
            [
                'slug' => 'my-first-post',
                'title' => 'Article example',
                'content' => 'This is an article example',
                'lang' => App::getLocale(),
                'type' => 'page'
            ]
        ];

        foreach ($posts as $data) {
            Post::create($data);
        }

        echo "Forms & Posts created \n";

    }
}