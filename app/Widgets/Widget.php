<?php

namespace GAPP\Widgets;

use GAPP\Foundation\BaseWidget;

class Widget extends BaseWidget
{
    public $baseId = 'gapp_widget';
    public $name = 'GA Popular Posts';
    public $description = 'Google Analytics Popular Posts';
    public $widget_options = [];
    public $fields = ['title', 'add_thumbnail'];


    protected function displayWidget($args, $instance)
    {
        global $gapp_app;

        $postIds = gapp_get_popular_posts();
        $posts   = get_posts(['post__in' => $postIds, 'posts_per_page' => count($postIds), 'post_type' => $gapp_app->make('options')->get('post_types')]);
        ?>
        <section class="gapp-widget">
            <?php if ( ! empty($instance['title'])): ?>
                <h1><?php echo $instance['title']; ?></h1>
            <?php endif; ?>
            <ul class="gapp-widget-list">
                <?php foreach ($posts as $post): ?>
                    <li class="gapp-widget__post">
                        <a href="<?php echo get_permalink($post); ?>">
                            <?php if ($instance['add_thumbnail']): ?>
                                <?php echo get_the_post_thumbnail($post, 'post-thumbnail', ['class' => 'gapp-widget__img']); ?>
                            <?php endif; ?>
                            <span class="gapp-widget__post-title"><?php echo get_the_title($post); ?></span>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>
        <?php
    }

    protected function displayForm($instance)
    {
        $title = ! empty($instance['title']) ? $instance['title'] : '';
        $ids   = $this->get_field_ids();
        $names = $this->get_field_names();
        ?>
        <p>
            <label for="<?php echo esc_attr($ids->title); ?>"><?php esc_attr_e('Title:'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($ids->title); ?>" name="<?php echo esc_attr($names->title); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($ids->add_thumbnail); ?>"><input id="<?php echo esc_attr($ids->add_thumbnail); ?>" name="<?php echo esc_attr($names->add_thumbnail); ?>" type="checkbox" value="1"<?php echo(empty($instance['add_thumbnail']) ? '' : 'checked="checked"'); ?>> <?php esc_attr_e('Add Thumbnail'); ?>
            </label>
        </p>
        <?php
    }
}