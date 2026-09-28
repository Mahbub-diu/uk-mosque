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

while (have_posts()) :
    the_post();

    /**
     * Donation Meta Data
     */
    $goal_amount   = (float) get_post_meta(get_the_ID(), '_donation_goal_amount', true);
    $raised_amount = (float) get_post_meta(get_the_ID(), '_donation_raised_amount', true);

    // post_type_archive_title() only returns a value on an archive, so read the
    // label off the post type object instead.
    $donation_obj   = get_post_type_object('donation');
    $donation_label = $donation_obj ? $donation_obj->labels->name : __('Causes', 'uk-mosque');

    // Sidebar nav: every cause category, with the current post's own marked.
    $sidebar_terms = get_terms(
        array(
            'taxonomy'   => 'donation_category',
            'hide_empty' => true,
        )
    );

    $current_terms = get_the_terms(get_the_ID(), 'donation_category');

    $current_term_ids = (!empty($current_terms) && !is_wp_error($current_terms))
        ? wp_list_pluck($current_terms, 'term_id')
        : array();

    $mosque_phone = get_theme_mod('mosque_phone');

    uk_mosque_page_banner(
        get_the_title(),
        array($donation_label => get_post_type_archive_link('donation'))
    );
?>

<!--Start Services Details-->
<section class="services-details pt-120 pb-60">
    <div class="container">
        <div class="row">
            <!--Start Services Details Sidebar-->
            <div class="col-xl-4 col-lg-4">
                <div class="service-sidebar">
                    <!--Start Services Details Sidebar Single-->
                    <div class="sidebar-widget service-sidebar-single">

                        <?php if (!empty($sidebar_terms) && !is_wp_error($sidebar_terms)) : ?>
                            <div class="sidebar-service-list">
                                <ul>
                                    <?php foreach ($sidebar_terms as $term) : ?>
                                        <li <?php echo in_array($term->term_id, $current_term_ids, true) ? 'class="current-menu-item"' : ''; ?>>
                                            <a href="<?php echo esc_url(get_term_link($term)); ?>">
                                                <i class="fas fa-angle-right"></i>
                                                <span><?php echo esc_html($term->name); ?></span>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <?php if ($mosque_phone) : ?>
                            <div class="service-details-help">
                                <div class="help-shape-1"></div>
                                <div class="help-shape-2"></div>
                                <div class="h2 help-title"><?php esc_html_e('Contact with us for any info', 'uk-mosque'); ?></div>
                                <div class="help-icon">
                                    <span class="lnr-icon-phone-handset"></span>
                                </div>
                                <div class="help-contact">
                                    <p><?php esc_html_e('Need help? Talk to an team', 'uk-mosque'); ?></p>
                                    <a href="<?php echo esc_url(uk_mosque_tel_href($mosque_phone)); ?>">
                                        <?php echo esc_html($mosque_phone); ?>
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>

                    </div>
                    <!--End Services Details Sidebar-->
                </div>
            </div>
            <!--Start Services Details Content-->
            <div class="col-xl-8 col-lg-8">
                <div class="services-details__content">

                    <?php if (has_post_thumbnail()) : ?>
                        <?php
                        the_post_thumbnail(
                            'large',
                            array(
                                'class' => 'w-100',
                                'alt'   => esc_attr(get_the_title()),
                            )
                        );
                        ?>
                    <?php endif; ?>

                    <div class="h3 mt-4"><?php the_title(); ?></div>

                    <?php if (has_excerpt()) : ?>
                        <p><?php echo esc_html(get_the_excerpt()); ?></p>
                    <?php endif; ?>

                    <div class="donation-progress-wrap mt-30 mb-30">
                        <?php
                        get_template_part(
                            'template-parts/donation/donation-progress',
                            null,
                            array(
                                'goal'   => $goal_amount,
                                'raised' => $raised_amount,
                            )
                        );
                        ?>
                    </div>

                    <?php get_template_part('template-parts/donation/donation-meta'); ?>

                    <div class="content mt-40">
                        <div class="text">
                            <?php the_content(); ?>
                        </div>
                    </div>

                </div>
            </div>
            <!--End Services Details Content-->
        </div>
    </div>
</section>
<!--End Services Details-->

<?php
get_template_part(
    'template-parts/donation/donation-form',
    null,
    array(
        'cause'    => get_the_title(),
        'cause_id' => get_the_ID(),
    )
);
?>

<?php
endwhile;

get_footer();
