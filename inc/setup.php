<?php

if (!defined('ABSPATH')) {
    exit;
}


function uk_mosque_theme_setup()
{
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo');

    add_theme_support(
        'html5',
        array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'script',
            'style',
        )
    );
}

add_action('after_setup_theme', 'uk_mosque_theme_setup');