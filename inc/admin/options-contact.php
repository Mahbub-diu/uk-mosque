<?php

/**
 * Contact Page field definitions.
 *
 * The form is rendered by Contact Form 7 — this screen only picks which form.
 * Recipient, validation and confirmation messages are configured inside CF7.
 *
 * Phone, email and address come from the Customizer (they appear in the header
 * and footer too); this screen holds only the labels and page copy.
 *
 * @package uk-mosque
 */

defined('ABSPATH') || exit;


/**
 * Validate a chosen Contact Form 7 form ID.
 *
 * Checked against the post type rather than the select's choice list, because
 * that list is only built in the admin — validating against it would silently
 * blank a perfectly good ID on any save made outside an admin request.
 *
 * @param mixed $value
 * @return string Empty string when the ID is not a real CF7 form.
 */
function uk_mosque_sanitize_cf7_id($value)
{
    $id = absint($value);

    if ($id && 'wpcf7_contact_form' === get_post_type($id)) {
        return (string) $id;
    }

    return '';
}


/**
 * Published Contact Form 7 forms, as a select-friendly list.
 *
 * Only queried in the admin — the front end reads the stored ID directly and
 * never needs the choice list.
 *
 * @return array [ form ID => title ]
 */
function uk_mosque_cf7_form_choices()
{
    $choices = array('' => __('— Select a form —', 'uk-mosque'));

    if (!is_admin() || !post_type_exists('wpcf7_contact_form')) {
        return $choices;
    }

    $forms = get_posts(
        array(
            'post_type'        => 'wpcf7_contact_form',
            'posts_per_page'   => 100,
            'orderby'          => 'title',
            'order'            => 'ASC',
            'suppress_filters' => false,
        )
    );

    foreach ($forms as $form) {
        $choices[(string) $form->ID] = $form->post_title;
    }

    return $choices;
}


function uk_mosque_contact_sections()
{
    $cf7_active = defined('WPCF7_VERSION');

    $cf7_help = $cf7_active
        ? __('Manage fields, recipient and messages under Contact → Contact Forms.', 'uk-mosque')
        : __('Contact Form 7 is not active. Install and activate it, then choose a form here.', 'uk-mosque');

    return array(

        /* ------------------------------------------------------------ 1. Form */
        'form' => array(
            'title'       => __('1. Contact Form', 'uk-mosque'),
            'description' => $cf7_help,
            'fields'      => array(
                'form_enable' => uk_mosque_section_toggle(),
                'form_title'  => array(
                    'type'    => 'richtext',
                    'label'   => __('Heading', 'uk-mosque'),
                    'default' => 'Feel free to write',
                ),
                'form_cf7_id' => array(
                    'type'     => 'select',
                    'label'    => __('Contact Form 7 form', 'uk-mosque'),
                    'choices'  => uk_mosque_cf7_form_choices(),
                    'default'  => '',
                    'sanitize' => 'uk_mosque_sanitize_cf7_id',
                ),
            ),
        ),

        /* --------------------------------------------------- 2. Get in touch */
        'info' => array(
            'title'       => __('2. Get In Touch', 'uk-mosque'),
            'description' => __('The phone number, email address and postal address come from Appearance → Customize → Contact Information.', 'uk-mosque'),
            'fields'      => array(
                'info_enable' => uk_mosque_section_toggle(),
                'info_title'  => array(
                    'type'    => 'richtext',
                    'label'   => __('Heading', 'uk-mosque'),
                    'default' => 'Get in touch with us',
                ),
                'info_text' => array(
                    'type'    => 'textarea',
                    'label'   => __('Intro text', 'uk-mosque'),
                    'rows'    => 4,
                    'default' => 'We would love to hear from you. Visit us during prayer times, call the office, or send us a message and we will get back to you.',
                ),
                'info_phone_label' => array(
                    'type'    => 'text',
                    'label'   => __('Phone label', 'uk-mosque'),
                    'default' => 'Have any question?',
                ),
                'info_phone_badge' => array(
                    'type'    => 'text',
                    'label'   => __('Phone badge', 'uk-mosque'),
                    'default' => 'Free',
                    'help'    => __('Small highlighted word before the number. Leave empty to hide.', 'uk-mosque'),
                ),
                'info_email_label' => array(
                    'type'    => 'text',
                    'label'   => __('Email label', 'uk-mosque'),
                    'default' => 'Write email',
                ),
                'info_address_label' => array(
                    'type'    => 'text',
                    'label'   => __('Address label', 'uk-mosque'),
                    'default' => 'Visit anytime',
                ),
            ),
        ),

        /* ------------------------------------------------------------- 3. Map */
        'map' => array(
            'title'       => __('3. Map', 'uk-mosque'),
            'description' => __('Enter a place or address and the embed is built from it. Pasting raw iframe code is deliberately not supported.', 'uk-mosque'),
            'fields'      => array(
                'map_enable' => uk_mosque_section_toggle(),
                'map_query'  => array(
                    'type'  => 'text',
                    'label' => __('Place or address', 'uk-mosque'),
                    'help'  => __('e.g. 12 Mosque Road, Birmingham. Leave empty to use the Customizer address.', 'uk-mosque'),
                ),
                'map_zoom' => array(
                    'type'    => 'number',
                    'label'   => __('Zoom level', 'uk-mosque'),
                    'min'     => 1,
                    'max'     => 21,
                    'default' => 14,
                ),
            ),
        ),

    );
}
