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

    /**
     * Donation CPT
     */

    register_post_type('donation', array(

        'labels' => array(
            'name'                  => __('Donations', 'uk-mosque'),
            'singular_name'         => __('Donation', 'uk-mosque'),
            'menu_name'             => __('Donations', 'uk-mosque'),
            'name_admin_bar'        => __('Donation', 'uk-mosque'),
            'add_new'               => __('Add New', 'uk-mosque'),
            'add_new_item'          => __('Add New Donation', 'uk-mosque'),
            'new_item'              => __('New Donation', 'uk-mosque'),
            'edit_item'             => __('Edit Donation', 'uk-mosque'),
            'view_item'             => __('View Donation', 'uk-mosque'),
            'all_items'             => __('All Donations', 'uk-mosque'),
            'search_items'          => __('Search Donations', 'uk-mosque'),
            'not_found'             => __('No donations found.', 'uk-mosque'),
            'not_found_in_trash'    => __('No donations found in Trash.', 'uk-mosque'),
            'featured_image'        => __('Donation Image', 'uk-mosque'),
            'set_featured_image'    => __('Set donation image', 'uk-mosque'),
            'remove_featured_image' => __('Remove donation image', 'uk-mosque'),
            'use_featured_image'    => __('Use as donation image', 'uk-mosque'),
        ),
        'public'             => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_admin_bar'  => true,
        'show_in_nav_menus'  => true,

        'has_archive'        => 'causes',
        'rewrite'            => array(
            'slug'       => 'causes',
            'with_front' => false,
        ),

        'menu_icon'          => 'dashicons-heart',
        'show_in_rest'       => true,

        'publicly_queryable' => true,
        'query_var'          => true,

        'supports'           => array(
            'title',
            'editor',
            'thumbnail',
            'excerpt',
        ),
    ));
}

add_action('init', 'uk_mosque_register_post_types');



/**
 * Add custom columns to Event CPT
 */
function uk_mosque_event_columns($columns)
{
    return array(
        'cb'         => $columns['cb'],
        'title'      => __('Event Title', 'uk-mosque'),
        'topic'     => __('Topic', 'uk-mosque'),
        'event_date' => __('Event Date', 'uk-mosque'),
        'event_time' => __('Event Time', 'uk-mosque'),
        'date'       => __('Published', 'uk-mosque'),
    );
}

add_filter('manage_event_posts_columns', 'uk_mosque_event_columns');

/**
 * Display custom column values
 */
function uk_mosque_event_column_content($column, $post_id)
{
    switch ($column) {

        /**
         * topic
         */
        case 'topic':

            $topic = get_post_meta(
                $post_id,
                '_event_topic',
                true
            );

            echo !empty($topic)
                ? esc_html($topic)
                : '—';

            break;


        /**
         * Event Date
         */
        case 'event_date':

            $event_date = get_post_meta(
                $post_id,
                '_event_date',
                true
            );

            echo !empty($event_date)
                ? esc_html($event_date)
                : '—';

            break;


        /**
         * Event Time
         */
        case 'event_time':

            $event_start = get_post_meta(
                $post_id,
                '_event_start',
                true
            );

            $event_end = get_post_meta(
                $post_id,
                '_event_end',
                true
            );

            if ($event_start) {

                echo esc_html(
                    date_i18n(
                        get_option('time_format'),
                        strtotime($event_start)
                    )
                );

                if ($event_end) {

                    echo ' - ';

                    echo esc_html(
                        date_i18n(
                            get_option('time_format'),
                            strtotime($event_end)
                        )
                    );
                }
            } else {

                echo '—';
            }

            break;
    }
}

add_action(
    'manage_event_posts_custom_column',
    'uk_mosque_event_column_content',
    10,
    2
);