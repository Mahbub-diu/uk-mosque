<?php

/**
 * 
 *
 * @package uk-mosque
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

$page_title = post_type_archive_title('', false);


?>

<!-- Start main-content -->
<section class="page-title">
    <div class="ripple-image ripples z-0">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/bg/page-title.jpg" alt="">
    </div>
    <div class="auto-container">
        <div class="title-outer text-center">
            <div class="h1 title">
                <?php post_type_archive_title(); ?>
            </div>
            <ul class="page-breadcrumb">
                <li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
                <li>Events</li>
            </ul>
        </div>
    </div>
</section>
<!-- end main-content -->

<!-- Events Section -->
<section class="event-section pt-120 pb-80">
    <div class="container">
        <div class="event-wrapper">
            <div class="event-block">
                <div class="inner-box">
                    <div class="image-box">
                        <figure class="image">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/event/event-image1.jpg"
                                alt="Image">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/event/event-image1.jpg"
                                alt="Image">
                            <div class="h4 tag">Nov <span>25</span> </div>
                        </figure>
                    </div>
                    <div class="content-box">
                        <div class="h3 title"><a href="page-event-details.html">Family Iftar Gathering</a></div>
                        <p class="text">It is a long established fact that a reader will be distracted by the readable
                            content
                            of a page when looking at its layout. The point of using Lorem Ipsum is that it has a
                            more-or-less
                            normal</p>
                        <div class="info">
                            <div>
                                <div class="h4 info-title"><span>Topic:</span> Iftar mahfil</div>
                                <div class="h4 info-title"><span>Time:</span> 09.00pm - 10.00pm</div>
                            </div>
                            <a class="theme-btn btn-style-three" href="page-contact.html">
                                <span class="btn-arrow-left"><i class="fal fa-arrow-right"></i></span>
                                <span class="btn-title">Join Now </span>
                                <span class="btn-arrow-right"><i class="fal fa-arrow-right"></i></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="event-block">
                <div class="inner-box">
                    <div class="image-box">
                        <figure class="image">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/event/event-image2.jpg"
                                alt="Image">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/event/event-image2.jpg"
                                alt="Image">
                            <div class="h4 tag">Nov <span>09</span> </div>
                        </figure>
                    </div>
                    <div class="content-box">
                        <div class="h3 title"><a href="page-event-details.html">Friday Night Halaqah</a></div>
                        <p class="text">It is a long established fact that a reader will be distracted by the readable
                            content
                            of a page when looking at its layout. The point of using Lorem Ipsum is that it has a
                            more-or-less
                            normal</p>
                        <div class="info">
                            <div>
                                <div class="h4 info-title"><span>Topic:</span> Patience in Islam</div>
                                <div class="h4 info-title"><span>Time:</span> 06.00pm - 07.00pm</div>
                            </div>
                            <a class="theme-btn btn-style-three" href="page-contact.html">
                                <span class="btn-arrow-left"><i class="fal fa-arrow-right"></i></span>
                                <span class="btn-title">Join Now </span>
                                <span class="btn-arrow-right"><i class="fal fa-arrow-right"></i></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="event-block">
                <div class="inner-box">
                    <div class="image-box">
                        <figure class="image">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/event/event-image3.jpg"
                                alt="Image">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/event/event-image3.jpg"
                                alt="Image">
                            <div class="h4 tag">Nov <span>08</span> </div>
                        </figure>
                    </div>
                    <div class="content-box">
                        <div class="h3 title">
                            <a href="page-event-details.html">Community Clean-Up Day</a>
                        </div>
                        <p class="text">It is a long established fact that a reader will be distracted by the readable
                            content
                            of a page when looking at its layout. The point of using Lorem Ipsum is that it has a
                            more-or-less
                            normal</p>
                        <div class="info">
                            <div>
                                <div class="h4 info-title"><span>Topic:</span> Clean-Up Day</div>
                                <div class="h4 info-title"><span>Time:</span> 08.00pm - 09.00pm</div>
                            </div>
                            <a class="theme-btn btn-style-three" href="page-contact.html">
                                <span class="btn-arrow-left"><i class="fal fa-arrow-right"></i></span>
                                <span class="btn-title">Join Now </span>
                                <span class="btn-arrow-right"><i class="fal fa-arrow-right"></i></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Events Section -->

<?php

get_footer(); ?>