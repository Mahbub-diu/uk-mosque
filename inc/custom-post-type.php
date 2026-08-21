<?php

if (!defined('ABSPATH')) {
    exit;
}

function uk_mosque_register_post_types()
{
    /**
     * Event CPT
     */

    register_post_type('event', array(

        'labels' => array(
            'name'                  => __('Events', 'uk-mosque'),
            'singular_name'         => __('Event', 'uk-mosque'),
            'menu_name'             => __('Events', 'uk-mosque'),
            'name_admin_bar'        => __('Event', 'uk-mosque'),
            'add_new'               => __('Add New', 'uk-mosque'),
            'add_new_item'          => __('Add New Event', 'uk-mosque'),
            'new_item'              => __('New Event', 'uk-mosque'),
            'edit_item'             => __('Edit Event', 'uk-mosque'),
            'view_item'             => __('View Event', 'uk-mosque'),
            'all_items'             => __('All Events', 'uk-mosque'),
            'search_items'          => __('Search Events', 'uk-mosque'),
            'not_found'             => __('No events found.', 'uk-mosque'),
            'not_found_in_trash'    => __('No events found in Trash.', 'uk-mosque'),
            'featured_image'        => __('Event Image', 'uk-mosque'),
            'set_featured_image'    => __('Set Event Image', 'uk-mosque'),
            'remove_featured_image' => __('Remove Event Image', 'uk-mosque'),
            'use_featured_image'    => __('Use as Event Image', 'uk-mosque'),
        ),
        'public'       => true,
        'show_ui'      => true,
        'show_in_rest' => true,
        'has_archive'  => true,

        'rewrite' => array(
            'slug' => 'events',
        ),

        'menu_icon' => 'dashicons-calendar-alt',

        'supports' => array(
            'title',
            'editor',
            'thumbnail',
            'excerpt',
        ),
    ));
}

add_action('init', 'uk_mosque_register_post_types');