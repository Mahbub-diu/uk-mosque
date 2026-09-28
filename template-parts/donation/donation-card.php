<?php

/**
 * Donation (cause) grid card.
 *
 * Used by the homepage Causes section, archive-donation.php and
 * taxonomy-donation_category.php. Expects to run inside the Loop.
 *
 * @package uk-mosque
 */

defined('ABSPATH') || exit;

$goal_amount   = (float) get_post_meta(get_the_ID(), '_donation_goal_amount', true);
$raised_amount = (float) get_post_meta(get_the_ID(), '_donation_raised_amount', true);

$donation_terms = get_the_terms(get_the_ID(), 'donation_category');

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
                        <?php the_post_thumbnail('large', array('alt' => esc_attr(get_the_title()))); ?>
                        <?php the_post_thumbnail('large', array('alt' => esc_attr(get_the_title()))); ?>
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
                    <div class="text"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 18)); ?></div>
                <?php endif; ?>

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

                <a href="<?php echo esc_url(get_permalink()); ?>" class="btn-style-six">
                    <?php esc_html_e('Donate Now', 'uk-mosque'); ?>
                </a>
            </div>
        </div>
    </div>
</div>
