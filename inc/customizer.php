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

    /**
     * Footer
     */

    $wp_customize->add_section(
        'mosque_footer_options',
        array(
            'title'       => __('Footer', 'uk-mosque'),
            'description' => __('Footer logo, newsletter copy and the copyright line. The footer links come from Appearance → Menus → Footer Menu.', 'uk-mosque'),
            'priority'    => 31,
        )
    );

    /**
     * Footer logo
     *
     * Separate from the site logo: the footer sits on a dark background and
     * needs the light version of the mark.
     */
    $wp_customize->add_setting(
        'mosque_footer_logo',
        array(
            'default'           => '',
            'sanitize_callback' => 'absint',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Media_Control(
            $wp_customize,
            'mosque_footer_logo',
            array(
                'label'       => __('Footer Logo', 'uk-mosque'),
                'description' => __('Falls back to the bundled light logo when empty.', 'uk-mosque'),
                'section'     => 'mosque_footer_options',
                'mime_type'   => 'image',
            )
        )
    );

    /**
     * Newsletter widget
     */
    $wp_customize->add_setting(
        'mosque_footer_newsletter_enable',
        array(
            'default'           => true,
            'sanitize_callback' => 'uk_mosque_sanitize_checkbox',
        )
    );

    $wp_customize->add_control(
        'mosque_footer_newsletter_enable',
        array(
            'label'   => __('Show the newsletter sign-up', 'uk-mosque'),
            'section' => 'mosque_footer_options',
            'type'    => 'checkbox',
        )
    );

    $wp_customize->add_setting(
        'mosque_footer_newsletter_title',
        array(
            'default'           => __('Join Our Community of Givers', 'uk-mosque'),
            'sanitize_callback' => 'sanitize_text_field',
        )
    );

    $wp_customize->add_control(
        'mosque_footer_newsletter_title',
        array(
            'label'   => __('Newsletter heading', 'uk-mosque'),
            'section' => 'mosque_footer_options',
            'type'    => 'text',
        )
    );

    $wp_customize->add_setting(
        'mosque_footer_newsletter_text',
        array(
            'default'           => __('Receive the latest updates, success stories, and opportunities to make a difference.', 'uk-mosque'),
            'sanitize_callback' => 'sanitize_textarea_field',
        )
    );

    $wp_customize->add_control(
        'mosque_footer_newsletter_text',
        array(
            'label'   => __('Newsletter text', 'uk-mosque'),
            'section' => 'mosque_footer_options',
            'type'    => 'textarea',
        )
    );

    /**
     * Links column heading
     */
    $wp_customize->add_setting(
        'mosque_footer_links_title',
        array(
            'default'           => __('Quick Links', 'uk-mosque'),
            'sanitize_callback' => 'sanitize_text_field',
        )
    );

    $wp_customize->add_control(
        'mosque_footer_links_title',
        array(
            'label'   => __('Links column heading', 'uk-mosque'),
            'section' => 'mosque_footer_options',
            'type'    => 'text',
        )
    );

    /**
     * Copyright
     */
    $wp_customize->add_setting(
        'mosque_footer_copyright',
        array(
            /**
             * Deliberately empty. get_theme_mod() runs a string default through
             * sprintf() whenever it looks like it holds an '%s' pattern, and
             * '%site%' trips that test — sprintf() then fatals on '%year%' and
             * takes the whole Customizer screen down with it.
             *
             * uk_mosque_footer_copyright() already falls back to the default
             * template when the value is empty, so the rendered footer is
             * unchanged.
             */
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
        )
    );

    $wp_customize->add_control(
        'mosque_footer_copyright',
        array(
            'label'       => __('Copyright line', 'uk-mosque'),
            'description' => __('%year% becomes the current year and %site% becomes the site name, linked to the home page.', 'uk-mosque'),
            'section'     => 'mosque_footer_options',
            'type'        => 'text',
            'input_attrs' => array(
                'placeholder' => uk_mosque_footer_copyright_default(),
            ),
        )
    );
}


/**
 * Checkbox settings arrive as '1' or '' and must come back as a real bool.
 */
function uk_mosque_sanitize_checkbox($checked)
{
    return (isset($checked) && true === (bool) $checked);
}

add_action(
    'customize_register',
    'uk_mosque_customize_register'
);