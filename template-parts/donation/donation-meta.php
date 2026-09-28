<?php

/**
 * Donation meta list — category, campaign dates, days remaining.
 *
 * Expects to run inside the Loop.
 *
 * @package uk-mosque
 */

defined('ABSPATH') || exit;

$start = get_post_meta(get_the_ID(), '_donation_start_date', true);
$end   = get_post_meta(get_the_ID(), '_donation_end_date', true);
$terms = get_the_terms(get_the_ID(), 'donation_category');

$days_left = null;

if ($end) {
    $diff      = strtotime($end) - strtotime(current_time('Y-m-d'));
    $days_left = max(0, (int) floor($diff / DAY_IN_SECONDS));
}

$date_format = get_option('date_format');
?>

<ul class="donation-meta">

    <?php if (!empty($terms) && !is_wp_error($terms)) : ?>
        <li>
            <span class="label"><?php esc_html_e('Category:', 'uk-mosque'); ?></span>
            <?php foreach ($terms as $term) : ?>
                <a href="<?php echo esc_url(get_term_link($term)); ?>"><?php echo esc_html($term->name); ?></a>
            <?php endforeach; ?>
        </li>
    <?php endif; ?>

    <?php if ($start) : ?>
        <li>
            <span class="label"><?php esc_html_e('Started:', 'uk-mosque'); ?></span>
            <?php echo esc_html(wp_date($date_format, strtotime($start))); ?>
        </li>
    <?php endif; ?>

    <?php if ($end) : ?>
        <li>
            <span class="label"><?php esc_html_e('Ends:', 'uk-mosque'); ?></span>
            <?php echo esc_html(wp_date($date_format, strtotime($end))); ?>
        </li>
    <?php endif; ?>

    <?php if (null !== $days_left) : ?>
        <li>
            <span class="label"><?php esc_html_e('Days left:', 'uk-mosque'); ?></span>
            <?php echo esc_html(number_format_i18n($days_left)); ?>
        </li>
    <?php endif; ?>

</ul>
