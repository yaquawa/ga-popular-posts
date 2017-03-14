<?php

function gapp_get_popular_posts(array $config = [], $no_cache = false)
{
    $popularPosts = new \GAPP\PopularPosts($config);

    return $popularPosts->get($no_cache);
}