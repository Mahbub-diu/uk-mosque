<?php

/**
 * Theme Footer
 *
 * @package uk-mosque
 */

defined('ABSPATH') || exit;

$assets = get_template_directory_uri() . '/assets/images';

$social_links = uk_mosque_social_links();

$has_footer_menu = has_nav_menu('footer_menu');

$show_newsletter = (bool) get_theme_mod('mosque_footer_newsletter_enable', true);

$address = get_theme_mod('mosque_address');
$phone   = get_theme_mod('mosque_phone');
$email   = get_theme_mod('mosque_email');

$privacy_url = get_privacy_policy_url();

$copyright = uk_mosque_footer_copyright();
?>

<!-- Main Footer -->
<div class="pb-100">
    <footer class="footer-one footer-two">
        <div class="shape-img">
            <img src="<?php echo esc_url($assets . '/shape/footer2-shape1.png'); ?>" alt="">
        </div>
        <div class="container">
            <div class="inner-box">
                <div class="logo">
                    <a href="<?php echo esc_url(home_url('/')); ?>">
                        <?php
                        uk_mosque_option_image(
                            get_theme_mod('mosque_footer_logo'),
                            'logo-2.png',
                            'full',
                            array('alt' => get_bloginfo('name'))
                        );
                        ?>
                    </a>
                </div>

                <?php if ($social_links) : ?>
                    <ul class="social-list">
                        <?php foreach ($social_links as $link) : ?>
                            <li>
                                <a href="<?php echo esc_url($link['url']); ?>" target="_blank" rel="noopener noreferrer">
                                    <i class="<?php echo esc_attr($link['icon']); ?>"></i>
                                    <span class="screen-reader-text"><?php echo esc_html($link['label']); ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

            </div>
            <div class="row">

                <?php if ($show_newsletter) : ?>
                    <div class="col-xl-5 col-lg-4 col-md-8 wow fadeInUp" data-wow-delay=".3s">
                        <div class="footer-newslatter-widget">
                            <div class="newsletter-card">
                                <h2 class="card__title" id="cta-title">
                                    <?php echo esc_html(get_theme_mod('mosque_footer_newsletter_title', __('Join Our Community of Givers', 'uk-mosque'))); ?>
                                </h2>
                                <p class="card__desc">
                                    <?php echo esc_html(get_theme_mod('mosque_footer_newsletter_text', __('Receive the latest updates, success stories, and opportunities to make a difference.', 'uk-mosque'))); ?>
                                </p>

                                <?php
                                /**
                                 * TODO: newsletter handler.
                                 *
                                 * These inputs are not inside a <form> and post nowhere — the
                                 * markup is decorative. Wiring it up needs a list provider
                                 * (Mailchimp / MailPoet / CF7). Until then the whole widget can
                                 * be switched off in Customizer → Footer.
                                 */
                                ?>
                                <div class="email-row">
                                    <input type="email" placeholder="<?php esc_attr_e('Enter your email', 'uk-mosque'); ?>"
                                        aria-label="<?php esc_attr_e('Email address', 'uk-mosque'); ?>" />
                                    <button class="btn-submit" type="button"
                                        aria-label="<?php esc_attr_e('Subscribe', 'uk-mosque'); ?>">
                                        <!-- arrow right icon -->
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M5 12h14M13 6l6 6-6 6" />
                                        </svg>
                                    </button>
                                </div>

                                <?php if ($privacy_url) : ?>
                                    <div class="checkbox-row">
                                        <input type="checkbox" id="privacy" />
                                        <label for="privacy">
                                            <?php
                                            printf(
                                                /* translators: %s: link to the privacy policy. */
                                                esc_html__('I agree to the %s', 'uk-mosque'),
                                                '<a class="color1" href="' . esc_url($privacy_url) . '">'
                                                    . esc_html__('privacy policy.', 'uk-mosque')
                                                    . '</a>'
                                            );
                                            ?>
                                        </label>
                                    </div>
                                <?php endif; ?>

                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="<?php echo $show_newsletter ? 'col-xl-7 col-lg-8' : 'col-12'; ?> wow fadeInUp"
                    data-wow-delay=".5s">
                    <div class="two-widgets">
                        <div class="widget-bg-img">
                            <img src="<?php echo esc_url($assets . '/shape/footer2-sheap2.png'); ?>" alt="">
                        </div>

                        <?php if ($has_footer_menu) : ?>
                            <div class="footer-column">
                                <div class="footer-widget">
                                    <div class="h6 widget-title">
                                        <?php echo esc_html(get_theme_mod('mosque_footer_links_title', __('Quick Links', 'uk-mosque'))); ?>
                                    </div>
                                    <div class="widget-content">
                                        <?php
                                        wp_nav_menu(
                                            array(
                                                'theme_location' => 'footer_menu',
                                                'menu_class'     => 'user-links',
                                                'container'      => false,
                                                'depth'          => 1,
                                                'fallback_cb'    => false,
                                            )
                                        );
                                        ?>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if ($address || $phone || $email) : ?>
                            <div class="footer-column">
                                <div class="footer-widget">

                                    <?php if ($address) : ?>
                                        <div class="h6 widget-title">
                                            <?php esc_html_e('Address', 'uk-mosque'); ?>
                                        </div>

                                        <div class="widget-content">
                                            <div class="address-one">
                                                <div class="icon fa-sharp fa-solid fa-location-dot"></div>
                                                <div class="text">
                                                    <?php echo esc_html($address); ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($phone || $email) : ?>
                                        <div class="widget-content">
                                            <div class="h6 widget-title mb-20">
                                                <?php esc_html_e('Phone & Email', 'uk-mosque'); ?>
                                            </div>

                                            <div class="address-one">
                                                <div class="icon fa-sharp fa-solid fa-phone-volume"></div>
                                                <div class="text">

                                                    <?php if ($phone) : ?>
                                                        <a href="<?php echo esc_url(uk_mosque_tel_href($phone)); ?>">
                                                            <?php echo esc_html($phone); ?>
                                                        </a>
                                                    <?php endif; ?>

                                                    <?php if ($phone && $email) : ?>
                                                        <br>
                                                    <?php endif; ?>

                                                    <?php if ($email) : ?>
                                                        <a href="mailto:<?php echo esc_attr($email); ?>">
                                                            <?php echo esc_html($email); ?>
                                                        </a>
                                                    <?php endif; ?>

                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                </div>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>

        <?php if ($copyright) : ?>
            <div class="bottom-bar">
                <div class="container">
                    <p class="copyright-text">
                        <?php echo wp_kses($copyright, array('a' => array('href' => array()), 'br' => array())); ?>
                    </p>
                </div>
            </div>
        <?php endif; ?>

    </footer>
</div>

</div>
</div>

</div>
<!-- End Page Wrapper -->

<?php wp_footer(); ?>
</body>

</html>