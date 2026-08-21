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
require_once get_template_directory() . '/inc/custom-texonomy.php';
require_once get_template_directory() . '/inc/custom-metabox.php';
require_once get_template_directory() . '/inc/customizer.php';
