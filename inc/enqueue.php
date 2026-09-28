<?php

if (!defined('ABSPATH')) {
    exit;
}

function uk_mosque_enqueue_scripts()
{
    $version = wp_get_theme()->get('Version');

    // enqueue styles start from here 

    wp_enqueue_style('enq-fonts', 'https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap', array(), null);

    // Vendor and theme stylesheets, in cascade order. Each depends on the one
    // before it so WordPress always prints them in exactly this sequence.
    $styles = array(
        'enq-bootstrap'        => 'bootstrap.min.css',
        'enq-animate'          => 'animate.css',
        'enq-aos'              => 'aos.css',
        'enq-swiper'           => 'swiper.min.css',
        'enq-fancybox'         => 'jquery.fancybox.min.css',
        'enq-jquery-ui'        => 'jquery-ui.css',
        'enq-linear'           => 'linear.css',
        'enq-select2'          => 'select2.min.css',
        'enq-fontawesome-free' => 'fontawesome-free.css',
        'enq-fontawesome'      => 'fontawesome.css',
        'enq-flaticon'         => 'flaticon-digitaal.css',
        'enq-tm-bs-mp'         => 'tm-bs-mp.css',
        'enq-tm-utility'       => 'tm-utility-classes.css',
        'enq-style'            => 'style.css',
    );

    $previous = array();
    foreach ($styles as $handle => $file) {
        wp_enqueue_style($handle, get_template_directory_uri() . '/assets/css/' . $file, $previous, $version);
        $previous = array($handle);
    }

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

    wp_enqueue_script('gsap', get_template_directory_uri() . '/assets/js/gsap.min.js', array(), null, true);

    wp_enqueue_script('three', get_template_directory_uri() . '/assets/js/three.js', array(), null, true);

    wp_enqueue_script('gsap-scrolltrigger', get_template_directory_uri() . '/assets/js/ScrollTrigger.min.js', array('gsap'), null, true);

    wp_enqueue_script('split-type', get_template_directory_uri() . '/assets/js/splitType.js', array(), null, true);

    wp_enqueue_script('gsap-scrollsmoother', get_template_directory_uri() . '/assets/js/gsap-scroll-smoother.js', array('gsap', 'gsap-scrolltrigger'), null, true);

    wp_enqueue_script('gsap-scrollto', get_template_directory_uri() . '/assets/js/gsap-scroll-to-plugin.js', array('gsap'), null, true);

    wp_enqueue_script('splittext', get_template_directory_uri() . '/assets/js/SplitText.min.js', array('gsap'), null, true);

    wp_enqueue_script('wow', get_template_directory_uri() . '/assets/js/wow.js', array(), null, true);

    wp_enqueue_script('aos', get_template_directory_uri() . '/assets/js/aos.js', array(), null, true);

    wp_enqueue_script('theme-script', get_template_directory_uri() . '/assets/js/script.js', array('jquery'), null, true);

    wp_enqueue_script('custom-gsap', get_template_directory_uri() . '/assets/js/custom-gsap.js', array('gsap', 'gsap-scrolltrigger', 'split-type', 'gsap-scrollsmoother', 'gsap-scrollto', 'splittext'), null, true);

    // enqueue scripts ends here 
}

add_action('wp_enqueue_scripts', 'uk_mosque_enqueue_scripts');
