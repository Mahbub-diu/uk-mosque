<?php

/**
 *
 * package uk-mosque
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Theme Setup
 */

require_once get_template_directory() . '/inc/setup.php';
require_once get_template_directory() . '/inc/enqueue.php';
require_once get_template_directory() . '/inc/custom-post-type.php';
require_once get_template_directory() . '/inc/custom-taxonomy.php';
require_once get_template_directory() . '/inc/custom-metabox.php';
require_once get_template_directory() . '/inc/customizer.php';
require_once get_template_directory() . '/inc/contact-form-7.php';

/**
 * Theme Options
 *
 * The field definitions must load before the framework that consumes them.
 */
require_once get_template_directory() . '/inc/helpers.php';
require_once get_template_directory() . '/inc/admin/options-home.php';
require_once get_template_directory() . '/inc/admin/options-about.php';
require_once get_template_directory() . '/inc/admin/options-contact.php';
require_once get_template_directory() . '/inc/admin/options-prayer.php';
require_once get_template_directory() . '/inc/admin/options-framework.php';
