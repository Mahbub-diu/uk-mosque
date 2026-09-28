<?php

/**
 * Template Name: Contact
 * Template Post Type: page
 *
 * Driven by Theme Options → Contact Page. The form itself is rendered by
 * Contact Form 7, so fields, recipient and messages are managed under
 * Contact → Contact Forms.
 *
 * @package uk-mosque
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

uk_mosque_page_banner(get_the_title());

$mosque_phone   = get_theme_mod('mosque_phone');
$mosque_email   = get_theme_mod('mosque_email');
$mosque_address = get_theme_mod('mosque_address');

$show_form = uk_mosque_contact_on('form');
$show_info = uk_mosque_contact_on('info');
?>

<?php if ($show_form || $show_info) : ?>
    <!--Contact Details Start-->
    <section class="contact-details pb-0 pt-110">
        <div class="container pt-0 pb-70">
            <div class="row">

                <?php if ($show_form) : ?>
                    <div class="<?php echo $show_info ? 'col-xl-7 col-lg-6' : 'col-12'; ?>">
                        <div class="sec-title black">
                            <div class="h2"><?php uk_mosque_the_title_html(uk_mosque_contact('form_title')); ?></div>
                        </div>

                        <?php
                        // Fields, recipient, validation and confirmation messages all
                        // live in Contact Form 7 — the theme only places the form.
                        echo uk_mosque_cf7_form(uk_mosque_contact('form_cf7_id'));
                        ?>
                    </div>
                <?php endif; ?>

                <?php if ($show_info) : ?>
                    <div class="<?php echo $show_form ? 'col-xl-5 col-lg-6' : 'col-12'; ?>">
                        <div class="contact-details__right">
                            <div class="sec-title black">
                                <div class="h2"><?php uk_mosque_the_title_html(uk_mosque_contact('info_title')); ?></div>
                                <div class="text"><?php echo esc_html(uk_mosque_contact('info_text')); ?></div>
                            </div>
                            <ul class="list-unstyled contact-details__info">

                                <?php if ($mosque_phone) : ?>
                                    <li>
                                        <div class="icon">
                                            <span class="fa-classic fa-light fa-phone-plus"></span>
                                        </div>
                                        <div class="text">
                                            <div class="h6 mb-1"><?php echo esc_html(uk_mosque_contact('info_phone_label')); ?></div>
                                            <a href="<?php echo esc_url(uk_mosque_tel_href($mosque_phone)); ?>">
                                                <?php if (uk_mosque_contact('info_phone_badge')) : ?>
                                                    <span><?php echo esc_html(uk_mosque_contact('info_phone_badge')); ?></span>
                                                <?php endif; ?>
                                                <?php echo esc_html($mosque_phone); ?>
                                            </a>
                                        </div>
                                    </li>
                                <?php endif; ?>

                                <?php if ($mosque_email) : ?>
                                    <li>
                                        <div class="icon">
                                            <span class="fal fa-envelope"></span>
                                        </div>
                                        <div class="text">
                                            <div class="h6 mb-1"><?php echo esc_html(uk_mosque_contact('info_email_label')); ?></div>
                                            <a href="mailto:<?php echo esc_attr($mosque_email); ?>">
                                                <?php echo esc_html($mosque_email); ?>
                                            </a>
                                        </div>
                                    </li>
                                <?php endif; ?>

                                <?php if ($mosque_address) : ?>
                                    <li>
                                        <div class="icon">
                                            <span class="fal fa-location-arrow"></span>
                                        </div>
                                        <div class="text">
                                            <div class="h6 mb-1"><?php echo esc_html(uk_mosque_contact('info_address_label')); ?></div>
                                            <span><?php echo esc_html($mosque_address); ?></span>
                                        </div>
                                    </li>
                                <?php endif; ?>

                            </ul>
                        </div>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </section>
    <!--Contact Details End-->
<?php endif; ?>


<?php
if (uk_mosque_contact_on('map')) :
    $map_url = uk_mosque_map_embed_url(
        uk_mosque_contact('map_query', $mosque_address),
        uk_mosque_contact('map_zoom', 14)
    );

    if ($map_url) :
?>
        <!-- Map Section-->
        <section class="map-section">
            <iframe class="map w-100" src="<?php echo esc_url($map_url); ?>" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
                title="<?php esc_attr_e('Location map', 'uk-mosque'); ?>"></iframe>
        </section>
        <!--End Map Section-->
<?php
    endif;
endif;
?>

<?php get_footer(); ?>
