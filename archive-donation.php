<?php

/**
 * Template Name: Donation
 * @package uk-mosque
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

?>


<!-- Start main-content -->
<section class="page-title">
    <div class="ripple-image ripples z-0">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/bg/page-title.jpg" alt="">
    </div>
    <div class="auto-container">
        <div class="title-outer text-center">
            <div class="h1 title">Causes</div>
            <ul class="page-breadcrumb">
                <li><a href="index.html">Home</a></li>
                <li>Causes</li>
            </ul>
        </div>
    </div>
</section>
<!-- end main-content -->

<!-- Causes Section -->
<section class="our-causes pt-120 pb-90">
    <div class="container">
        <div class="row">
            <div class="col-xl-4 col-md-6">
                <div class="causes-block mb-30">
                    <div class="inner-block">
                        <div class="image-box">
                            <div class="image">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/resource/causes-1.jpg"
                                    alt="">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/resource/causes-1.jpg"
                                    alt="">
                            </div>
                        </div>
                        <div class="content-box">
                            <div class="tag">Food</div>
                            <div class="h4 title"><a href="page-causes-details.html">Your small donation can bring food
                                    to a
                                    hungry family</a></div>
                            <div class="text">It is a long established fact that a reader will be distracted by the
                                readable
                                content </div>
                            <div class="donation-bar">
                                <div class="donation-progress">
                                    <div class="progress-track">
                                        <div class="progress-fill" style="width: 70%;">
                                            <span class="progress-thumb"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="donation-info">
                                <div class="fund-raise">
                                    <div class="icon"><i class="fa-sharp fa-light fa-box-heart"></i></div>
                                    <div class="text">Raised:<span class="value">$4,599</span></div>
                                </div>
                                <div class="fund-goal">
                                    <div class="icon"><i class="fa-sharp fa-light fa-bullseye-arrow"></i></div>
                                    <div class="text">Goal: <span class="value">$6,599</span></div>
                                </div>
                            </div>
                            <a href="page-causes-details.html" class="btn-style-six">Donate Now</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
<!-- End Causes Section -->

<?php get_footer(); ?>