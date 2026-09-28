<?php

/**
 * Front Page Template
 *
 * Every section is driven by Theme Options → Home Page. Repeating content comes
 * from the CPTs; headings, intro copy and images come from the options screen.
 *
 * @package uk-mosque
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

$assets = get_template_directory_uri() . '/assets/images';
?>


<?php if (uk_mosque_home_on('hero')) : ?>
    <!-- Banner section -->
    <section class="banner-section">
        <div class="outer-box">
            <div class="leaf">
                <img class="animation__arryUpDown" src="<?php echo esc_url($assets . '/shape/banner-leaf.png'); ?>" alt="">
            </div>
            <div class="inner-box">
                <div class="row g-5 align-items-end">
                    <div class="col-xl-8">
                        <div class="banner-content">
                            <span class="sub-title wow fadeInUp" data-wow-delay=".3s">
                                <?php echo esc_html(uk_mosque_home('hero_subtitle')); ?>
                            </span>
                            <div class="h1 title wa_title_spilt_1">
                                <?php uk_mosque_the_title_html(uk_mosque_home('hero_title')); ?>
                            </div>

                            <?php
                            $hero_btn1 = uk_mosque_home('hero_btn1_text');
                            $hero_btn2 = uk_mosque_home('hero_btn2_text');
                            ?>

                            <?php if ($hero_btn1 || $hero_btn2) : ?>
                                <div class="btn-box mt-30 wow fadeInUp" data-wow-delay=".5s">

                                    <?php if ($hero_btn1) : ?>
                                        <a class="theme-btn btn-style-one mr-10 mb-2 mb-sm-0"
                                            href="<?php echo esc_url(uk_mosque_home('hero_btn1_url', home_url('/'))); ?>">
                                            <span class="btn-arrow-left"><i class="fal fa-arrow-right"></i></span>
                                            <span class="btn-title"><?php echo esc_html($hero_btn1); ?></span>
                                            <span class="btn-arrow-right"><i class="fal fa-arrow-right"></i></span>
                                        </a>
                                    <?php endif; ?>

                                    <?php if ($hero_btn2) : ?>
                                        <a class="theme-btn btn-style-two"
                                            href="<?php echo esc_url(uk_mosque_home('hero_btn2_url', home_url('/'))); ?>">
                                            <span class="btn-arrow-left"><i class="fa-solid fa-play"></i></span>
                                            <span class="btn-title"><?php echo esc_html($hero_btn2); ?></span>
                                            <span class="btn-arrow-right"><i class="fa-solid fa-play"></i></span>
                                        </a>
                                    <?php endif; ?>

                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="banner-image bounce-y">
                            <figure class="image overlay-anim">
                                <?php uk_mosque_option_image(uk_mosque_home('hero_image'), 'banner/banner-image.jpg', 'large'); ?>
                            </figure>
                            <div class="image-bg">
                                <img src="<?php echo esc_url($assets . '/shape/banner-image-bg.png'); ?>" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sec-bg  ripple-image ripples z-0">
                <?php uk_mosque_option_image(uk_mosque_home('hero_bg'), 'banner/banner-bg.jpg', 'full'); ?>
            </div>
            <div class="shape1">
                <img src="<?php echo esc_url($assets . '/shape/banner-shape1.png'); ?>" alt="">
            </div>
            <div class="shape2">
                <img src="<?php echo esc_url($assets . '/shape/banner-shape2.png'); ?>" alt="">
            </div>
        </div>
    </section>
    <!-- Banner section -->
<?php endif; ?>


<?php if (uk_mosque_home_on('about')) : ?>
    <!-- About Section -->
    <section class="about-section pt-120">
        <div class="container">
            <div class="row g-4 justify-content-center">
                <div class="col-xl-6 col-lg-9 image-column">
                    <div class="inner-column">
                        <div class="image-box wow fadeInUp" data-wow-delay=".3s">
                            <figure class="image overlay-anim">
                                <?php uk_mosque_option_image(uk_mosque_home('about_image1'), 'about/about-image1.jpg', 'large'); ?>
                            </figure>
                            <div class="image-bg">
                                <img src="<?php echo esc_url($assets . '/shape/about-image1-shape.png'); ?>" alt="">
                            </div>
                        </div>
                        <div class="image-box image-box-two wow fadeInUp" data-wow-delay=".5s">
                            <figure class="image overlay-anim">
                                <?php uk_mosque_option_image(uk_mosque_home('about_image2'), 'about/about-image2.jpg', 'large'); ?>
                            </figure>
                            <div class="image-bg">
                                <img src="<?php echo esc_url($assets . '/shape/about-image2-shape.png'); ?>" alt="">
                            </div>
                        </div>
                        <div class="shape">
                            <img class="animation__arryUpDown" src="<?php echo esc_url($assets . '/shape/about-leaf.png'); ?>" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 content-column">
                    <div class="inner-column">
                        <div class="sec-title mb-40">
                            <span class="sub-title tz-sub-tilte tz-sub-anim tx-subTitle">
                                <?php echo esc_html(uk_mosque_home('about_subtitle')); ?>
                            </span>
                            <div class="h2 title tm-itm-title tm-itm-anim">
                                <?php uk_mosque_the_title_html(uk_mosque_home('about_title')); ?>
                            </div>
                            <p class="text mt-20 wow fadeInUp" data-wow-delay=".3s">
                                <?php echo esc_html(uk_mosque_home('about_text')); ?>
                            </p>
                        </div>
                        <div class="about-tab">
                            <!-- Tabs Nav -->
                            <ul class="nav nav-tabs" id="missionVisionTab" role="tablist">
                                <li class="nav-item wow fadeInUp" data-wow-delay=".3s" role="presentation">
                                    <button class="nav-link active" id="mission-tab" data-bs-toggle="tab"
                                        data-bs-target="#mission" type="button" role="tab">
                                        <?php echo esc_html(uk_mosque_home('about_tab1_label')); ?>
                                        <svg class="icon" width="16" height="9" viewBox="0 0 16 9" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M8 9C7.5 2 2.66667 0.833333 0 0H16C10 0 8.5 5.5 8 9Z" fill="#0C2F25" />
                                        </svg>
                                    </button>
                                </li>
                                <li class="nav-item wow fadeInUp" data-wow-delay=".5s" role="presentation">
                                    <button class="nav-link" id="vision-tab" data-bs-toggle="tab" data-bs-target="#vision"
                                        type="button" role="tab">
                                        <?php echo esc_html(uk_mosque_home('about_tab2_label')); ?>
                                        <svg class="icon" width="16" height="9" viewBox="0 0 16 9" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M8 9C7.5 2 2.66667 0.833333 0 0H16C10 0 8.5 5.5 8 9Z" fill="#0C2F25" />
                                        </svg>
                                    </button>
                                </li>
                            </ul>

                            <!-- Tabs Content -->
                            <div class="tab-content" id="missionVisionTabContent">
                                <div class="tab-pane fade show active" id="mission" role="tabpanel">
                                    <div class="about-block wow fadeInUp" data-wow-delay=".5s">
                                        <div class="inner-box"><?php echo esc_html(uk_mosque_home('about_tab1_text')); ?></div>
                                        <img src="<?php echo esc_url($assets . '/shape/about-border.png'); ?>" alt="">
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="vision" role="tabpanel">
                                    <div class="about-block">
                                        <div class="inner-box"><?php echo esc_html(uk_mosque_home('about_tab2_text')); ?></div>
                                        <img src="<?php echo esc_url($assets . '/shape/about-border.png'); ?>" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php if (uk_mosque_home('about_btn_text')) : ?>
                            <div class="text-center mt-30 wow fadeInUp" data-wow-delay=".7s">
                                <a class="theme-btn btn-style-one"
                                    href="<?php echo esc_url(uk_mosque_home('about_btn_url', home_url('/'))); ?>">
                                    <span class="btn-arrow-left"><i class="fal fa-arrow-right"></i></span>
                                    <span class="btn-title"><?php echo esc_html(uk_mosque_home('about_btn_text')); ?></span>
                                    <span class="btn-arrow-right"><i class="fal fa-arrow-right"></i></span>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- About Section -->
<?php endif; ?>


<?php if (uk_mosque_home_on('causes')) : ?>
    <!-- Causes Section -->
    <section class="our-causes pt-120">
        <div class="floating-img-1 bounce-y">
            <img src="<?php echo esc_url($assets . '/icon/obj-img-1.png'); ?>" alt="">
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mx-auto">
                    <div class="sec-title text-center mb-60">
                        <span class="sub-title tz-sub-tilte tz-sub-anim tx-subTitle">
                            <?php echo esc_html(uk_mosque_home('causes_subtitle')); ?>
                        </span>
                        <div class="h2 title tm-itm-title tm-itm-anim">
                            <?php uk_mosque_the_title_html(uk_mosque_home('causes_title')); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php
                $causes_orderby = uk_mosque_home('causes_orderby', 'date');

                $causes_query = new WP_Query(
                    array(
                        'post_type'           => 'donation',
                        'post_status'         => 'publish',
                        'posts_per_page'      => (int) uk_mosque_home('causes_count', 3),
                        'orderby'             => $causes_orderby,
                        'order'               => ('title' === $causes_orderby || 'menu_order' === $causes_orderby) ? 'ASC' : 'DESC',
                        'ignore_sticky_posts' => true,
                        'no_found_rows'       => true,
                    )
                );

                if ($causes_query->have_posts()) :
                    while ($causes_query->have_posts()) :
                        $causes_query->the_post();
                        get_template_part('template-parts/donation/donation-card');
                    endwhile;
                    wp_reset_postdata();
                else :
                ?>
                    <div class="col-12 text-center">
                        <p><?php esc_html_e('No causes have been added yet.', 'uk-mosque'); ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <!-- Causes Section -->
<?php endif; ?>


<?php if (uk_mosque_home_on('prayer')) : ?>
    <!-- Time Section -->
    <section class="time-section">
        <div class="floating-img-1 bounce-y">
            <img src="<?php echo esc_url($assets . '/icon/obj-img-2.png'); ?>" alt="">
        </div>
        <div class="container">
            <div class="sec-title text-center mb-60">
                <span class="sub-title tz-sub-tilte tz-sub-anim tx-subTitle">
                    <?php echo esc_html(uk_mosque_home('prayer_subtitle')); ?>
                </span>
                <div class="h2 title tm-itm-title tm-itm-anim">
                    <?php uk_mosque_the_title_html(uk_mosque_home('prayer_title')); ?>
                </div>
                <p class="text"><?php echo esc_html(uk_mosque_home('prayer_text')); ?></p>
            </div>
        </div>
        <div class="outer-box">
            <div class="row justify-content-center">
                <?php get_template_part('template-parts/global/prayer-times'); ?>
            </div>
        </div>
        <div class="sec-bg">
            <img src="<?php echo esc_url($assets . '/shape/time-bg.png'); ?>" alt="">
        </div>
    </section>
    <!-- Time Section -->
<?php endif; ?>


<?php if (uk_mosque_home_on('services')) : ?>
    <!-- Service Section -->
    <section class="service-section">
        <div class="outer-container">
            <div class="container">
                <div class="sec-title-flex mb-50">
                    <div class="row g-4 align-items-end justify-content-between">
                        <div class="col-lg-6">
                            <div class="sec-title">
                                <span class="sub-title tz-sub-tilte tz-sub-anim tx-subTitle">
                                    <?php echo esc_html(uk_mosque_home('services_subtitle')); ?>
                                </span>
                                <div class="h2 title tm-itm-title tm-itm-anim">
                                    <?php uk_mosque_the_title_html(uk_mosque_home('services_title')); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <p class="text"><?php echo esc_html(uk_mosque_home('services_side_text')); ?></p>
                        </div>
                    </div>
                </div>
                <div class="row  advance-wrap">
                    <?php
                    $services_query = new WP_Query(
                        array(
                            'post_type'      => 'service',
                            'post_status'    => 'publish',
                            'posts_per_page' => (int) uk_mosque_home('services_count', 4),
                            'orderby'        => 'menu_order date',
                            'order'          => 'ASC',
                            'no_found_rows'  => true,
                        )
                    );

                    if ($services_query->have_posts()) :
                        while ($services_query->have_posts()) :
                            $services_query->the_post();
                            get_template_part('template-parts/service/service-card');
                        endwhile;
                        wp_reset_postdata();
                    else :
                    ?>
                        <div class="col-12 text-center">
                            <p><?php esc_html_e('No services have been added yet.', 'uk-mosque'); ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="sec-shape1">
                <img src="<?php echo esc_url($assets . '/shape/service-shape.png'); ?>" alt="">
            </div>
            <div class="sec-shape2">
                <img src="<?php echo esc_url($assets . '/shape/service-shape2.png'); ?>" alt="">
            </div>
        </div>
    </section>
    <!-- Service Section -->
<?php endif; ?>


<?php if (uk_mosque_home_on('events')) : ?>
    <!-- Event Section -->
    <section class="event-section pt-120 pb-80">
        <div class="floating-img-1 bounce-y">
            <img src="<?php echo esc_url($assets . '/icon/obj-img-3.png'); ?>" alt="">
        </div>
        <div class="floating-img-2 bounce-y">
            <img src="<?php echo esc_url($assets . '/icon/obj-img-4.png'); ?>" alt="">
        </div>
        <div class="container">
            <div class="sec-title text-center mb-60">
                <span class="sub-title tz-sub-tilte tz-sub-anim tx-subTitle">
                    <?php echo esc_html(uk_mosque_home('events_subtitle')); ?>
                </span>
                <div class="h2 title tm-itm-title tm-itm-anim">
                    <?php uk_mosque_the_title_html(uk_mosque_home('events_title')); ?>
                </div>
                <p class="text"><?php echo esc_html(uk_mosque_home('events_text')); ?></p>
            </div>
            <div class="event-wrapper oit-panel-pin-area">
                <?php
                $events_query = uk_mosque_upcoming_events((int) uk_mosque_home('events_count', 3));

                if ($events_query->have_posts()) :
                    while ($events_query->have_posts()) :
                        $events_query->the_post();
                        get_template_part(
                            'template-parts/event/event-card',
                            null,
                            array(
                                'btn_text' => uk_mosque_home('events_btn_text'),
                                'btn_url'  => uk_mosque_home('events_btn_url'),
                            )
                        );
                    endwhile;
                    wp_reset_postdata();
                else :
                ?>
                    <p class="text-center"><?php esc_html_e('No upcoming events at the moment.', 'uk-mosque'); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <!-- Event Section -->
<?php endif; ?>


<?php
if (uk_mosque_home_on('marquee')) :
    $marquee_items  = array_filter(array_map('trim', explode("\n", (string) uk_mosque_home('marquee_items'))));
    $marquee_repeat = max(1, (int) uk_mosque_home('marquee_repeat', 6));

    if ($marquee_items) :
?>
        <!-- Marquee Section -->
        <section class="marquee-section">
            <div class="marquee anim-fade-move">
                <?php for ($group = 0; $group < $marquee_repeat; $group++) : ?>
                    <div class="marquee-group">
                        <?php foreach ($marquee_items as $marquee_item) : ?>
                            <div class="text"><?php echo esc_html($marquee_item); ?></div>
                        <?php endforeach; ?>
                    </div>
                <?php endfor; ?>
            </div>
        </section>
        <!-- End Marquee Section -->
<?php
    endif;
endif;
?>


<?php if (uk_mosque_home_on('team')) : ?>
    <!-- Team area start here -->
    <section class="team-section pt-120 pb-120">
        <div class="floating-img-1 bounce-y">
            <img src="<?php echo esc_url($assets . '/icon/obj-img-5.png'); ?>" alt="">
        </div>
        <div class="container">
            <div class="sec-title text-center mb-50 wow fadeInUp" data-wow-delay="00ms" data-wow-duration="1500ms">
                <div class="h6 sub-title tz-sub-tilte tz-sub-anim tx-subTitle">
                    <?php echo esc_html(uk_mosque_home('team_subtitle')); ?>
                </div>
                <div class="h2 title tm-itm-title tm-itm-anim">
                    <?php uk_mosque_the_title_html(uk_mosque_home('team_title')); ?>
                </div>
            </div>
            <div class="row g-4 advance-wrap">
                <?php
                $team_query = new WP_Query(
                    array(
                        'post_type'      => 'team_member',
                        'post_status'    => 'publish',
                        'posts_per_page' => (int) uk_mosque_home('team_count', 4),
                        'orderby'        => 'menu_order date',
                        'order'          => 'ASC',
                        'no_found_rows'  => true,
                    )
                );

                if ($team_query->have_posts()) :
                    while ($team_query->have_posts()) :
                        $team_query->the_post();
                        get_template_part('template-parts/team/team-card');
                    endwhile;
                    wp_reset_postdata();
                else :
                ?>
                    <div class="col-12 text-center">
                        <p><?php esc_html_e('No team members have been added yet.', 'uk-mosque'); ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <!-- Team area end here -->
<?php endif; ?>


<?php if (uk_mosque_home_on('donate')) : ?>
    <?php get_template_part('template-parts/donation/donation-form'); ?>
<?php endif; ?>


<?php if (uk_mosque_home_on('faq')) : ?>
    <!-- Faq area start here -->
    <section class="faqs-section-home1 pt-120 pb-120">
        <div class="floating-img-1 bounce-y">
            <img src="<?php echo esc_url($assets . '/icon/obj-img-6.png'); ?>" alt="">
        </div>
        <div class="container">
            <div class="sec-title text-center mb-50 wow fadeInUp" data-wow-delay="00ms" data-wow-duration="1500ms">
                <div class="h6 sub-title tz-sub-tilte tz-sub-anim tx-subTitle">
                    <?php echo esc_html(uk_mosque_home('faq_subtitle')); ?>
                </div>
                <div class="h2 title tm-itm-title tm-itm-anim">
                    <?php uk_mosque_the_title_html(uk_mosque_home('faq_title')); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-10 mx-lg-auto">
                    <div class="faq-content-1">
                        <?php
                        $faq_query = new WP_Query(
                            array(
                                'post_type'      => 'faq',
                                'post_status'    => 'publish',
                                'posts_per_page' => (int) uk_mosque_home('faq_count', 6),
                                'orderby'        => 'menu_order date',
                                'order'          => 'ASC',
                                'no_found_rows'  => true,
                            )
                        );

                        if ($faq_query->have_posts()) :
                            $faq_number = 0;
                        ?>
                            <ul class="accordion-box3">
                                <?php
                                while ($faq_query->have_posts()) :
                                    $faq_query->the_post();
                                    $faq_number++;
                                    get_template_part(
                                        'template-parts/faq/faq-item',
                                        null,
                                        array('number' => $faq_number)
                                    );
                                endwhile;
                                ?>
                            </ul>
                        <?php
                            wp_reset_postdata();
                        else :
                        ?>
                            <p class="text-center"><?php esc_html_e('No questions have been added yet.', 'uk-mosque'); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Faq area end here -->
<?php endif; ?>


<?php if (uk_mosque_home_on('testi')) : ?>
    <!-- Testimonial Section Start -->
    <section class="testimonial-section-two">
        <div class="outer-box">
            <div class="sec-title text-center">
                <div class="h6 sub-title tz-sub-tilte tz-sub-anim tx-subTitle">
                    <?php echo esc_html(uk_mosque_home('testi_subtitle')); ?>
                </div>
                <div class="h2 title tm-itm-title tm-itm-anim">
                    <?php uk_mosque_the_title_html(uk_mosque_home('testi_title')); ?>
                </div>
            </div>
            <?php
            $testi_query = new WP_Query(
                array(
                    'post_type'      => 'testimonial',
                    'post_status'    => 'publish',
                    'posts_per_page' => (int) uk_mosque_home('testi_count', 6),
                    'orderby'        => 'menu_order date',
                    'order'          => 'ASC',
                    'no_found_rows'  => true,
                )
            );

            if ($testi_query->have_posts()) :
            ?>
                <div class="swiper-container">
                    <div class="swiper testi-swiper-two pb-0">
                        <div class="swiper-wrapper">
                            <?php
                            while ($testi_query->have_posts()) :
                                $testi_query->the_post();
                                get_template_part('template-parts/testimonial/testimonial-card');
                            endwhile;
                            ?>
                        </div>
                        <div class="custom-slider-pagination">
                            <div class="slide-current">01</div>
                            <div class="swiper-scrollbar"></div>
                            <div class="slide-total">
                                <?php echo esc_html(str_pad($testi_query->post_count, 2, '0', STR_PAD_LEFT)); ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
                wp_reset_postdata();
            else :
            ?>
                <p class="text-center"><?php esc_html_e('No testimonials have been added yet.', 'uk-mosque'); ?></p>
            <?php endif; ?>
        </div>
    </section>
    <!-- Section end -->
<?php endif; ?>


<?php if (uk_mosque_home_on('blog')) : ?>
    <!-- Blog Section -->
    <section class="blog-section pt-120 pb-110">
        <div class="floating-img-1 bounce-y">
            <img src="<?php echo esc_url($assets . '/icon/obj-img-7.png'); ?>" alt="">
        </div>
        <div class="container">
            <div class="sec-title text-center mb-60">
                <span class="sub-title tz-sub-tilte tz-sub-anim tx-subTitle">
                    <?php echo esc_html(uk_mosque_home('blog_subtitle')); ?>
                </span>
                <div class="h2 title tm-itm-title tm-itm-anim">
                    <?php uk_mosque_the_title_html(uk_mosque_home('blog_title')); ?>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-lg-12">
                    <?php
                    $blog_query = new WP_Query(
                        array(
                            'post_type'           => 'post',
                            'post_status'         => 'publish',
                            'posts_per_page'      => (int) uk_mosque_home('blog_count', 4),
                            'ignore_sticky_posts' => true,
                            'no_found_rows'       => true,
                        )
                    );

                    if ($blog_query->have_posts()) :
                    ?>
                        <div class="swiper three-grid-slider blog-slider">
                            <div class="swiper-wrapper pb-150">
                                <?php
                                while ($blog_query->have_posts()) :
                                    $blog_query->the_post();
                                ?>
                                    <div class="swiper-slide">
                                        <?php get_template_part('template-parts/post/post-card'); ?>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                            <div class="swiper-pagination"></div>
                        </div>
                    <?php
                        wp_reset_postdata();
                    else :
                    ?>
                        <p class="text-center"><?php esc_html_e('No posts have been published yet.', 'uk-mosque'); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
    <!-- Blog Section -->
<?php endif; ?>


<?php
if (uk_mosque_home_on('contactsec')) :
    $mosque_phone   = get_theme_mod('mosque_phone');
    $mosque_email   = get_theme_mod('mosque_email');
    $mosque_address = get_theme_mod('mosque_address');
    $mosque_website = uk_mosque_home('contactsec_website');
?>
    <!-- Contact Section -->
    <section class="contact-section pb-120">
        <div class="outer-container">
            <div class="container">
                <div class="row g-0">
                    <div class="col-lg-5 content-column wow fadeInUp" data-wow-delay=".3s">
                        <div class="inner-column">
                            <div class="sec-title mb-40">
                                <span class="sub-title tz-sub-tilte tz-sub-anim tx-subTitle">
                                    <?php echo esc_html(uk_mosque_home('contactsec_subtitle')); ?>
                                </span>
                                <div class="h2 title tm-itm-title tm-itm-anim">
                                    <?php uk_mosque_the_title_html(uk_mosque_home('contactsec_title')); ?>
                                </div>
                            </div>
                            <div class="map-image">
                                <?php uk_mosque_option_image(uk_mosque_home('contactsec_map_image'), 'contact/contact-map.jpg', 'large'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7 wow fadeInUp" data-wow-delay=".5s">
                        <div class="contact-form">
                            <?php
                            /**
                             * TODO: point this at the uk_mosque_contact handler once
                             * inc/form-handlers.php exists. See development.md Step 11a.
                             */
                            ?>
                            <form>
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <input type="text" class="form-control"
                                            placeholder="<?php esc_attr_e('Your Name', 'uk-mosque'); ?>" name="name">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="email" class="form-control"
                                            placeholder="<?php esc_attr_e('Your Email', 'uk-mosque'); ?>" name="email">
                                    </div>
                                    <div class="col-12">
                                        <input type="text" class="form-control"
                                            placeholder="<?php esc_attr_e('Subject', 'uk-mosque'); ?>" name="subject">
                                    </div>
                                    <div class="col-12">
                                        <textarea placeholder="<?php esc_attr_e('Write a Message', 'uk-mosque'); ?>" name="message"></textarea>
                                    </div>
                                    <!-- Submit Button -->
                                    <div class="col-12">
                                        <button type="submit" class="theme-btn btn-style-four">
                                            <span class="btn-arrow-left"><i class="fa-light fa-arrow-up-right"></i></span>
                                            <span class="btn-title"><?php esc_html_e('Send Message', 'uk-mosque'); ?></span>
                                            <span class="btn-arrow-right"><i class="fa-light fa-arrow-up-right"></i></span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sec-bg">
                <?php uk_mosque_option_image(uk_mosque_home('contactsec_bg_image'), 'contact/contact-image.jpg', 'full'); ?>
            </div>
        </div>
        <div class="container">
            <div class="info-bar">
                <div class="inner-box">
                    <div class="row g-4">
                        <div class="col-lg-4 col-sm-6 wow fadeInUp" data-wow-delay=".3s">
                            <div class="contact-block">
                                <div class="inner-box">
                                    <i class="fa-solid fa-phone-volume"></i>
                                    <div>
                                        <?php if ($mosque_phone) : ?>
                                            <p class="text">
                                                <a href="<?php echo esc_url(uk_mosque_tel_href($mosque_phone)); ?>">
                                                    <?php echo esc_html($mosque_phone); ?>
                                                </a>
                                            </p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6 wow fadeInUp" data-wow-delay=".5s">
                            <div class="contact-block">
                                <div class="inner-box">
                                    <i class="fa-solid fa-globe"></i>
                                    <div>
                                        <?php if ($mosque_email) : ?>
                                            <p class="text">
                                                <a href="mailto:<?php echo esc_attr($mosque_email); ?>">
                                                    <?php echo esc_html($mosque_email); ?>
                                                </a>
                                            </p>
                                        <?php endif; ?>

                                        <?php if ($mosque_website) : ?>
                                            <p class="text"><?php echo esc_html($mosque_website); ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6 wow fadeInUp" data-wow-delay=".7s">
                            <div class="contact-block">
                                <div class="inner-box after-none">
                                    <i class="fa-solid fa-location-dot"></i>
                                    <div>
                                        <?php if ($mosque_address) : ?>
                                            <p class="text"><?php echo esc_html($mosque_address); ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Contact Section -->
<?php endif; ?>


<?php
get_footer();
