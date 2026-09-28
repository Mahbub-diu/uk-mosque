<?php

/**
 * Team member grid card.
 *
 * The role comes from the team_role taxonomy, the links from post meta.
 * The static demo showed a Pinterest icon; the metabox stores Instagram, so the
 * icon follows the data.
 *
 * @package uk-mosque
 */

defined('ABSPATH') || exit;

$roles = get_the_terms(get_the_ID(), 'team_role');
$role  = (!empty($roles) && !is_wp_error($roles)) ? $roles[0]->name : '';

$socials = array(
    'facebook-f' => get_post_meta(get_the_ID(), '_team_facebook', true),
    'x-twitter'  => get_post_meta(get_the_ID(), '_team_twitter', true),
    'instagram'  => get_post_meta(get_the_ID(), '_team_instagram', true),
);

$socials = array_filter($socials);
?>

<div class="col-md-6 col-xl-3">
    <div class="team-block-two advance-item">
        <div class="inner-box">
            <figure class="image">
                <?php if (has_post_thumbnail()) : ?>
                    <?php the_post_thumbnail('medium_large', array('alt' => esc_attr(get_the_title()))); ?>
                <?php endif; ?>
            </figure>
            <div class="content-box">
                <div class="title-box">
                    <div class="h5 title">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </div>

                    <?php if ($role) : ?>
                        <p class="sub-title"><?php echo esc_html($role); ?></p>
                    <?php endif; ?>
                </div>

                <?php if ($socials) : ?>
                    <div class="socials">
                        <div class="icon"><i class="fa-classic fa-solid fa-share"></i></div>
                        <ul>
                            <?php foreach ($socials as $icon => $url) : ?>
                                <li>
                                    <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener noreferrer">
                                        <i class="fa-brands fa-<?php echo esc_attr($icon); ?>"></i>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
