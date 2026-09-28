<?php

/**
 * Testimonial slide.
 *
 * The .swiper-slide class is required by the Swiper init in assets/js/script.js.
 *
 * @package uk-mosque
 */

defined('ABSPATH') || exit;

$role   = get_post_meta(get_the_ID(), '_uk_mosque_testimonial_role', true);
$rating = (int) get_post_meta(get_the_ID(), '_uk_mosque_testimonial_rating', true);
$rating = max(0, min(5, $rating ?: 5));

$quote = get_the_content();
$quote = $quote ? $quote : get_the_excerpt();
?>

<div class="testimonial-block-two swiper-slide">
    <div class="inner-block">
        <div class="author-box">
            <?php if (has_post_thumbnail()) : ?>
                <div class="author-image">
                    <?php the_post_thumbnail('thumbnail', array('alt' => esc_attr(get_the_title()))); ?>
                </div>
            <?php endif; ?>

            <div class="author-info">
                <div class="h5 name"><?php the_title(); ?></div>

                <?php if ($role) : ?>
                    <div class="designation"><?php echo esc_html($role); ?></div>
                <?php endif; ?>
            </div>
            <div class="quote"><i class="fa fa-quote-right"></i></div>
        </div>
        <div class="content">
            <div class="rating-star">
                <?php for ($star = 1; $star <= 5; $star++) : ?>
                    <i class="fa-<?php echo ($star <= $rating) ? 'solid' : 'regular'; ?> fa-star"></i>
                <?php endfor; ?>
            </div>
            <div class="text"><?php echo esc_html(wp_strip_all_tags($quote)); ?></div>
        </div>
    </div>
</div>
