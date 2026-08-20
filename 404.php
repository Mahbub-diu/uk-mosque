<?php

/**
 * 404 Page Template
 *
 * @package uk-mosque
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();


?>

<!-- 404 Section -->
<section class="">
    <div class="auto-container pt-120 pb-70">
        <div class="row">
            <div class="col-xl-12">
                <div class="error-page__inner">
                    <div class="error-page__title-box">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/resource/404.jpg" alt="">
                        <div class="h3 error-page__sub-title">Page not found!</div>
                    </div>
                    <p class="error-page__text">Sorry we can't find that page! The page you are looking <br /> for
                        was never existed.</p>
                    <form class="error-page__form">
                        <div class="error-page__form-input">
                            <input type="search" placeholder="Search here">
                            <button type="submit"><i class="lnr lnr-icon-magnifier"></i></button>
                        </div>
                    </form>
                    <a class="theme-btn btn-style-three" href="index.html">
                        <span class="btn-arrow-left"><i class="fal fa-arrow-right"></i></span>
                        <span class="btn-title">Back to Home</span>
                        <span class="btn-arrow-right"><i class="fal fa-arrow-right"></i></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<!--End 404 Section -->


<?php

get_footer(); ?>