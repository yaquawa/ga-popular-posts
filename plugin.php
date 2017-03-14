<?php
/*
Plugin Name: GA Popular Posts
Description: A plugin for WordPress to get the most popular posts by using the Google Analytics.
Author: yaquawa
Version: 1.0.0
Author URI: https://github.com/yaquawa
Network: True
*/

// If this file is called directly, abort.
if ( ! defined('WPINC')) {
    die;
}

define('GAPP_DIR_URL', plugin_dir_url(__FILE__));

require __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/bootstrap/app.php';