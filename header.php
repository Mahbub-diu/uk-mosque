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

    <?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>


    <div class="page-wrapper">
        <!-- Preloader Start -->
        <div class="preloader"></div>

        <!-- Main Header-->
        <header class="main-header header-style-one">
            <div class="outer-container">
                <div class="header-lower anim-fade-move" data-delay="0.25">
                    <div class="inner-container">
                        <!-- Main box -->
                        <div class="main-box">
                            <div class="logo-box">
                                <div class="logo">
                                    <a href="index.html"><img src="images/logo.png" alt="Logo"></a>
                                </div>
                            </div>

                            <!--Nav Box-->
                            <div class="nav-outer">
                                <nav class="nav main-menu">
                                    <ul class="navigation">
                                        <li class="dropdown current">
                                            <a href="index.html">Home</a>
                                            <ul>
                                                <li><a href="index.html">Home One</a></li>
                                                <li><a href="index-2.html">Home Two</a></li>
                                                <li><a href="index-3.html">Home Three</a></li>
                                                <li><a href="index-4.html">Home Four</a></li>
                                                <li><a href="index-5.html">Home Five</a></li>
                                            </ul>
                                        </li>
                                        <li class="dropdown">
                                            <a href="#">Pages</a>
                                            <ul>
                                                <li><a href="page-about.html">About</a></li>
                                                <li class="dropdown"><a href="#">Team</a>
                                                    <ul>
                                                        <li><a href="page-team.html">Team List</a></li>
                                                        <li><a href="page-team-details.html">Team Details</a></li>
                                                    </ul>
                                                </li>
                                                <li class="dropdown"><a href="#">Shop</a>
                                                    <ul>
                                                        <li><a href="shop-products.html">Products</a></li>
                                                        <li><a href="shop-products-sidebar.html">Products with
                                                                Sidebar</a></li>
                                                        <li><a href="shop-product-details.html">Product Details</a></li>
                                                        <li><a href="shop-cart.html">Cart</a></li>
                                                        <li><a href="shop-checkout.html">Checkout</a></li>
                                                    </ul>
                                                </li>
                                                <li><a href="page-testimonial.html">Testimonials</a></li>
                                                <li><a href="page-faq.html">Faq</a></li>
                                                <li><a href="page-404.html">Error 404</a></li>
                                            </ul>
                                        </li>
                                        <li class="dropdown"><a href="#">Donation</a>
                                            <ul>
                                                <li><a href="page-causes.html">Donation Page</a></li>
                                                <li><a href="page-causes-details.html">Donation Details</a></li>
                                            </ul>
                                        </li>
                                        <li class="dropdown"><a href="#">Events</a>
                                            <ul>
                                                <li><a href="page-events.html">Event Page</a></li>
                                                <li><a href="page-event-details.html">Event Details</a></li>
                                            </ul>
                                        </li>
                                        <li class="dropdown">
                                            <a href="#">News</a>
                                            <ul>
                                                <li><a href="news-grid.html">News Grid</a></li>
                                                <li><a href="news-details.html">News Details</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="page-contact.html">Contact</a></li>
                                    </ul>
                                </nav>
                            </div>

                            <div class="action-box">
                                <div class="contact-widget">
                                    <a href="page-contact.html"><i class="icon fa-classic fa-solid fa-location-dot"></i>
                                        <span>1901
                                            Thornridge Shiloh, Hawaii 81063</span></a>
                                    <a href="tel:01750050088"><i class="icon fa-classic fa-solid fa-phone-volume"></i>
                                        <span>+17 5005
                                            0088</span></a>
                                </div>
                                <a href="page-contact.html" class="btn-style-five">Prayer Time</a>

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
                            <a href="index.html"><img src="images/logo-2.png" alt=""></a>
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
                            <div class="text"><a
                                    href="https://html.kodesolution.com/cdn-cgi/l/email-protection#5a363b2d2935341a3f223b372a363f74393537"><span
                                        class="__cf_email__"
                                        data-cfemail="b8d9d4d5d996d4d9cfcbd7d6f8ddc0d9d5c8d4dd96dbd7d5">[email&#160;protected]</span></a>
                            </div>
                        </li>
                    </ul>
                    <ul class="social-links">
                        <li><a href="#"><i class="icon fab fa-twitter"></i></a></li>
                        <li><a href="#"><i class="icon fab fa-facebook-f"></i></a></li>
                        <li><a href="#"><i class="icon fab fa-pinterest-p"></i></a></li>
                        <li><a href="#"><i class="icon fab fa-vimeo-v"></i></a></li>
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
                            <a href="index.html"><img src="images/logo.png" alt=""></a>
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