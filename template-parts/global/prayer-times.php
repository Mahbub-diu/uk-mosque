<?php

/**
 * Prayer timetable blocks.
 *
 * Renders the six .time-block columns only — the caller supplies the wrapping row,
 * so this partial serves the homepage, the About page and the Prayer Times page.
 *
 * @package uk-mosque
 */

defined('ABSPATH') || exit;

$index = 0;

foreach (uk_mosque_prayer_list() as $key => $label) :

    $azan   = uk_mosque_opt('prayer', 'prayer_' . $key . '_azan');
    $iqamah = uk_mosque_opt('prayer', 'prayer_' . $key . '_iqamah');

    $is_jummah = ('jummah' === $key);
    $column    = $is_jummah ? 'col-lg-5 col-md-6' : 'col-lg-4 col-md-6';

    $index++;
?>
    <div class="<?php echo esc_attr($column); ?> wow fadeInUp"
        data-wow-delay="<?php echo esc_attr(uk_mosque_wow_delay($index - 1)); ?>">
        <div class="time-block<?php echo $is_jummah ? ' mx-lg-auto' : ''; ?>">
            <div class="icon">
                <?php echo uk_mosque_prayer_icon($key); ?>
                <div class="h5 title"><?php echo esc_html($label); ?></div>
            </div>
            <div class="content">
                <div class="h6 title">
                    <span><?php esc_html_e('Time', 'uk-mosque'); ?></span> <?php esc_html_e('Iqamah', 'uk-mosque'); ?>
                </div>
                <div class="h6 title">
                    <span><?php echo esc_html($azan); ?> </span> <?php echo esc_html($iqamah); ?>
                </div>
            </div>
        </div>
    </div>
<?php
endforeach;
