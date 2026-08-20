<?php

/**
 * Template Name: Contact
 * Template Post Type: page
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
            <div class="h1 title">Conatct</div>
            <ul class="page-breadcrumb">
                <li><a href="index.html">Home</a></li>
                <li>Conatct</li>
            </ul>
        </div>
    </div>
</section>
<!-- end main-content -->

<!--Contact Details Start-->
<section class="contact-details pb-0 pt-110">
    <div class="container pt-0 pb-70">
        <div class="row">
            <div class="col-xl-7 col-lg-6">
                <div class="sec-title black">
                    <div class="h2">Feel free to write</div>
                </div>
                <!-- Contact Form -->
                <form id="contact_form" name="contact_form"
                    action="https://html.kodesolution.com/2026/islamus-html/includes/sendmail.php" method="post">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <input name="form_name" class="form-control" type="text" placeholder="Enter Name">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <input name="form_email" class="form-control required email" type="email"
                                    placeholder="Enter Email">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <input name="form_subject" class="form-control required" type="text"
                                    placeholder="Enter Subject">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <input name="form_phone" class="form-control" type="text" placeholder="Enter Phone">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <textarea name="form_message" class="form-control required" rows="7"
                            placeholder="Enter Message"></textarea>
                    </div>
                    <div class="mb-5">
                        <input name="form_botcheck" class="form-control" type="hidden" value="" />
                        <button class="theme-btn btn-style-one mr-10 mb-2 mb-sm-0" type="submit"
                            data-loading-text="Please wait...">
                            <span class="btn-arrow-left"><i class="fal fa-arrow-right"></i></span>
                            <span class="btn-title">Send message </span>
                            <span class="btn-arrow-right"><i class="fal fa-arrow-right"></i></span>
                        </button>
                        <button class="theme-btn btn-style-three" type="reset" data-loading-text="Please wait...">
                            <span class="btn-arrow-left"><i class="fal fa-arrow-right"></i></span>
                            <span class="btn-title">Reset </span>
                            <span class="btn-arrow-right"><i class="fal fa-arrow-right"></i></span>
                        </button>
                    </div>
                </form>
                <!-- Contact Form Validation-->
            </div>
            <div class="col-xl-5 col-lg-6">
                <div class="contact-details__right">
                    <div class="sec-title black">
                        <div class="h2">Get in touch with us</div>
                        <div class="text">Lorem ipsum is simply free text available dolor sit amet consectetur notted
                            adipisicing elit sed do eiusmod tempor incididunt simply dolore magna.</div>
                    </div>
                    <ul class="list-unstyled contact-details__info">
                        <li>
                            <div class="icon">
                                <span class="fa-classic fa-light fa-phone-plus"></span>
                            </div>
                            <div class="text">
                                <div class="h6 mb-1">Have any question?</div>
                                <a href="tel:980089850"><span>Free</span> +92 (020)-9850</a>
                            </div>
                        </li>
                        <li>
                            <div class="icon">
                                <span class="fal fa-envelope"></span>
                            </div>
                            <div class="text">
                                <div class="h6 mb-1">Write email</div>
                                <a
                                    href="https://html.kodesolution.com/cdn-cgi/l/email-protection#e7898282838f828b97a784888a9786899ec984888a"><span
                                        class="__cf_email__"
                                        data-cfemail="610f04040509040d1121020e0c11000f184f020e0c">[email&#160;protected]</span></a>
                            </div>
                        </li>
                        <li>
                            <div class="icon">
                                <span class="fal fa-location-arrow"></span>
                            </div>
                            <div class="text">
                                <div class="h6 mb-1">Visit anytime</div>
                                <span>66 broklyn golden street. New York</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!--Contact Details End-->

<!-- Map Section-->
<section class="map-section">
    <iframe class="map w-100"
        src="https://maps.google.com/maps?width=100%25&amp;height=600&amp;hl=en&amp;q=1%20Grafton%20Street,%20Dublin,%20Ireland+(My%20Business%20Name)&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe>
</section>
<!--End Map Section-->
<?php get_footer(); ?>