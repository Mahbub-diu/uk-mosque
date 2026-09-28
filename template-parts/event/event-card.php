<?php

/**
 * Event card (homepage pinned-panel style).
 *
 * @param string $args['btn_text'] Button label.
 * @param string $args['btn_url']  Button link; falls back to the event permalink.
 *
 * @package uk-mosque
 */

defined('ABSPATH') || exit;

$event_date  = get_post_meta(get_the_ID(), '_event_date', true);
$event_start = get_post_meta(get_the_ID(), '_event_start', true);
$event_end   = get_post_meta(get_the_ID(), '_event_end', true);
$event_topic = get_post_meta(get_the_ID(), '_event_topic', true);

$event_month = '';
$event_day   = '';

if ($event_date) {
    $timestamp   = strtotime($event_date);
    $event_month = wp_date('M', $timestamp);
    $event_day   = wp_date('d', $timestamp);
}

$event_time = trim($event_start . ($event_end ? ' - ' . $event_end : ''));

$btn_text = $args['btn_text'] ?? __('Join Now', 'uk-mosque');
$btn_url  = !empty($args['btn_url']) ? $args['btn_url'] : get_permalink();
?>

<div class="event-block oit-panel-pin">
    <div class="inner-box">
        <div class="image-box">
            <figure class="image">
                <?php if (has_post_thumbnail()) : ?>
                    <?php the_post_thumbnail('large', array('alt' => esc_attr(get_the_title()))); ?>
                    <?php the_post_thumbnail('large', array('alt' => esc_attr(get_the_title()))); ?>
                <?php endif; ?>

                <?php if ($event_month) : ?>
                    <div class="h4 tag">
                        <?php echo esc_html($event_month); ?> <span><?php echo esc_html($event_day); ?></span>
                    </div>
                <?php endif; ?>
            </figure>
        </div>
        <div class="content-box">
            <div class="h3 title">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </div>

            <?php if (has_excerpt()) : ?>
                <p class="text"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 40)); ?></p>
            <?php endif; ?>

            <div class="info">
                <div>
                    <?php if ($event_topic) : ?>
                        <div class="h4 info-title">
                            <span><?php esc_html_e('Topic:', 'uk-mosque'); ?></span> <?php echo esc_html($event_topic); ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($event_time) : ?>
                        <div class="h4 info-title">
                            <span><?php esc_html_e('Time:', 'uk-mosque'); ?></span> <?php echo esc_html($event_time); ?>
                        </div>
                    <?php endif; ?>
                </div>

                <?php if ($btn_text) : ?>
                    <a class="theme-btn btn-style-three" href="<?php echo esc_url($btn_url); ?>">
                        <span class="btn-arrow-left"><i class="fal fa-arrow-right"></i></span>
                        <span class="btn-title"><?php echo esc_html($btn_text); ?></span>
                        <span class="btn-arrow-right"><i class="fal fa-arrow-right"></i></span>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
