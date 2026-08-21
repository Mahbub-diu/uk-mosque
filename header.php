<?php

/**
 * The header for our theme
 * 
 * Displays all of the <head> section and everything up till the main content.
 * 
 * @package uk-mosque
 */

?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php echo esc_attr(get_bloginfo('charset')); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/assets/images/favicon.png"
        type="image/x-icon">
    <link rel="icon" href="<?php echo get_template_directory_uri(); ?>/assets/images/favicon.png" type="image/x-icon">

    <?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>


    <div class="page-wrapper">
        <!-- Preloader Start -->
        <div class="preloader"></div>

        <!-- Back-to-top start -->
        <button id="back-top" class="back-to-top">
            <i class="fa-regular fa-arrow-up"></i>
        </button>
        <!-- Back-to-top start -->

        <!-- Main Header-->
        <header class="main-header header-style-one">
            <div class="outer-container">
                <div class="header-lower anim-fade-move" data-delay="0.25">
                    <div class="inner-container">
                        <!-- Main box -->
                        <div class="main-box">
                            <div class="logo-box">
                                <div class="logo">
                                    <?php
                                    if (has_custom_logo()) {
                                        the_custom_logo();
                                    } else {
                                    ?>
                                        <a href="<?php echo esc_url(home_url('/')); ?>">
                                            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/logo.png"
                                                alt="<?php bloginfo('name'); ?>">
                                        </a>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>

                            <!--Nav Box-->
                            <div class="nav-outer">
                                <nav class="nav main-menu">
                                    <?php
                                    wp_nav_menu(
                                        array(
                                            'theme_location' => 'primary_menu',
                                            'menu_class'     => 'navigation',
                                            'fallback_cb'    => false,
                                        )
                                    );
                                    ?>
                                </nav>
                            </div>

                            <div class="action-box">
                                <div class="contact-widget">
                                    <a href="page-contact.html">
                                        <i class="icon fa-classic fa-solid fa-location-dot"></i>
                                        <span>
                                            <?php echo esc_html(get_theme_mod('mosque_address')); ?>
                                        </span>
                                    </a>
                                    <a href="tel:<?php echo esc_attr(get_theme_mod('mosque_phone')); ?>">
                                        <i class="icon fa-classic fa-solid fa-phone-volume"></i>
                                        <span>
                                            <?php echo esc_html(get_theme_mod('mosque_phone')); ?>
                                        </span>
                                    </a>
                                </div>
                                <a href="<?php echo esc_url(home_url('/prayer-times/')); ?>" class="btn-style-five">
                                    <?php echo esc_html__('Prayer Time', 'uk-mosque'); ?>
                                </a>

                                <!-- Mobile Nav toggler -->
                                <div class="mobile-nav-toggler">
                                    <div class="shape-line-img"><i class="fas fa-bars"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mobile Menu  -->
            <div class="mobile-menu">
                <div class="menu-backdrop"></div>
                <!--Here Menu Will Come Automatically Via Javascript / Same Menu as in Header-->
                <nav class="menu-box">
                    <div class="upper-box">
                        <div class="nav-logo">
                            <a href="<?php echo esc_url(home_url('/')); ?>">
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/logo-2.png"
                                    alt="<?php bloginfo('name'); ?>">
                            </a>
                        </div>
                        <div class="close-btn"><i class="icon fa fa-times"></i></div>
                    </div>
                    <ul class="navigation clearfix">
                        <!--Keep This Empty / Menu will come through Javascript-->
                    </ul>
                    <ul class="contact-list-one">
                        <li>
                            <i class="icon lnr-icon-envelope1"></i>
                            <span class="title">Send Email</span>
                            <div class="text">
                                <a href="#">
                                    <span class="__cf_email__" data-cfemail="">
                                        <?php echo esc_html(get_theme_mod('mosque_email'));  ?>
                                    </span>
                                </a>
                            </div>
                        </li>
                    </ul>
                    <ul class="social-links">
                        <li>
                            <a href="<?php echo esc_attr(get_theme_mod('mosque_twitter')); ?>">
                                <i class="icon fab fa-twitter">

                                </i>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo esc_attr(get_theme_mod('mosque_facebook')); ?>">
                                <i class="icon fab fa-facebook-f">

                                </i>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo esc_attr(get_theme_mod('mosque_instagram')); ?>">
                                <i class="icon fab fa-instagram">

                                </i>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo esc_attr(get_theme_mod('mosque_youtube')); ?>">
                                <i class="icon  fab fa-youtube">

                                </i>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
            <!-- End Mobile Menu -->

            <!-- Sticky Header  -->
            <div class="sticky-header">
                <div class="auto-container">
                    <div class="inner-container">
                        <!--Logo-->
                        <div class="logo">
                            <?php
                            if (has_custom_logo()) {
                                the_custom_logo();
                            } else {
                            ?>
                                <a href="<?php echo esc_url(home_url('/')); ?>">
                                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/logo.png"
                                        alt="<?php bloginfo('name'); ?>">
                                </a>
                            <?php
                            }
                            ?>
                        </div>

                        <!--Right Col-->
                        <div class="nav-outer">
                            <!-- Main Menu -->
                            <nav class="main-menu">
                                <div class="navbar-collapse show collapse clearfix">
                                    <ul class="navigation clearfix">
                                        <!--Keep This Empty / Menu will come through Javascript-->
                                    </ul>
                                </div>
                            </nav>
                            <!-- Main Menu End-->

                            <!--Mobile Navigation Toggler-->
                            <div class="mobile-nav-toggler"><span class="icon lnr-icon-bars"></span></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Sticky Menu -->
        </header>
        <!--End Main Header -->

        <div id="smooth-wrapper">
            <div id="smooth-content">