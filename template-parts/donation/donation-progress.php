<?php

/**
 * Donation progress bar + raised/goal figures.
 *
 * @param float $args['goal']
 * @param float $args['raised']
 * @param bool  $args['show_figures'] Default true.
 *
 * @package uk-mosque
 */

defined('ABSPATH') || exit;

$goal    = (float) ($args['goal'] ?? 0);
$raised  = (float) ($args['raised'] ?? 0);
$figures = $args['show_figures'] ?? true;

$progress = $goal > 0 ? min(100, round(($raised / $goal) * 100)) : 0;
?>

<div class="donation-bar">
    <div class="donation-progress">
        <div class="progress-track">
            <div class="progress-fill" style="width: <?php echo esc_attr($progress); ?>% !important;">
                <span class="progress-thumb"></span>
            </div>
        </div>
    </div>
</div>

<?php if ($figures) : ?>
    <div class="donation-info">
        <div class="fund-raise">
            <div class="icon"><i class="fa-sharp fa-light fa-box-heart"></i></div>
            <div class="text">
                <?php esc_html_e('Raised:', 'uk-mosque'); ?>
                <span class="value"><?php echo esc_html(uk_mosque_money($raised)); ?></span>
            </div>
        </div>
        <div class="fund-goal">
            <div class="icon"><i class="fa-sharp fa-light fa-bullseye-arrow"></i></div>
            <div class="text">
                <?php esc_html_e('Goal:', 'uk-mosque'); ?>
                <span class="value"><?php echo esc_html(uk_mosque_money($goal)); ?></span>
            </div>
        </div>
    </div>
<?php endif; ?>
