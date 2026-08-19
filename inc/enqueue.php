<?php

if (!defined('ABSPATH')) {
    exit;
}

function uk_mosque_enqueue_scripts()
{
    $version = wp_get_theme()->get('Version');

    // enqueue styles start from here 

    wp_enqueue_style('enq-bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.min.css', array(), $version);
    wp_enqueue_style('enq-style', get_template_directory_uri() . '/assets/css/style.css', array(), $version);

    // enqueue styles ends here 

    // enqueue scripts start from here 

    wp_enqueue_script('enq-jquery', get_template_directory_uri() . '/assets/js/jquery.js', array(), $version, true);

    wp_enqueue_script('enq-popper', get_template_directory_uri() . '/assets/js/popper.min.js', array(), $version, true);

    wp_enqueue_script('enq-bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array(), $version, true);

    wp_enqueue_script('enq-fancybox', get_template_directory_uri() . '/assets/js/jquery.fancybox.js', array('enq-jquery'), $version, true);

    wp_enqueue_script('enq-jquery-ui', get_template_directory_uri() . '/assets/js/jquery-ui.js', array('enq-jquery'), $version, true);

    wp_enqueue_script('enq-select2', get_template_directory_uri() . '/assets/js/select2.min.js', array('enq-jquery'), $version, true);

    wp_enqueue_script('enq-appear', get_template_directory_uri() . '/assets/js/appear.js', array(), $version, true);

    wp_enqueue_script('enq-knob', get_template_directory_uri() . '/assets/js/knob.js', array(), $version, true);

    wp_enqueue_script('enq-swiper', get_template_directory_uri() . '/assets/js/swiper.min.js', array(), $version, true);

    wp_enqueue_script('enq-ripple-2', get_template_directory_uri() . '/assets/js/ripple-2.js', array(), $version, true);

    wp_enqueue_script('gsap', get_template_directory_uri() . '/assetsjs/gsap.min.js', array(), null, true);

    wp_enqueue_script('three', get_template_directory_uri() . '/assetsjs/three.js', array(), null, true);

    wp_enqueue_script('gsap-scrolltrigger', get_template_directory_uri() . '/assetsjs/ScrollTrigger.min.js', array('gsap'), null, true);

    wp_enqueue_script('split-type', get_template_directory_uri() . '/assetsjs/splitType.js', array(), null, true);

    wp_enqueue_script('gsap-scrollsmoother', get_template_directory_uri() . '/assetsjs/gsap-scroll-smoother.js', array('gsap', 'gsap-scrolltrigger'), null, true);

    wp_enqueue_script('gsap-scrollto', get_template_directory_uri() . '/assetsjs/gsap-scroll-to-plugin.js', array('gsap'), null, true);

    wp_enqueue_script('splittext', get_template_directory_uri() . '/assetsjs/SplitText.min.js', array('gsap'), null, true);

    wp_enqueue_script('wow', get_template_directory_uri() . '/assetsjs/wow.js', array(), null, true);

    wp_enqueue_script('aos', get_template_directory_uri() . '/assetsjs/aos.js', array(), null, true);

    wp_enqueue_script('theme-script', get_template_directory_uri() . '/assetsjs/script.js', array('jquery'), null, true);

    wp_enqueue_script('custom-gsap', get_template_directory_uri() . '/assetsjs/custom-gsap.js', array('gsap', 'gsap-scrolltrigger', 'split-type', 'gsap-scrollsmoother', 'gsap-scrollto', 'splittext'), null, true);

    // enqueue scripts ends here 
}

add_action('wp_enqueue_scripts', 'uk_mosque_enqueue_scripts');