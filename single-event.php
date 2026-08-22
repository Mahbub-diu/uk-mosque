<?php

/**
 * Single Event Template
 *
 * @package uk-mosque
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

while (have_posts()) :
    the_post();

    /**
     * Event Meta Data
     */
    $event_date     = get_post_meta(get_the_ID(), '_event_date', true);
    $event_location = get_post_meta(get_the_ID(), '_event_location', true);
    $event_topic    = get_post_meta(get_the_ID(), '_event_topic', true);
    $event_start    = get_post_meta(get_the_ID(), '_event_start', true);
    $event_end      = get_post_meta(get_the_ID(), '_event_end', true);

    $event_date_formatted = $event_date
        ? date_i18n(get_option('date_format'), strtotime($event_date))
        : '';

    $event_time_formatted = '';

    if ($event_start) {
        $event_time_formatted = date_i18n(get_option('time_format'), strtotime($event_start));

        if ($event_end) {
            $event_time_formatted .= ' - ' . date_i18n(get_option('time_format'), strtotime($event_end));
        }
    }

?>

<!-- Start main-content -->
<section class="page-title">
    <div class="ripple-image ripples z-0">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/bg/page-title.jpg" alt="">
    </div>
    <div class="auto-container">
        <div class="title-outer text-center">
            <div class="h1 title"><?php the_title(); ?></div>
            <ul class="page-breadcrumb">
                <li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
                <li><a href="<?php echo esc_url(get_post_type_archive_link('event')); ?>">Events</a></li>
                <li><?php the_title(); ?></li>
            </ul>
        </div>
    </div>
</section>
<!-- end main-content -->

<!--Project Details Start-->
<section class="project-details pt-120 pb-70">
    <div class="auto-container">
        <div class="row">
            <div class="col-xl-7 col-lg-8 mb-5 mb-lg-0">
                <div class="sec-title black mb-40">
                    <?php if ($event_topic) : ?>
                    <div class="sec-sub-title">
                        <div class="h6 sub-title tm-sub-tilte tm-sub-anim tx-subTitle">
                            <?php echo esc_html($event_topic); ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="h2 title tx-title sec_title tm-itm-title tm-itm-anim mb-20">
                        <?php the_title(); ?>
                    </div>

                    <?php if (has_excerpt()) : ?>
                    <p class="text wow fadeInUp" data-wow-delay="200ms" data-wow-duration="1500ms">
                        <?php echo esc_html(get_the_excerpt()); ?>
                    </p>
                    <?php endif; ?>
                </div>

                <a class="theme-btn btn-style-one" href="<?php echo esc_url(get_post_type_archive_link('event')); ?>">
                    <span class="btn-arrow-left"><i class="fal fa-arrow-right"></i></span>
                    <span class="btn-title"><?php esc_html_e('All Events', 'uk-mosque'); ?></span>
                    <span class="btn-arrow-right"><i class="fal fa-arrow-right"></i></span>
                </a>
            </div>

            <div class="col-xl-3 offset-xl-1 col-lg-4">
                <div class="project-details__content-right mt-0">
                    <div class="project-details__details-box rounded-0">
                        <ul class="list-unstyled project-details__details-list">

                            <?php if ($event_location) : ?>
                            <li>
                                <div class="h4 project-details__name mb-2"><?php esc_html_e('Location', 'uk-mosque'); ?></div>
                                <p class="project-details__client"><?php echo esc_html($event_location); ?></p>
                            </li>
                            <?php endif; ?>

                            <?php if ($event_topic) : ?>
                            <li>
                                <div class="h4 project-details__name mb-2"><?php esc_html_e('Event Topic', 'uk-mosque'); ?></div>
                                <p class="project-details__client"><?php echo esc_html($event_topic); ?></p>
                            </li>
                            <?php endif; ?>

                            <?php if ($event_date_formatted) : ?>
                            <li>
                                <div class="h4 project-details__name mb-2"><?php esc_html_e('Date', 'uk-mosque'); ?></div>
                                <p class="project-details__client"><?php echo esc_html($event_date_formatted); ?></p>
                            </li>
                            <?php endif; ?>

                            <?php if ($event_time_formatted) : ?>
                            <li>
                                <div class="h4 project-details__name mb-2"><?php esc_html_e('Time', 'uk-mosque'); ?></div>
                                <p class="project-details__client"><?php echo esc_html($event_time_formatted); ?></p>
                            </li>
                            <?php endif; ?>

                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <?php if (has_post_thumbnail()) : ?>
        <div class="row mb-5 mb-lg-0">
            <div class="col-lg-12">
                <div class="project-details__top mt-5">
                    <div class="project-details__img">
                        <?php
                        the_post_thumbnail(
                            'large',
                            array(
                                'class' => 'rounded-0',
                                'alt'   => esc_attr(get_the_title()),
                            )
                        );
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-lg-12">
                <div class="project-details__top mt-5 content">
                    <?php the_content(); ?>
                </div>
            </div>
        </div>

        <?php
        $prev_post_link = get_previous_post_link('%link', __('Previous Event', 'uk-mosque'));
        $next_post_link = get_next_post_link('%link', __('Next Event', 'uk-mosque'));

        if (get_previous_post() || get_next_post()) :
        ?>
        <hr class="mt-4 mb-5">
        <div class="row">
            <div class="col-xl-12">
                <div class="project-details__pagination-box">
                    <ul class="project-details__pagination list-unstyled d-flex justify-content-between">

                        <?php if (get_previous_post()) : ?>
                        <li class="next text-start">
                            <div class="content"><?php esc_html_e('Previous', 'uk-mosque'); ?></div>
                            <div class="h4 title"><?php previous_post_link('%link', '%title'); ?></div>
                        </li>
                        <?php endif; ?>

                        <?php if (get_next_post()) : ?>
                        <li class="previous text-end">
                            <div class="content"><?php esc_html_e('Next', 'uk-mosque'); ?></div>
                            <div class="h4 title"><?php next_post_link('%link', '%title'); ?></div>
                        </li>
                        <?php endif; ?>

                    </ul>
                </div>
            </div>
        </div>
        <?php endif; ?>

    </div>
</section>
<!--Project Details End-->

<?php
endwhile;

get_footer();
