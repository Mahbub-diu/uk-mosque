<?php

/**
 * Template Name: About Page
 *
 * Driven by Theme Options → About Page. Repeating content (services, FAQs) comes
 * from the CPTs; prayer times come from Theme Options → Prayer Times.
 *
 * @package uk-mosque
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

$assets = get_template_directory_uri() . '/assets/images';

uk_mosque_page_banner(get_the_title());
?>


<?php if (uk_mosque_about_on('intro')) : ?>
    <!-- About Section -->
    <section class="about-section-three pt-120 pb-120">
        <div class="container">
            <div class="row g-4">
                <div class="col-xl-6 col-lg-10 image-column">
                    <div class="inner-column">
                        <div class="image-box">
                            <figure class="image overlay-anim">
                                <?php uk_mosque_option_image(uk_mosque_about('intro_image1'), 'about/about-three-image.jpg', 'large'); ?>
                            </figure>
                            <div class="image-bg">
                                <img src="<?php echo esc_url($assets . '/mask/about-image3-mask.png'); ?>" alt="">
                            </div>
                        </div>
                        <div class="image-box image-box-three">
                            <figure class="image overlay-anim">
                                <?php uk_mosque_option_image(uk_mosque_about('intro_image2'), 'about/about-three-2.jpg', 'large'); ?>
                            </figure>
                            <div class="image-bg">
                                <img src="<?php echo esc_url($assets . '/shape/about-image3-shape.png'); ?>" alt="">
                            </div>
                        </div>
                        <div class="shape">
                            <img class="animation__arryUpDown" src="<?php echo esc_url($assets . '/shape/about-leaf.png'); ?>" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-10">
                    <div class="sec-title mb-40">
                        <span class="sub-title"><?php echo esc_html(uk_mosque_about('intro_subtitle')); ?></span>
                        <div class="h2 title"><?php uk_mosque_the_title_html(uk_mosque_about('intro_title')); ?></div>
                    </div>

                    <div class="about-block-three mb-20">
                        <figure class="icon">
                            <?php uk_mosque_option_image(uk_mosque_about('mission_icon'), 'icon/about-three-icon1.png', 'full'); ?>
                        </figure>
                        <div class="content">
                            <div class="h5 title"><?php echo esc_html(uk_mosque_about('mission_title')); ?></div>
                            <div class="text"><?php echo esc_html(uk_mosque_about('mission_text')); ?></div>
                        </div>
                    </div>

                    <div class="about-block-three">
                        <figure class="icon">
                            <?php uk_mosque_option_image(uk_mosque_about('vision_icon'), 'icon/about-three-icon2.png', 'full'); ?>
                        </figure>
                        <div class="content">
                            <div class="h5 title"><?php echo esc_html(uk_mosque_about('vision_title')); ?></div>
                            <div class="text"><?php echo esc_html(uk_mosque_about('vision_text')); ?></div>
                        </div>
                    </div>

                    <div class="funfact-area">
                        <div class="counter-style-one">
                            <div class="count-box">
                                <span class="count-text" data-count-speed="3000"
                                    data-stop="<?php echo esc_attr(uk_mosque_about('counter_number')); ?>">0</span>
                                <span class="suffix"><?php echo esc_html(uk_mosque_about('counter_suffix')); ?></span>
                            </div>
                            <div class="counter-text denge-chars">
                                <?php echo esc_html(uk_mosque_about('counter_text')); ?>
                            </div>
                        </div>

                        <?php if (uk_mosque_about('intro_btn_text')) : ?>
                            <?php
                            $about_btn_url = uk_mosque_about('intro_btn_url');

                            if (!$about_btn_url) {
                                $about_btn_url = get_post_type_archive_link('donation') ?: home_url('/');
                            }
                            ?>
                            <a class="theme-btn btn-style-one" href="<?php echo esc_url($about_btn_url); ?>">
                                <span class="btn-arrow-left"><i class="fal fa-arrow-right"></i></span>
                                <span class="btn-title"><?php echo esc_html(uk_mosque_about('intro_btn_text')); ?></span>
                                <span class="btn-arrow-right"><i class="fal fa-arrow-right"></i></span>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- About Section -->
<?php endif; ?>


<?php if (uk_mosque_about_on('prayer')) : ?>
    <!-- Time Section Start -->
    <section class="time-section pb-100">
        <div class="container">
            <div class="sec-title text-center mb-60">
                <span class="sub-title"><?php echo esc_html(uk_mosque_about('prayer_subtitle')); ?></span>
                <div class="h2 title"><?php uk_mosque_the_title_html(uk_mosque_about('prayer_title')); ?></div>
                <p class="text"><?php echo esc_html(uk_mosque_about('prayer_text')); ?></p>
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
    <!-- Time Section End -->
<?php endif; ?>


<?php if (uk_mosque_about_on('services')) : ?>
    <!-- Service Section Start -->
    <section class="service-section">
        <div class="outer-container">
            <div class="container">
                <div class="sec-title-flex mb-50">
                    <div class="row g-4 align-items-end justify-content-between">
                        <div class="col-lg-6">
                            <div class="sec-title">
                                <span class="sub-title"><?php echo esc_html(uk_mosque_about('services_subtitle')); ?></span>
                                <div class="h2 title"><?php uk_mosque_the_title_html(uk_mosque_about('services_title')); ?></div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <p class="text"><?php echo esc_html(uk_mosque_about('services_side_text')); ?></p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <?php
                    $about_services = new WP_Query(
                        array(
                            'post_type'      => 'service',
                            'post_status'    => 'publish',
                            'posts_per_page' => (int) uk_mosque_about('services_count', 4),
                            'orderby'        => 'menu_order date',
                            'order'          => 'ASC',
                            'no_found_rows'  => true,
                        )
                    );

                    if ($about_services->have_posts()) :
                        while ($about_services->have_posts()) :
                            $about_services->the_post();
                            get_template_part(
                                'template-parts/service/service-card',
                                null,
                                array('item_class' => '')
                            );
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
    <!-- Service Section End -->
<?php endif; ?>


<?php if (uk_mosque_about_on('faq')) : ?>
    <!-- Faq Section Start -->
    <section class="faqs-section-home1 pt-120 pb-120">
        <div class="container">
            <div class="sec-title text-center mb-50 wow fadeInUp" data-wow-delay="00ms" data-wow-duration="1500ms">
                <div class="h6 sub-title"><?php echo esc_html(uk_mosque_about('faq_subtitle')); ?></div>
                <div class="h2 title wow splt-txt" data-splitting>
                    <?php uk_mosque_the_title_html(uk_mosque_about('faq_title')); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-10 mx-lg-auto">
                    <div class="faq-content-1">
                        <?php
                        $about_faqs = new WP_Query(
                            array(
                                'post_type'      => 'faq',
                                'post_status'    => 'publish',
                                'posts_per_page' => (int) uk_mosque_about('faq_count', 6),
                                'orderby'        => 'menu_order date',
                                'order'          => 'ASC',
                                'no_found_rows'  => true,
                            )
                        );

                        if ($about_faqs->have_posts()) :
                            $about_faq_number = 0;
                        ?>
                            <ul class="accordion-box3">
                                <?php
                                while ($about_faqs->have_posts()) :
                                    $about_faqs->the_post();
                                    $about_faq_number++;
                                    get_template_part(
                                        'template-parts/faq/faq-item',
                                        null,
                                        array('number' => $about_faq_number)
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
    <!-- Faq Section End -->
<?php endif; ?>


<?php
get_footer();
