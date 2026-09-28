<?php

/**
 * Page title / breadcrumb banner.
 *
 * Always renders: Home → [intermediate crumbs] → current page (plain text).
 *
 * @param string $args['title']  Heading text, also the final breadcrumb.
 * @param array  $args['crumbs'] Intermediate crumbs only, as [ label => url ].
 *                               An empty url renders that crumb as plain text.
 *
 * @package uk-mosque
 */

defined('ABSPATH') || exit;

$title  = $args['title'] ?? get_the_title();
$crumbs = $args['crumbs'] ?? array();
?>

<!-- Start main-content -->
<section class="page-title">
    <div class="ripple-image ripples z-0">
        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/bg/page-title.jpg'); ?>" alt="">
    </div>
    <div class="auto-container">
        <div class="title-outer text-center">
            <div class="h1 title"><?php echo esc_html($title); ?></div>
            <ul class="page-breadcrumb">
                <li>
                    <a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Home', 'uk-mosque'); ?></a>
                </li>

                <?php foreach ($crumbs as $label => $url) : ?>
                    <li>
                        <?php if ($url) : ?>
                            <a href="<?php echo esc_url($url); ?>"><?php echo esc_html($label); ?></a>
                        <?php else : ?>
                            <?php echo esc_html($label); ?>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>

                <li><?php echo esc_html($title); ?></li>
            </ul>
        </div>
    </div>
</section>
<!-- end main-content -->
