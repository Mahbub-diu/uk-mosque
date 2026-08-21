<?php

function uk_mosque_customize_register($wp_customize)
{
    /**
     * Mosque Contact Section
     */

    $wp_customize->add_section(
        'mosque_contact_options',
        array(
            'title'       => __('Contact Information', 'uk-mosque'),
            'description' => __('Manage contact information.', 'uk-mosque'),
            'priority'    => 30,
        )
    );

    /**
     * Address
     */
    $wp_customize->add_setting(
        'mosque_address',
        array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
        )
    );

    $wp_customize->add_control(
        'mosque_address',
        array(
            'label'   => __('Address', 'uk-mosque'),
            'section' => 'mosque_contact_options',
            'type'    => 'text',
        )
    );

    /**
     * Phone
     */
    $wp_customize->add_setting(
        'mosque_phone',
        array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
        )
    );

    $wp_customize->add_control(
        'mosque_phone',
        array(
            'label'   => __('Phone Number', 'uk-mosque'),
            'section' => 'mosque_contact_options',
            'type'    => 'text',
        )
    );

    /**
     * Email
     */
    $wp_customize->add_setting(
        'mosque_email',
        array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_email',
        )
    );

    $wp_customize->add_control(
        'mosque_email',
        array(
            'label'   => __('Email Address', 'uk-mosque'),
            'section' => 'mosque_contact_options',
            'type'    => 'email',
        )
    );

    /**
     * Mosque Social Links 
     */


    $wp_customize->add_section(
        'mosque_social_options',
        array(
            'title'       => __('Social Media Information', 'uk-mosque'),
            'description' => __('Manage Social Media information.', 'uk-mosque'),
            'priority'    => 30,
        )
    );

    /**
     * Facebook
     */
    $wp_customize->add_setting(
        'mosque_facebook',
        array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        )
    );

    $wp_customize->add_control(
        'mosque_facebook',
        array(
            'label'   => __('Facebook URL', 'uk-mosque'),
            'section' => 'mosque_social_options',
            'type'    => 'url',
        )
    );
    /**
     * Instagram
     */
    $wp_customize->add_setting(
        'mosque_instagram',
        array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        )
    );

    $wp_customize->add_control(
        'mosque_instagram',
        array(
            'label'   => __('Instagram URL', 'uk-mosque'),
            'section' => 'mosque_social_options',
            'type'    => 'url',
        )
    );


    /**
     * YouTube
     */
    $wp_customize->add_setting(
        'mosque_youtube',
        array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        )
    );

    $wp_customize->add_control(
        'mosque_youtube',
        array(
            'label'   => __('YouTube URL', 'uk-mosque'),
            'section' => 'mosque_social_options',
            'type'    => 'url',
        )
    );


    /**
     * X / Twitter
     */
    $wp_customize->add_setting(
        'mosque_twitter',
        array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        )
    );

    $wp_customize->add_control(
        'mosque_twitter',
        array(
            'label'   => __('X / Twitter URL', 'uk-mosque'),
            'section' => 'mosque_social_options',
            'type'    => 'url',
        )
    );
}

add_action(
    'customize_register',
    'uk_mosque_customize_register'
);