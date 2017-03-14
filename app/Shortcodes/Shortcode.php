<?php

namespace GAPP\Shortcodes;

use Laraish\Dough\Application;

class Shortcode
{
    const TAG = 'gapp';

    public function handle(Application $app, $args)
    {
        $postIds = gapp_get_popular_posts($args ?: []);
        $posts   = get_posts(['post__in' => $postIds, 'posts_per_page' => count($postIds), 'post_type' => $app->make('options')->get('post_types')]);

        ob_start();

        ?>
        <ul class="gapp-post-list">
            <?php foreach ($posts as $post): ?>
                <li><a href="<?php echo get_permalink($post); ?>"><?php echo get_the_title($post); ?></a></li>
            <?php endforeach; ?>
        </ul>
        <?php

        return ob_get_clean();
    }
}