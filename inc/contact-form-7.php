<?php

/**
 * Contact Form 7 integration.
 *
 * The theme supplies the full markup for its forms (Bootstrap grid + .theme-btn
 * buttons), so CF7's automatic paragraph formatting is turned off and a small
 * stylesheet aligns CF7's own validation output with the theme.
 *
 * @package uk-mosque
 */

defined('ABSPATH') || exit;


/**
 * Stop CF7 wrapping form templates in <p> and <br>.
 *
 * Applies to every form on the site: write the layout markup yourself in the
 * form template rather than relying on CF7 inserting line breaks.
 */
add_filter('wpcf7_autop_or_not', '__return_false');


/**
 * Load the CF7 skin only on pages that actually contain a form.
 */
function uk_mosque_cf7_styles()
{
    if (!defined('WPCF7_VERSION')) {
        return;
    }

    wp_enqueue_style(
        'uk-mosque-cf7',
        get_template_directory_uri() . '/assets/css/cf7-theme.css',
        array('enq-style'),
        wp_get_theme()->get('Version')
    );
}
add_action('wpcf7_enqueue_styles', 'uk_mosque_cf7_styles');
