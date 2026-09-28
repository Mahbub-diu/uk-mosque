<?php

/**
 * Service grid card.
 *
 * @param string $args['item_class'] Extra class on .service-block. The homepage grid
 *                                   is a GSAP "advance" row and needs 'advance-item';
 *                                   the About page grid is plain and passes ''.
 *
 * @package uk-mosque
 */

defined('ABSPATH') || exit;

$assets     = get_template_directory_uri() . '/assets/images';
$item_class = $args['item_class'] ?? 'advance-item';
?>

<div class="col-md-6 col-xl-3">
    <div class="service-block <?php echo esc_attr($item_class); ?>">
        <div class="inner-box">
            <div class="image-box">
                <figure class="image">
                    <?php if (has_post_thumbnail()) : ?>
                        <?php the_post_thumbnail('medium_large', array('alt' => esc_attr(get_the_title()))); ?>
                    <?php endif; ?>
                </figure>
                <img class="image-bg" src="<?php echo esc_url($assets . '/service/service-image-bg.png'); ?>" alt="">
                <img class="image-bg hover-bg" src="<?php echo esc_url($assets . '/service/service-image-bg-hover.png'); ?>" alt="">
            </div>
            <div class="content">
                <div class="h4 title"><?php the_title(); ?></div>

                <?php if (has_excerpt()) : ?>
                    <p class="text"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 16)); ?></p>
                <?php endif; ?>

                <a href="<?php the_permalink(); ?>" class="btn-more">
                    <i class="fa-light fa-arrow-up-right"></i>
                    <span class="screen-reader-text">
                        <?php
                        /* translators: %s: service name */
                        printf(esc_html__('Read more about %s', 'uk-mosque'), esc_html(get_the_title()));
                        ?>
                    </span>
                </a>
            </div>
            <div class="item-shape">
                <img src="<?php echo esc_url($assets . '/shape/service-item-shape.png'); ?>" alt="">
            </div>
        </div>
    </div>
</div>
