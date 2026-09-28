<?php

/**
 * FAQ accordion item.
 *
 * @param int $args['number'] 1-based position, used for the 01/02/03 label and
 *                            to decide which item starts open.
 *
 * @package uk-mosque
 */

defined('ABSPATH') || exit;

$number = (int) ($args['number'] ?? 1);
$is_open = (1 === $number);
$delay   = ($number > 1) ? '.' . (($number - 1) * 2) . 's' : '';
?>

<li class="accordion block wow fadeInUp<?php echo $is_open ? ' active-block' : ''; ?>"
    <?php if ($delay) : ?>data-wow-delay="<?php echo esc_attr($delay); ?>" <?php endif; ?>>
    <div class="acc-btn<?php echo $is_open ? ' active' : ''; ?>">
        <span class="number"><?php echo esc_html(str_pad($number, 2, '0', STR_PAD_LEFT)); ?></span>
        <?php the_title(); ?>
        <i class="icon fas fa-plus"></i>
    </div>
    <div class="acc-content<?php echo $is_open ? ' current' : ''; ?>">
        <div class="content">
            <div class="text"><?php echo wp_kses_post(get_the_content()); ?></div>
        </div>
    </div>
</li>
