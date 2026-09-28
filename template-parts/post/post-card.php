<?php

/**
 * Blog post card.
 *
 * Used by the homepage Blog slider, home.php and index.php. The caller supplies
 * the column or slide wrapper.
 *
 * @package uk-mosque
 */

defined('ABSPATH') || exit;

$categories = get_the_category();
$category   = !empty($categories) ? $categories[0] : null;
?>

<div class="blog-post">
    <div class="inner-box">
        <figure class="image-box">
            <?php if (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail('medium_large', array('alt' => esc_attr(get_the_title()))); ?>
                <?php the_post_thumbnail('medium_large', array('alt' => esc_attr(get_the_title()))); ?>
            <?php endif; ?>
        </figure>
        <div class="content-box">
            <div class="post-meta">
                <?php if ($category) : ?>
                    <a href="<?php echo esc_url(get_category_link($category)); ?>" class="tag">
                        <?php echo esc_html($category->name); ?>
                    </a>
                <?php endif; ?>

                <span class="date">
                    <i class="fa-classic fa-light fa-calendar-days"></i>
                    <?php echo esc_html(get_the_date('j M, Y')); ?>
                </span>
            </div>
            <div class="h4 title">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </div>
        </div>
    </div>
</div>
