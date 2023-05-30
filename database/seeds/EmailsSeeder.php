<?php

use App\OrderPlan;
use Illuminate\Database\Seeder;
use Modules\Datamanager\Entities\Post;

/**
 * Class EmailsSeeder
 *
 * php artisan db:seed --class=EmailsSeeder
 */
class EmailsSeeder extends Seeder
{
    public function run()
    {
        $emails = [
            '/mail/'.'invitation',
            '/mail/'.'promo-code',
            '/mail/'.'monthly-billing',
            '/mail/'.'error-billing',
            '/mail/'.'get-back',
            '/mail/'.'end-subscription',
            '/mail/'.'update-meeting',
            '/mail/'.'billing-special',
        ];

        foreach ($emails as $email){
            $this->createEmptyPost($email);
        }
    }

    /**
     * Create an empty post in every language
     */
    public function createEmptyPost($ref, $type = "email",  $data = []){

        // Check if ref already exists
        $locales = array_keys(config('app.locales'));

        if(!Post::where('ref', $ref)->exists()){

            foreach($locales as $locale){
                Post::create(array_merge([
                    'title' => $ref . '.title',
                    'content' => $ref . '.content',
                    'type' => $type,
                    'slug' => $ref,
                    'ref' => $ref,
                    'lang' => $locale
                ], $data));
            }

            echo "Emails generation... \n";
        }

        // Consolidate posts_posts

        $posts = Post::whereNotNull('ref')->get();

        $groups = [];

        foreach ($posts as $post) {

            if (!isset($groups[$post->ref])) {
                $groups[$post->ref] = [];
            }

            $groups[$post->ref][] = $post;
        }

        foreach ($groups as $ref => $posts) {
            foreach ($posts as $source) {
                foreach ($posts as $post) {
                    if ($source->id !== $post->id) {
                        $post->postsLinked()->attach($source);
                    }
                }
            }
        }


        echo "Emails generated \n";
    }
}
