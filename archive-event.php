<?php

/**
 * Event Archive Template
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
                <?php echo esc_html($page_title); ?>
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

            <?php

            $events_query = new WP_Query(
                array(
                    'post_type'      => 'event',
                    'post_status'    => 'publish',
                    'posts_per_page' => -1,

                    'meta_key'       => '_event_date',
                    'orderby'        => 'meta_value',
                    'order'          => 'ASC',

                    'meta_type'      => 'DATE',
                )
            );
            ?>

            <?php if ($events_query->have_posts()) : ?>

                <?php while ($events_query->have_posts()) : $events_query->the_post(); ?>

                    <?php
                    /**
                     * Event Meta Data
                     */
                    $event_date = get_post_meta(
                        get_the_ID(),
                        '_event_date',
                        true
                    );

                    $event_start = get_post_meta(
                        get_the_ID(),
                        '_event_start',
                        true
                    );

                    $event_end = get_post_meta(
                        get_the_ID(),
                        '_event_end',
                        true
                    );

                    $event_topic = get_post_meta(
                        get_the_ID(),
                        '_event_topic',
                        true
                    );


                    /**
                     * Event Date
                     */
                    $event_month = '';
                    $event_day   = '';

                    if ($event_date) {

                        $timestamp = strtotime($event_date);

                        $event_month = wp_date(
                            'M',
                            $timestamp
                        );

                        $event_day = wp_date(
                            'd',
                            $timestamp
                        );
                    }
                    ?>

                    <div class="event-block">
                        <div class="inner-box">

                            <!-- Image -->
                            <div class="image-box">
                                <figure class="image">

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


                                    <!-- Date -->
                                    <?php if ($event_date) : ?>

                                        <div class="h4 tag">

                                            <?php
                                            echo esc_html(
                                                $event_month
                                            );
                                            ?>

                                            <span>
                                                <?php
                                                echo esc_html(
                                                    $event_day
                                                );
                                                ?>
                                            </span>

                                        </div>

                                    <?php endif; ?>

                                </figure>
                            </div>


                            <!-- Content -->
                            <div class="content-box">

                                <!-- Title -->
                                <div class="h3 title">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_title(); ?>
                                    </a>
                                </div>


                                <!-- Excerpt -->
                                <?php if (has_excerpt()) : ?>

                                    <p class="text">
                                        <?php the_excerpt(); ?>
                                    </p>

                                <?php endif; ?>


                                <div class="info">

                                    <div>


                                        <?php if ($event_topic) : ?>

                                            <div class="h4 info-title">

                                                <span>
                                                    <?php
                                                    esc_html_e(
                                                        'Topic:',
                                                        'uk-mosque'
                                                    );
                                                    ?>
                                                </span>

                                                <?php
                                                echo esc_html(
                                                    $event_topic
                                                );
                                                ?>

                                            </div>

                                        <?php endif; ?>


                                        <!-- Time -->
                                        <?php if ($event_start) : ?>

                                            <div class="h4 info-title">

                                                <span>
                                                    <?php
                                                    esc_html_e(
                                                        'Time:',
                                                        'uk-mosque'
                                                    );
                                                    ?>
                                                </span>

                                                <?php
                                                echo esc_html(
                                                    date_i18n(
                                                        get_option(
                                                            'time_format'
                                                        ),
                                                        strtotime(
                                                            $event_start
                                                        )
                                                    )
                                                );
                                                ?>


                                                <?php if ($event_end) : ?>

                                                    -

                                                    <?php
                                                    echo esc_html(
                                                        date_i18n(
                                                            get_option(
                                                                'time_format'
                                                            ),
                                                            strtotime(
                                                                $event_end
                                                            )
                                                        )
                                                    );
                                                    ?>

                                                <?php endif; ?>

                                            </div>

                                        <?php endif; ?>

                                    </div>


                                    <!-- Join Button -->
                                    <a class="theme-btn btn-style-three" href="<?php echo esc_url(get_permalink()); ?>">

                                        <span class="btn-arrow-left">
                                            <i class="fal fa-arrow-right"></i>
                                        </span>

                                        <span class="btn-title">
                                            <?php
                                            esc_html_e(
                                                'Join Now',
                                                'uk-mosque'
                                            );
                                            ?>
                                        </span>

                                        <span class="btn-arrow-right">
                                            <i class="fal fa-arrow-right"></i>
                                        </span>

                                    </a>

                                </div>

                            </div>

                        </div>
                    </div>

                <?php endwhile; ?>

            <?php else : ?>

                <h1>
                    <?php
                    esc_html_e(
                        'No events found!',
                        'uk-mosque'
                    );
                    ?>
                </h1>

            <?php endif; ?>


            <?php

            wp_reset_postdata();
            ?>

        </div>
    </div>
</section>
<!-- End Events Section -->



<?php

get_footer(); ?>