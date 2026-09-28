<?php

/**
 * Shared template helpers.
 *
 * @package uk-mosque
 */

defined('ABSPATH') || exit;


/**
 * Read one value from a page's option array, falling back to the declared default.
 *
 * @param string $page     Page slug, e.g. 'home'.
 * @param string $key      Field key, e.g. 'hero_title'.
 * @param mixed  $fallback Used when neither a saved value nor a declared default exists.
 * @return mixed
 */
function uk_mosque_opt($page, $key, $fallback = '')
{
    static $values   = array();
    static $defaults = array();

    if (!isset($values[$page])) {
        $def              = uk_mosque_get_option_page($page);
        $values[$page]    = get_option($def['option'] ?? 'uk_mosque_' . $page . '_options', array());
        $defaults[$page]  = uk_mosque_option_defaults($page);

        if (!is_array($values[$page])) {
            $values[$page] = array();
        }
    }

    if (isset($values[$page][$key]) && '' !== $values[$page][$key]) {
        return $values[$page][$key];
    }

    if (isset($defaults[$page][$key]) && '' !== $defaults[$page][$key]) {
        return $defaults[$page][$key];
    }

    return $fallback;
}


/**
 * Flatten a page's field definitions into key => default.
 *
 * @param string $page_slug
 * @return array
 */
function uk_mosque_option_defaults($page_slug)
{
    $page = uk_mosque_get_option_page($page_slug);
    $out  = array();

    if (!$page) {
        return $out;
    }

    foreach ($page['sections'] as $section) {
        foreach ($section['fields'] as $key => $field) {
            $out[$key] = $field['default'] ?? '';
        }
    }

    return $out;
}


/**
 * Shorthand for the Home page options.
 */
function uk_mosque_home($key, $fallback = '')
{
    return uk_mosque_opt('home', $key, $fallback);
}


/**
 * Shorthand for the About page options.
 */
function uk_mosque_about($key, $fallback = '')
{
    return uk_mosque_opt('about', $key, $fallback);
}


/**
 * A dialable tel: href.
 *
 * Display numbers carry spaces and brackets; tel: must not.
 */
function uk_mosque_tel_href($phone)
{
    return 'tel:' . preg_replace('/[^0-9+]/', '', (string) $phone);
}


/**
 * URL of the page using the Contact template.
 *
 * Falls back to a page with the slug "contact", then to the home page.
 */
function uk_mosque_contact_page_url()
{
    static $url = null;

    if (null !== $url) {
        return $url;
    }

    $pages = get_posts(
        array(
            'post_type'      => 'page',
            'posts_per_page' => 1,
            'fields'         => 'ids',
            'no_found_rows'  => true,
            'meta_key'       => '_wp_page_template',
            'meta_value'     => 'contact.php',
        )
    );

    if ($pages) {
        $url = get_permalink($pages[0]);
        return $url;
    }

    $page = get_page_by_path('contact');
    $url  = $page ? get_permalink($page) : home_url('/');

    return $url;
}


/**
 * Shorthand for the Contact page options.
 */
function uk_mosque_contact($key, $fallback = '')
{
    return uk_mosque_opt('contact', $key, $fallback);
}


/**
 * Render the selected Contact Form 7 form.
 *
 * Returns an admin-only notice rather than silent emptiness when the form is
 * missing, so a broken selection is obvious to whoever can fix it.
 *
 * @param int|string $form_id CF7 post ID.
 * @return string
 */
function uk_mosque_cf7_form($form_id)
{
    $form_id = absint($form_id);

    if (!defined('WPCF7_VERSION')) {
        return current_user_can('manage_options')
            ? '<p class="uk-mosque-admin-notice">' . esc_html__('Contact Form 7 is not active.', 'uk-mosque') . '</p>'
            : '';
    }

    // Nothing chosen yet: fall back to the first published form so a fresh
    // install still shows a working contact page.
    if (!$form_id) {
        $first = get_posts(
            array(
                'post_type'      => 'wpcf7_contact_form',
                'posts_per_page' => 1,
                'orderby'        => 'ID',
                'order'          => 'ASC',
                'fields'         => 'ids',
            )
        );

        $form_id = $first ? (int) $first[0] : 0;
    }

    if (!$form_id || 'wpcf7_contact_form' !== get_post_type($form_id)) {
        return current_user_can('manage_options')
            ? '<p class="uk-mosque-admin-notice">' . esc_html__('No contact form found. Create one under Contact → Contact Forms, then select it in Theme Options → Contact Page.', 'uk-mosque') . '</p>'
            : '';
    }

    return do_shortcode(sprintf('[contact-form-7 id="%d"]', $form_id));
}


/**
 * Build a Google Maps embed URL from a plain place name or address.
 *
 * Storing a query rather than pasted iframe markup keeps untrusted HTML out of
 * the options table entirely.
 *
 * @param string $query
 * @param int    $zoom
 * @return string
 */
function uk_mosque_map_embed_url($query, $zoom = 14)
{
    $query = trim(wp_strip_all_tags((string) $query));

    if ('' === $query) {
        return '';
    }

    return add_query_arg(
        array(
            'q'      => rawurlencode($query),
            't'      => '',
            'z'      => max(1, min(21, (int) $zoom)),
            'ie'     => 'UTF8',
            'iwloc'  => 'B',
            'output' => 'embed',
        ),
        'https://maps.google.com/maps'
    );
}


/**
 * Is a section switched on?
 *
 * Sections default to visible, so an unsaved options row still renders the page.
 *
 * @param string $page Page slug, e.g. 'home'.
 * @param string $key  Section key, e.g. 'hero' (the '_enable' suffix is added).
 */
function uk_mosque_section_on($page, $key)
{
    return (bool) uk_mosque_opt($page, $key . '_enable', 1);
}


/** Is a Home section switched on? */
function uk_mosque_home_on($key)
{
    return uk_mosque_section_on('home', $key);
}


/** Is an About section switched on? */
function uk_mosque_about_on($key)
{
    return uk_mosque_section_on('about', $key);
}


/** Is a Contact section switched on? */
function uk_mosque_contact_on($key)
{
    return uk_mosque_section_on('contact', $key);
}


/**
 * Echo a section heading that may contain <br>.
 */
function uk_mosque_the_title_html($value)
{
    echo wp_kses($value, uk_mosque_allowed_title_html());
}


/**
 * Echo an image from a stored attachment ID, falling back to a bundled theme asset.
 *
 * @param int    $attachment_id  Attachment ID, or 0/'' for none.
 * @param string $fallback_path  Path under assets/images/, e.g. 'banner/banner-image.jpg'.
 * @param string $size           Registered image size.
 * @param array  $attr           Extra <img> attributes.
 */
function uk_mosque_option_image($attachment_id, $fallback_path, $size = 'full', $attr = array())
{
    $attachment_id = absint($attachment_id);

    if ($attachment_id) {
        $html = wp_get_attachment_image($attachment_id, $size, false, $attr);

        if ($html) {
            echo $html;
            return;
        }
    }

    printf(
        '<img src="%s" alt="%s">',
        esc_url(get_template_directory_uri() . '/assets/images/' . ltrim($fallback_path, '/')),
        esc_attr($attr['alt'] ?? '')
    );
}


/**
 * Configured social profiles, in display order, with the blank ones dropped.
 *
 * The header and footer both hardcoded four <li>s, so an unset profile rendered
 * as a link to nowhere. Returning only what is filled in fixes that in one place.
 *
 * @return array[] key => array( url, label, icon )
 */
function uk_mosque_social_links()
{
    $profiles = array(
        'facebook'  => array('mosque_facebook',  __('Facebook', 'uk-mosque'),  'fa-brands fa-facebook-f'),
        'twitter'   => array('mosque_twitter',   __('X', 'uk-mosque'),         'fa-brands fa-x-twitter'),
        'instagram' => array('mosque_instagram', __('Instagram', 'uk-mosque'), 'fa-brands fa-instagram'),
        'youtube'   => array('mosque_youtube',   __('YouTube', 'uk-mosque'),   'fa-brands fa-youtube'),
    );

    $links = array();

    foreach ($profiles as $key => $profile) {
        list($mod, $label, $icon) = $profile;

        $url = get_theme_mod($mod);

        if (!$url) {
            continue;
        }

        $links[$key] = array(
            'url'   => $url,
            'label' => $label,
            'icon'  => $icon,
        );
    }

    return $links;
}


/**
 * Format a money value in one place.
 */
function uk_mosque_money($amount)
{
    return '£' . number_format((float) $amount, 0);
}


/**
 * Inline one of the theme's own prayer-time SVG icons.
 *
 * These are theme files, never user input, so the raw markup is safe to echo.
 *
 * @param string $key fajr|dhuhr|asr|maghrib|isha|jummah
 * @return string
 */
function uk_mosque_prayer_icon($key)
{
    $file = get_template_directory() . '/assets/images/icons/prayer/' . sanitize_key($key) . '.svg';

    if (!file_exists($file)) {
        return '';
    }

    return file_get_contents($file);
}


/**
 * The prayers rendered by template-parts/global/prayer-times.php, in order.
 */
function uk_mosque_prayer_list()
{
    return array(
        'fajr'    => __('Fajr', 'uk-mosque'),
        'dhuhr'   => __('Zuhr', 'uk-mosque'),
        'asr'     => __('Asr', 'uk-mosque'),
        'maghrib' => __('Magrib', 'uk-mosque'),
        'isha'    => __('Isha', 'uk-mosque'),
        'jummah'  => __('Jummah', 'uk-mosque'),
    );
}


/**
 * Standard page-title / breadcrumb banner used by every inner page.
 *
 * Renders Home → [intermediate crumbs] → current page. The current page is
 * appended automatically, so $crumbs holds only what sits between the two.
 *
 * @param string $title  Heading text, also the final breadcrumb.
 * @param array  $crumbs Intermediate crumbs as [ label => url ]. An empty url
 *                       renders that crumb as plain text.
 */
function uk_mosque_page_banner($title, $crumbs = array())
{
    get_template_part(
        'template-parts/global/page-banner',
        null,
        array(
            'title'  => $title,
            'crumbs' => $crumbs,
        )
    );
}


/**
 * Upcoming events, soonest first. Shared by the homepage and the events archive.
 *
 * @param int $limit
 * @return WP_Query
 */
function uk_mosque_upcoming_events($limit = 3)
{
    return new WP_Query(
        array(
            'post_type'      => 'event',
            'post_status'    => 'publish',
            'posts_per_page' => (int) $limit,
            'meta_key'       => '_event_date',
            'orderby'        => 'meta_value',
            'order'          => 'ASC',
            'no_found_rows'  => true,
            'meta_query'     => array(
                array(
                    'key'     => '_event_date',
                    'value'   => current_time('Y-m-d'),
                    'compare' => '>=',
                    'type'    => 'DATE',
                ),
            ),
        )
    );
}


/**
 * Staggered WOW animation delay for items rendered in a loop.
 *
 * The static markup hardcoded .3s / .5s / .7s across each row; keep that rhythm.
 *
 * @param int $index Zero-based item index.
 * @return string
 */
function uk_mosque_wow_delay($index)
{
    $delays = array('.3s', '.5s', '.7s');
    return $delays[$index % count($delays)];
}


/**
 * Default copyright line, placeholders intact.
 *
 * Deliberately kept out of get_theme_mod()'s $default_value argument: WordPress
 * runs a string default through sprintf(), '%site%' is close enough to '%s' to
 * trigger that, and sprintf() then fatals on the unknown '%y' specifier.
 *
 * @return string
 */
function uk_mosque_footer_copyright_default()
{
    return '© %year% %site%. All Rights Reserved.';
}


/**
 * Footer copyright line with %year% and %site% resolved.
 *
 * The placeholders keep the line editable without inviting raw HTML into a
 * Customizer text field.
 *
 * @return string HTML containing at most a link around the site name.
 */
function uk_mosque_footer_copyright()
{
    $template = get_theme_mod('mosque_footer_copyright');

    if (!is_string($template) || '' === trim($template)) {
        $template = uk_mosque_footer_copyright_default();
    }

    return str_replace(
        array('%year%', '%site%'),
        array(
            wp_date('Y'),
            '<a href="' . esc_url(home_url('/')) . '">' . esc_html(get_bloginfo('name')) . '</a>',
        ),
        $template
    );
}
