<?php

/**
 * Donations Archive Template
 *
 * @package uk-mosque
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

$page_title = post_type_archive_title('', false);

uk_mosque_page_banner($page_title);
?>

<!-- Causes Section -->
<section class="our-causes pt-120 pb-90">
    <div class="container">
        <div class="row">

            <?php if (have_posts()) : ?>

                <?php while (have_posts()) : the_post(); ?>
                    <?php get_template_part('template-parts/donation/donation-card'); ?>
                <?php endwhile; ?>

            <?php else : ?>

                <div class="col-12 text-center">
                    <p><?php esc_html_e('No causes have been added yet.', 'uk-mosque'); ?></p>
                </div>

            <?php endif; ?>

        </div>

        <?php
        the_posts_pagination(
            array(
                'mid_size'  => 1,
                'prev_text' => esc_html__('Previous', 'uk-mosque'),
                'next_text' => esc_html__('Next', 'uk-mosque'),
            )
        );
        ?>
    </div>
</section>
<!-- End Causes Section -->

<?php
get_footer();
