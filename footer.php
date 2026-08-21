<!-- Main Footer -->
<div class="pb-100">
    <footer class="footer-one footer-two">
        <div class="shape-img">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/shape/footer2-shape1.png" alt="">
        </div>
        <div class="container">
            <div class="inner-box">
                <div class="logo">
                    <a href="<?php echo esc_html(home_url('/')); ?>">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo-2.png" alt="Logo">
                    </a>
                </div>
                <ul class="social-list">
                    <li>
                        <a href="<?php echo esc_attr(get_theme_mod('mosque_facebook')); ?>">
                            <i class="fa-brands fa-facebook-f"></i>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo esc_attr(get_theme_mod('mosque_twitter')); ?>">
                            <i class="fa-brands fa-x-twitter"></i>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo esc_attr(get_theme_mod('mosque_instagram')); ?>">
                            <i class="icon fab fa-instagram"> </i>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo esc_attr(get_theme_mod('mosque_youtube')); ?>">
                            <i class="icon  fab fa-youtube"> </i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="row">
                <div class="col-xl-5 col-lg-4 col-md-8 wow fadeInUp" data-wow-delay=".3s">
                    <div class="footer-newslatter-widget">
                        <div class="newsletter-card">
                            <h2 class="card__title" id="cta-title">Join Our Community of Givers</h2>
                            <p class="card__desc">Receive the latest updates, success stories, and opportunities to make
                                a
                                difference.</p>
                            <div class="email-row">
                                <input type="email" placeholder="Enter your email" aria-label="Email address" />
                                <button class="btn-submit" type="button" aria-label="Subscribe">
                                    <!-- arrow right icon -->
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M5 12h14M13 6l6 6-6 6" />
                                    </svg>
                                </button>
                            </div>
                            <div class="checkbox-row">
                                <input type="checkbox" id="privacy" />
                                <label for="privacy">I agree to the <a class="color1" href="#">privacy
                                        policy.</a></label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-7 col-lg-8 wow fadeInUp" data-wow-delay=".5s">
                    <div class="two-widgets">
                        <div class="widget-bg-img">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/shape/footer2-sheap2.png"
                                alt="">
                        </div>
                        <div class="footer-column">
                            <div class="footer-widget">
                                <div class="h6 widget-title">Quick Links</div>
                                <div class="widget-content">
                                    <ul class="user-links">
                                        <li><a href="#">Home</a></li>
                                        <li><a href="#">About</a></li>
                                        <li><a href="#">Our Causes</a></li>
                                        <li><a href="#">Zakat Calculator</a></li>
                                        <li><a href="#">Contact Us </a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="footer-column">
                            <div class="footer-widget">

                                <div class="h6 widget-title">
                                    <?php esc_html_e('Address', 'uk-mosque'); ?>
                                </div>

                                <div class="widget-content">

                                    <!-- Address -->
                                    <div class="address-one">
                                        <div class="icon fa-sharp fa-solid fa-location-dot"></div>

                                        <div class="text">
                                            <?php echo esc_html(get_theme_mod('mosque_address')); ?>
                                        </div>
                                    </div>


                                    <!-- Phone & Email -->
                                    <div class="h6 widget-title mb-20">
                                        <?php esc_html_e('Phone & Email', 'uk-mosque'); ?>
                                    </div>

                                    <div class="address-one">
                                        <div class="icon fa-sharp fa-solid fa-phone-volume"></div>

                                        <div class="text">

                                            <?php
                                            $phone = get_theme_mod('mosque_phone');
                                            $email = get_theme_mod('mosque_email');
                                            ?>

                                            <?php if ($phone) : ?>
                                                <a href="tel:<?php echo esc_attr($phone); ?>">
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bottom-bar">
            <div class="container">
                <p class="copyright-text">© 2026 <a href="<?php echo esc_url(home_url('/')); ?>">Islamus</a>. All Rights
                    Reserved.</p>
            </div>
        </div>
    </footer>
</div>

</div>
</div>

</div>
<!-- End Page Wrapper -->

<?php wp_footer(); ?>
</body>

</html>