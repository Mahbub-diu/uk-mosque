<?php

/**
 * Single Donation Template
 *
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
            <div class="h1 title">Causes Details</div>
            <ul class="page-breadcrumb">
                <li>
                    <a href="<?php echo esc_url(home_url('/')); ?>">Home</a>

                </li>
                <li>Causes Details</li>
            </ul>
        </div>
    </div>
</section>
<!-- end main-content -->

<!--Start Services Details-->
<section class="services-details pt-120 pb-60">
    <div class="container">
        <div class="row">
            <!--Start Services Details Sidebar-->
            <div class="col-xl-4 col-lg-4">
                <div class="service-sidebar">
                    <!--Start Services Details Sidebar Single-->
                    <div class="sidebar-widget service-sidebar-single">
                        <div class="sidebar-service-list">
                            <ul>
                                <li>
                                    <a href="page-service-details.html" class="current"><i
                                            class="fas fa-angle-right"></i><span>Education Support</span></a>
                                </li>
                                <li class="current"><a href="page-service-details.html"><i
                                            class="fas fa-angle-right"></i><span>Medical Aid</span></a></li>
                                <li>
                                    <a href="page-service-details.html"><i class="fas fa-angle-right"></i><span>Food &
                                            Hunger
                                            Relief</span></a>
                                </li>
                                <li>
                                    <a href="page-service-details.html"><i class="fas fa-angle-right"></i><span>Orphan &
                                            Child
                                            Welfare</span></a>
                                </li>
                                <li>
                                    <a href="page-service-details.html"><i class="fas fa-angle-right"></i><span>Disaster
                                            &
                                            Emergency Relief</span></a>
                                </li>
                                <li>
                                    <a href="page-service-details.html"><i class="fas fa-angle-right"></i><span>Clean
                                            Water &
                                            Sanitation</span></a>
                                </li>
                            </ul>
                        </div>
                        <div class="service-details-help">
                            <div class="help-shape-1"></div>
                            <div class="help-shape-2"></div>
                            <div class="h2 help-title">Contact with us for any info</div>
                            <div class="help-icon">
                                <span class=" lnr-icon-phone-handset"></span>
                            </div>
                            <div class="help-contact">
                                <p>Need help? Talk to an team</p>
                                <a href="tel:01750050088">+880(175)005-0088</a>
                            </div>
                        </div>
                    </div>
                    <!--End Services Details Sidebar-->
                </div>
            </div>
            <!--Start Services Details Content-->
            <div class="col-xl-8 col-lg-8">
                <div class="services-details__content">
                    <img class="w-100"
                        src="<?php echo get_template_directory_uri(); ?>/assets/images/resource/service-details.jpg"
                        alt="" />
                    <div class="h3 mt-4">Donation Causes Overview</div>
                    <p>Lorem ipsum is simply free text used by copytyping refreshing. Neque porro est qui dolorem ipsum
                        quia quaed inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Aelltes
                        port
                        lacus quis enim var sed efficitur turpis gilla sed sit amet finibus eros. Lorem Ipsum is simply
                        dummy text of the printing and typesetting industry. Lorem Ipsum has been the ndustry standard
                        dummy
                        text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to
                        make
                    </p>
                    <p>When an unknown printer took a galley of type and scrambled it to make a type specimen book. It
                        has
                        survived not only five centuries, but also the leap into electronic typesetting, remaining
                        essentially unchanged Lorem ipsum dolor sit amet consec tetur adipis icing elit </p>
                    <div class="content mt-40">
                        <div class="text">
                            <div>Donation Causes Center</div>
                            <p>Lorem ipsum is simply free text used by copytyping refreshing. Neque porro est qui
                                dolorem
                                ipsum quia quaed inventore veritatis et quasi architecto beatae vitae dicta sunt
                                explicabo.</p>
                            <blockquote class="blockquote-one">Lorem ipsum dolor sit amet, consectetur notted
                                adipisicing elit
                                sed do eiusmod remaining essentially unchanged Lorem ipsum dolor sit amet consec tetur
                            </blockquote>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Services Details Content-->
        </div>
    </div>
</section>
<!--End Services Details-->

<!-- Help Donation Section Start -->
<section class="donation-section">
    <div class="outer-container">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-5 image-column">
                    <div class="inner-column">
                        <div class="sec-title mb-40">
                            <span class="sub-title bg-white">Help & Donate</span>
                            <div class="h2 title">Donate / Support <br> Our Center</div>
                            <p class="text mt-20">Your generous donations help us maintain our masjid, provide community
                                services, and educate future generations. Every contribution counts and is greatly
                                appreciated.
                            </p>
                        </div>
                        <figure class="image overlay-anim">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/donation/donation-image.jpg"
                                alt="Image">
                        </figure>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="donation-form">
                        <div class="h3 title mb-30">Make Donation</div>
                        <form id="donationForm">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" placeholder="Enter Your Name" name="name">
                                </div>
                                <div class="col-md-6">
                                    <input type="email" class="form-control" placeholder="Your Email" name="email">
                                </div>
                                <div class="col-12">
                                    <input type="text" class="form-control" placeholder="Company Name (Optional)"
                                        name="company">
                                </div>
                                <!-- Donation Amount Input -->
                                <div class="col-12">
                                    <input type="text" id="donationAmount" class="form-control donation-input"
                                        placeholder="$0" readonly>
                                </div>
                                <!-- Donation Amount Buttons -->
                                <div class="col-12">
                                    <div class="donation-amounts mt-10">
                                        <button type="button" class="amount-btn" data-amount="50">$50</button>
                                        <button type="button" class="amount-btn" data-amount="60">$60</button>
                                        <button type="button" class="amount-btn" data-amount="70">$70</button>
                                        <button type="button" class="amount-btn" data-amount="80">$80</button>
                                        <button type="button" class="amount-btn" data-amount="90">$90</button>
                                        <button type="button" class="amount-btn active" data-amount="100">$100</button>
                                        <button type="button" class="amount-btn custom-btn">Custom</button>
                                    </div>
                                </div>
                                <!-- Submit Button -->
                                <div class="col-12">
                                    <button type="submit" class="btn mt-10 btn-donate w-100">Submit Donation</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="sec-bg">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/shape/donation-bg.png" alt="Image">
        </div>
        <div class="sec-shape">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/shape/donation-shape.png" alt="Image">
        </div>
    </div>
    <div class="sec-hero">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/donation/donation-hero.png" alt="Image">
    </div>
</section>

<?php

get_footer(); ?>