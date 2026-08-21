<?php

if (!defined('ABSPATH')) {
    exit;
}


function uk_mosque_register_texonomies()
{
    /**
     * Event Topic
     */

    register_taxonomy(
        'event_topic',
        array('event'),
        array(
            'labels' => array(
                'name'              => __('Event Topics', 'uk-mosque'),
                'singular_name'     => __('Event Topic', 'uk-mosque'),
                'search_items'      => __('Search Event Topics', 'uk-mosque'),
                'all_items'         => __('All Event Topics', 'uk-mosque'),
                'edit_item'         => __('Edit Event Topic', 'uk-mosque'),
                'update_item'       => __('Update Event Topic', 'uk-mosque'),
                'add_new_item'      => __('Add New Event Topic', 'uk-mosque'),
                'new_item_name'     => __('New Event Topic Name', 'uk-mosque'),
                'menu_name'         => __('Topics', 'uk-mosque'),
            ),

            'public'       => true,
            'hierarchical' => true,
            'show_in_rest' => true,

            'rewrite' => array(
                'slug' => 'event-topic',
            ),
        )
    );
}

add_action('init', 'uk_mosque_register_texonomies');