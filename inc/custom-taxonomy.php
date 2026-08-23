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
            'query_var'         => 'donation_category',

            'rewrite' => array(
                'slug'       => 'donation-category',
                'with_front' => false,
            ),
        )
    );

    register_taxonomy(
        'team_role',
        array('team_member'),
        array(

            'labels' => array(
                'name'              => __('Team Roles', 'uk-mosque'),
                'singular_name'     => __('Team Role', 'uk-mosque'),
                'menu_name'         => __('Team Roles', 'uk-mosque'),

                'search_items'      => __('Search Team Roles', 'uk-mosque'),
                'all_items'         => __('All Team Roles', 'uk-mosque'),

                'parent_item'       => __('Parent Team Role', 'uk-mosque'),
                'parent_item_colon' => __('Parent Team Role:', 'uk-mosque'),

                'edit_item'         => __('Edit Team Role', 'uk-mosque'),
                'update_item'       => __('Update Team Role', 'uk-mosque'),

                'add_new_item'      => __('Add New Team Role', 'uk-mosque'),
                'new_item_name'     => __('New Team Role Name', 'uk-mosque'),

                'not_found'         => __('No team roles found.', 'uk-mosque'),
                'back_to_items'     => __('← Back to Team Roles', 'uk-mosque'),
            ),

            'public'            => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'show_in_rest'      => true,
            'hierarchical'      => true,
            'query_var'         => 'team_role',

            'rewrite'           => array(
                'slug'         => 'team-role',
                'with_front'   => false,
                'hierarchical' => true,
            ),

        )
    );
}

add_action('init', 'uk_mosque_register_taxonomies');