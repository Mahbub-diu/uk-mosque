<?php

/**
 * Donations Archive Template
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
            <div class="h1 title"> <?php echo esc_html($page_title); ?></div>
            <ul class="page-breadcrumb">
                <li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
                <li><?php echo esc_html($page_title); ?></li>
            </ul>
        </div>
    </div>
</section>
<!-- end main-content -->

<!-- Causes Section -->
<section class="our-causes pt-120 pb-90">
    <div class="container">
        <div class="row">

            <?php

            $donations_query = new WP_Query(
                array(
                    'post_type'      => 'donation',
                    'post_status'    => 'publish',
                    'posts_per_page' => -1,
                )
            );
            ?>

            <?php if ($donations_query->have_posts()) : ?>

            <?php while ($donations_query->have_posts()) : $donations_query->the_post(); ?>

            <?php

                    $goal_amount = (float) get_post_meta(
                        get_the_ID(),
                        '_donation_goal_amount',
                        true
                    );

                    $raised_amount = (float) get_post_meta(
                        get_the_ID(),
                        '_donation_raised_amount',
                        true
                    );

                    $progress = 0;

                    if ($goal_amount > 0) {

                        $progress = min(
                            100,
                            round(
                                ($raised_amount / $goal_amount) * 100
                            )
                        );
                    }

                    $donation_terms = get_the_terms(
                        get_the_ID(),
                        'donation_category'
                    );

                    $donation_category = (!empty($donation_terms) && !is_wp_error($donation_terms))
                        ? $donation_terms[0]->name
                        : '';
                    ?>

            <div class="col-xl-4 col-md-6">
                <div class="causes-block mb-30">
                    <div class="inner-block">
                        <div class="image-box">
                            <div class="image">

                                <?php if (has_post_thumbnail()) : ?>

                                <?php
                                            the_post_thumbnail(
                                                'large',
                                                array(
                                                    'alt' => esc_attr(
                                                        get_the_title()
                                                    ),
                                                )
                                            );
                                            ?>
                                <?php
                                            the_post_thumbnail(
                                                'large',
                                                array(
                                                    'alt' => esc_attr(
                                                        get_the_title()
                                                    ),
                                                )
                                            );
                                            ?>

                                <?php endif; ?>

                            </div>
                        </div>
                        <div class="content-box">

                            <?php if ($donation_category) : ?>
                            <div class="tag"><?php echo esc_html($donation_category); ?></div>
                            <?php endif; ?>

                            <div class="h4 title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </div>

                            <?php if (has_excerpt()) : ?>
                            <div class="text"><?php the_excerpt(); ?></div>
                            <?php endif; ?>

                            <div class="donation-bar">
                                <div class="donation-progress">
                                    <div class="progress-track">
                                        <div class="progress-fill"
                                            style="width: <?php echo esc_attr($progress); ?>% !important;">
                                            <span class="progress-thumb"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="donation-info">
                                <div class="fund-raise">
                                    <div class="icon"><i class="fa-sharp fa-light fa-box-heart"></i></div>
                                    <div class="text">
                                        <?php esc_html_e('Raised:', 'uk-mosque'); ?>
                                        <span class="value">
                                            <?php echo esc_html('$' . number_format_i18n($raised_amount)); ?>
                                        </span>
                                    </div>
                                </div>
                                <div class="fund-goal">
                                    <div class="icon"><i class="fa-sharp fa-light fa-bullseye-arrow"></i></div>
                                    <div class="text">
                                        <?php esc_html_e('Goal:', 'uk-mosque'); ?>
                                        <span class="value">
                                            <?php echo esc_html('$' . number_format_i18n($goal_amount)); ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <a href="<?php echo esc_url(get_permalink()); ?>" class="btn-style-six">
                                <?php esc_html_e('Donate Now', 'uk-mosque'); ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <?php endwhile; ?>

            <?php else : ?>

            <h1>
                <?php esc_html_e('No donations found!', 'uk-mosque'); ?>
            </h1>

            <?php endif; ?>

            <?php wp_reset_postdata(); ?>

        </div>
    </div>
</section>
<!-- End Causes Section -->

<?php get_footer(); ?>