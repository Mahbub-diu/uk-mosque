<?php

if (!defined('ABSPATH')) {
    exit;
}


function uk_mosque_register_taxonomies()
{
    register_taxonomy(
        'donation_category',
        array('donation'),
        array(

            'labels' => array(
                'name'              => __('Donation Categories', 'uk-mosque'),
                'singular_name'     => __('Donation Category', 'uk-mosque'),
                'search_items'      => __('Search Donation Categories', 'uk-mosque'),
                'all_items'         => __('All Donation Categories', 'uk-mosque'),
                'parent_item'       => __('Parent Donation Category', 'uk-mosque'),
                'parent_item_colon' => __('Parent Donation Category:', 'uk-mosque'),
                'edit_item'         => __('Edit Donation Category', 'uk-mosque'),
                'update_item'       => __('Update Donation Category', 'uk-mosque'),
                'add_new_item'      => __('Add New Donation Category', 'uk-mosque'),
                'new_item_name'     => __('New Donation Category Name', 'uk-mosque'),
                'menu_name'         => __('Categories', 'uk-mosque'),
            ),

            'hierarchical'      => true,
            'public'            => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'show_in_rest'      => true,

            'rewrite' => array(
                'slug'       => 'donation-category',
                'with_front' => false,
            ),
        )
    );
}

add_action('init', 'uk_mosque_register_taxonomies');