<?php

/**
 * Donation section — intro column plus the amount-picker form.
 *
 * Shared by front-page.php and single-donation.php. The copy comes from
 * Theme Options → Home Page → Donate so both stay in step.
 *
 * @param string $args['cause']    Optional cause title, submitted with the form.
 * @param int    $args['cause_id'] Optional cause post ID, submitted with the form.
 *
 * @package uk-mosque
 */

defined('ABSPATH') || exit;

$assets   = get_template_directory_uri() . '/assets/images';
$cause    = $args['cause'] ?? '';
$cause_id = (int) ($args['cause_id'] ?? 0);

$amounts = array_filter(
    array_map('trim', explode(',', (string) uk_mosque_home('donate_amounts')))
);

$last_amount = $amounts ? end($amounts) : '';

$paypal_client_id = trim((string) uk_mosque_home('donate_paypal_client_id'));
$paypal_currency  = uk_mosque_home('donate_paypal_currency') ?: 'GBP';

if ($paypal_client_id) {
    wp_enqueue_script(
        'paypal-sdk',
        add_query_arg(
            array(
                'client-id' => rawurlencode($paypal_client_id),
                'currency'  => $paypal_currency,
            ),
            'https://www.paypal.com/sdk/js'
        ),
        array(),
        null,
        true
    );
    wp_enqueue_script(
        'uk-mosque-donation-paypal',
        get_template_directory_uri() . '/assets/js/donation-paypal.js',
        array('paypal-sdk'),
        wp_get_theme()->get('Version'),
        true
    );
}
?>

<!-- Donation Section -->
<section class="donation-section">
    <div class="outer-container">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-5 image-column">
                    <div class="inner-column">
                        <div class="sec-title mb-40">
                            <span class="sub-title tz-sub-tilte tz-sub-anim tx-subTitle bg-white">
                                <?php echo esc_html(uk_mosque_home('donate_subtitle')); ?>
                            </span>
                            <div class="h2 title tm-itm-title tm-itm-anim">
                                <?php uk_mosque_the_title_html(uk_mosque_home('donate_title')); ?>
                            </div>
                            <p class="text mt-20 wow fadeInUp" data-wow-delay=".3s">
                                <?php echo esc_html(uk_mosque_home('donate_text')); ?>
                            </p>
                        </div>
                        <figure class="image overlay-anim wow fadeInUp" data-wow-delay=".5s">
                            <?php uk_mosque_option_image(uk_mosque_home('donate_image'), 'donation/donation-image.jpg', 'large'); ?>
                        </figure>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="donation-form wow fadeInUp" data-wow-delay=".3s">
                        <div class="h3 title mb-30"><?php echo esc_html(uk_mosque_home('donate_form_title')); ?></div>

                        <?php if ($cause) : ?>
                        <p class="donation-cause">
                            <?php
                                printf(
                                    /* translators: %s: cause name. */
                                    esc_html__('Supporting: %s', 'uk-mosque'),
                                    '<strong>' . esc_html($cause) . '</strong>'
                                );
                                ?>
                        </p>
                        <?php endif; ?>

                        <?php
                        /**
                         * Payment runs through PayPal Smart Buttons (assets/js/donation-paypal.js),
                         * which read the amount from #donationAmount — a preset button or
                         * the Custom one. Without a Client ID the form has no handler.
                         */
                        ?>
                        <form id="donationForm" data-currency="<?php echo esc_attr($paypal_currency); ?>">

                            <?php if ($cause_id) : ?>
                            <input type="hidden" name="cause_id" value="<?php echo esc_attr($cause_id); ?>">
                            <input type="hidden" name="cause" value="<?php echo esc_attr($cause); ?>">
                            <?php endif; ?>

                            <div class="row g-4">
                                <div class="col-md-6">
                                    <input type="text" class="form-control"
                                        placeholder="<?php esc_attr_e('Enter Your Name', 'uk-mosque'); ?>" name="name">
                                </div>
                                <div class="col-md-6">
                                    <input type="email" class="form-control"
                                        placeholder="<?php esc_attr_e('Your Email', 'uk-mosque'); ?>" name="email">
                                </div>
                                <div class="col-12">
                                    <input type="text" class="form-control"
                                        placeholder="<?php esc_attr_e('Company Name (Optional)', 'uk-mosque'); ?>"
                                        name="company">
                                </div>
                                <!-- Donation Amount Input -->
                                <div class="col-12">
                                    <input type="text" id="donationAmount" class="form-control donation-input"
                                        placeholder="<?php echo esc_attr(uk_mosque_money(0)); ?>" readonly>
                                </div>
                                <!-- Donation Amount Buttons -->
                                <div class="col-12">
                                    <div class="donation-amounts mt-10">
                                        <?php foreach ($amounts as $amount) : ?>
                                        <button type="button"
                                            class="amount-btn<?php echo ($amount === $last_amount) ? ' active' : ''; ?>"
                                            data-amount="<?php echo esc_attr($amount); ?>">
                                            <?php echo esc_html(uk_mosque_money($amount)); ?>
                                        </button>
                                        <?php endforeach; ?>
                                        <button type="button" class="amount-btn custom-btn">
                                            <?php esc_html_e('Custom', 'uk-mosque'); ?>
                                        </button>
                                    </div>
                                </div>
                                <!-- Payment -->
                                <div class="col-12">
                                    <?php if ($paypal_client_id) : ?>
                                    <p class="donation-message mt-10" role="alert" hidden></p>
                                    <div id="paypal-button-container" class="mt-10"></div>
                                    <?php else : ?>
                                    <?php if (current_user_can('manage_options')) : ?>
                                    <p class="donation-message mt-10" style="color:#d63638">
                                        <?php esc_html_e('Admin only: add a PayPal Client ID in Theme Options → Home Page → Donation to show the PayPal buttons.', 'uk-mosque'); ?>
                                    </p>
                                    <?php endif; ?>
                                    <button type="submit" class="btn mt-10 btn-donate w-100">
                                        <?php esc_html_e('Submit Donation', 'uk-mosque'); ?>
                                    </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="sec-bg">
            <img src="<?php echo esc_url($assets . '/shape/donation-bg.png'); ?>" alt="">
        </div>
        <div class="sec-shape">
            <img src="<?php echo esc_url($assets . '/shape/donation-shape.png'); ?>" alt="">
        </div>
    </div>
    <div class="sec-hero">
        <img src="<?php echo esc_url($assets . '/donation/donation-hero.png'); ?>" alt="">
    </div>
</section>
<!-- Donation Section -->