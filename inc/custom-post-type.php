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

    /**
     * Teams CPT
     */


    register_post_type('team_member', array(

        'labels' => array(
            'name'                  => __('Team Members', 'uk-mosque'),
            'singular_name'         => __('Team Member', 'uk-mosque'),
            'menu_name'             => __('Team Members', 'uk-mosque'),
            'name_admin_bar'        => __('Team Member', 'uk-mosque'),
            'add_new'               => __('Add New', 'uk-mosque'),
            'add_new_item'          => __('Add New Team Member', 'uk-mosque'),
            'new_item'              => __('New Team Member', 'uk-mosque'),
            'edit_item'             => __('Edit Team Member', 'uk-mosque'),
            'view_item'             => __('View Team Member', 'uk-mosque'),
            'all_items'             => __('All Team Members', 'uk-mosque'),
            'search_items'          => __('Search Team Members', 'uk-mosque'),
            'not_found'             => __('No team members found.', 'uk-mosque'),
            'not_found_in_trash'    => __('No team members found in Trash.', 'uk-mosque'),
            'featured_image'        => __('Team Member Photo', 'uk-mosque'),
            'set_featured_image'    => __('Set Team Member Photo', 'uk-mosque'),
            'remove_featured_image' => __('Remove Team Member Photo', 'uk-mosque'),
            'use_featured_image'    => __('Use as Team Member Photo', 'uk-mosque'),
        ),
        'public'             => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_admin_bar'  => true,
        'show_in_nav_menus'  => true,

        'menu_icon'          => 'dashicons-groups',

        'menu_position'      => 20,
        'supports'           => array(
            'title',
            'editor',
            'thumbnail',
        ),

        'has_archive'        => true,
        'rewrite'             => array(
            'slug'       => 'team',
            'with_front' => false,
        ),

        'publicly_queryable' => true,
        'query_var'          => true,
        'show_in_rest'       => true,
    ));

    /**
     * Testimonial CPT
     */

    register_post_type('testimonial', array(
        'labels' =>  array(
            'name'                  => __('Testimonials', 'uk-mosque'),
            'singular_name'         => __('Testimonial', 'uk-mosque'),
            'menu_name'             => __('Testimonials', 'uk-mosque'),
            'name_admin_bar'        => __('Testimonial', 'uk-mosque'),
            'add_new'               => __('Add New', 'uk-mosque'),
            'add_new_item'          => __('Add New Testimonial', 'uk-mosque'),
            'new_item'              => __('New Testimonial', 'uk-mosque'),
            'edit_item'             => __('Edit Testimonial', 'uk-mosque'),
            'view_item'             => __('View Testimonial', 'uk-mosque'),
            'all_items'             => __('All Testimonials', 'uk-mosque'),
            'search_items'          => __('Search Testimonials', 'uk-mosque'),
            'not_found'             => __('No testimonials found.', 'uk-mosque'),
            'not_found_in_trash'    => __('No testimonials found in Trash.', 'uk-mosque'),
            'featured_image'        => __('Author Photo', 'uk-mosque'),
            'set_featured_image'    => __('Set Author Photo', 'uk-mosque'),
            'remove_featured_image' => __('Remove Author Photo', 'uk-mosque'),
            'use_featured_image'    => __('Use as Author Photo', 'uk-mosque'),
        ),

        'public'             => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_admin_bar'  => true,
        'show_in_nav_menus'  => true,

        'has_archive'        => true,
        'supports' => array(
            'title',
            'editor',
            'thumbnail',
        ),

        'menu_icon' => 'dashicons-format-quote',

        'show_in_rest' => true,

        'publicly_queryable' => true,
        'query_var'         => true,
    ));

    /**
     * Service CPT
     */

    register_post_type('service', array(
        'labels' => array(
            'name'                  => __('Services', 'uk-mosque'),
            'singular_name'         => __('Service', 'uk-mosque'),
            'menu_name'             => __('Services', 'uk-mosque'),
            'name_admin_bar'        => __('Service', 'uk-mosque'),

            'add_new'               => __('Add New', 'uk-mosque'),
            'add_new_item'          => __('Add New Service', 'uk-mosque'),
            'new_item'              => __('New Service', 'uk-mosque'),
            'edit_item'             => __('Edit Service', 'uk-mosque'),
            'view_item'             => __('View Service', 'uk-mosque'),
            'all_items'             => __('All Services', 'uk-mosque'),
            'search_items'          => __('Search Services', 'uk-mosque'),

            'not_found'             => __('No services found.', 'uk-mosque'),
            'not_found_in_trash'    => __('No services found in Trash.', 'uk-mosque'),

            'featured_image'        => __('Service Image', 'uk-mosque'),
            'set_featured_image'    => __('Set Service Image', 'uk-mosque'),
            'remove_featured_image' => __('Remove Service Image', 'uk-mosque'),
            'use_featured_image'    => __('Use as Service Image', 'uk-mosque'),
        ),
        'public'             => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_admin_bar'  => true,
        'show_in_nav_menus'  => true,

        'has_archive' => true,

        'rewrite' => array(
            'slug'       => 'services',
            'with_front' => false,
        ),

        'supports' => array(
            'title',
            'excerpt',
            'editor',
            'thumbnail',
        ),

        'menu_icon' => 'dashicons-admin-tools',

        'show_in_rest' => true,

        'publicly_queryable' => true,
        'query_var'          => true,
    ));

    /**
     * FAQ CPT
     */

    register_post_type('faq', array(
        'labels' => array(
            'name'               => __('FAQs', 'uk-mosque'),
            'singular_name'      => __('FAQ', 'uk-mosque'),
            'menu_name'          => __('FAQs', 'uk-mosque'),
            'name_admin_bar'     => __('FAQ', 'uk-mosque'),

            'add_new'            => __('Add New', 'uk-mosque'),
            'add_new_item'       => __('Add New FAQ', 'uk-mosque'),
            'new_item'           => __('New FAQ', 'uk-mosque'),
            'edit_item'          => __('Edit FAQ', 'uk-mosque'),
            'view_item'          => __('View FAQ', 'uk-mosque'),
            'all_items'          => __('All FAQs', 'uk-mosque'),
            'search_items'       => __('Search FAQs', 'uk-mosque'),

            'not_found'          => __('No FAQs found.', 'uk-mosque'),
            'not_found_in_trash' => __('No FAQs found in Trash.', 'uk-mosque'),
        ),
        'public'             => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_admin_bar'  => true,
        'show_in_nav_menus'  => true,

        'has_archive' => true,

        'rewrite' => array(
            'slug'       => 'faqs',
            'with_front' => false,
        ),

        'supports' => array(
            'title',
            'editor',
        ),

        'menu_icon' => 'dashicons-editor-help',

        'show_in_rest' => true,

        'publicly_queryable' => true,
        'query_var'          => true,
    ));


    /**
     * Gallery CPT
     */

    register_post_type('gallery_item', array(
        'labels' => array(
            'name'                  => __('Gallery', 'uk-mosque'),
            'singular_name'         => __('Gallery Item', 'uk-mosque'),
            'menu_name'             => __('Gallery', 'uk-mosque'),
            'name_admin_bar'        => __('Gallery Item', 'uk-mosque'),

            'add_new'               => __('Add New', 'uk-mosque'),
            'add_new_item'          => __('Add New Gallery Item', 'uk-mosque'),
            'new_item'              => __('New Gallery Item', 'uk-mosque'),
            'edit_item'             => __('Edit Gallery Item', 'uk-mosque'),
            'view_item'             => __('View Gallery Item', 'uk-mosque'),
            'all_items'             => __('All Gallery Items', 'uk-mosque'),
            'search_items'          => __('Search Gallery', 'uk-mosque'),

            'not_found'             => __('No gallery items found.', 'uk-mosque'),
            'not_found_in_trash'    => __('No gallery items found in Trash.', 'uk-mosque'),

            'featured_image'        => __('Gallery Photo', 'uk-mosque'),
            'set_featured_image'    => __('Set Gallery Photo', 'uk-mosque'),
            'remove_featured_image' => __('Remove Gallery Photo', 'uk-mosque'),
            'use_featured_image'    => __('Use as Gallery Photo', 'uk-mosque'),
        ),
        'public'             => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_admin_bar'  => true,
        'show_in_nav_menus'  => true,

        'has_archive' => true,

        'rewrite' => array(
            'slug'       => 'gallery',
            'with_front' => false,
        ),

        'supports' => array(
            'title',
            'thumbnail',
        ),

        'menu_icon' => 'dashicons-format-gallery',

        'show_in_rest' => true,

        'publicly_queryable' => true,
        'query_var'          => true,
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

/**
 * Add custom columns to Donation CPT
 */

function uk_mosque_donation_column($columns)
{
    return array(
        'cb'            => $columns['cb'],
        'title'         => __('Donation Title', 'uk-mosque'),
        'donation_category'    => __('Category', 'uk-mosque'),
        'donation_goal_amount'  => __('Goal', 'uk-mosque'),
        'donation_raised_amount' => __('Raised', 'uk-mosque'),
        'donation_start_date'   => __('Start Date', 'uk-mosque'),
        'donation_end_date'     => __('End Date', 'uk-mosque'),
        'date'                  => __('Date', 'uk-mosque'),
    );
}

add_filter(
    'manage_donation_posts_columns',
    'uk_mosque_donation_column'
);

/**
 * Display Donation Column Values
 */

function uk_mosque_donation_column_content($column, $post_id)
{
    switch ($column) {


        case 'donation_category':

            $terms = get_the_terms(
                $post_id,
                'donation_category'
            );

            if (
                !empty($terms)
                &&
                !is_wp_error($terms)
            ) {

                $categories = array();

                foreach ($terms as $term) {
                    $categories[] = esc_html($term->name);
                }

                echo implode(', ', $categories);
            } else {

                echo '—';
            }

            break;



        case 'donation_goal_amount':

            $goal_amount = get_post_meta(
                $post_id,
                '_donation_goal_amount',
                true
            );

            if ($goal_amount !== '') {

                echo esc_html(
                    number_format_i18n(
                        (float) $goal_amount,
                        2
                    )
                );
            } else {

                echo '—';
            }

            break;



        case 'donation_raised_amount':

            $raised_amount = get_post_meta(
                $post_id,
                '_donation_raised_amount',
                true
            );

            if ($raised_amount !== '') {

                echo esc_html(
                    number_format_i18n(
                        (float) $raised_amount,
                        2
                    )
                );
            } else {

                echo '—';
            }

            break;


        case 'donation_start_date':

            $start_date = get_post_meta(
                $post_id,
                '_donation_start_date',
                true
            );

            if ($start_date) {

                echo esc_html(
                    date_i18n(
                        get_option('date_format'),
                        strtotime($start_date)
                    )
                );
            } else {

                echo '—';
            }

            break;



        case 'donation_end_date':

            $end_date = get_post_meta(
                $post_id,
                '_donation_end_date',
                true
            );

            if ($end_date) {

                echo esc_html(
                    date_i18n(
                        get_option('date_format'),
                        strtotime($end_date)
                    )
                );
            } else {

                echo '—';
            }

            break;
    }
}

add_action(
    'manage_donation_posts_custom_column',
    'uk_mosque_donation_column_content',
    10,
    2
);