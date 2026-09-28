<?php

/**
 * Blog / News Archive
 *
 * @package uk-mosque
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<?php
// get_the_title(0) falls back to the global post, which on the blog index is the
// first post in the loop — so only use the posts page when one is actually set.
$posts_page_id = (int) get_option('page_for_posts');
$blog_title    = $posts_page_id ? get_the_title($posts_page_id) : __('Blog', 'uk-mosque');

uk_mosque_page_banner($blog_title);
?>

<!-- Blog Section Start -->
<section class="blog-section pt-120 pb-70">
    <div class="auto-container">
        <div class="row">
            <div class="col-md-6 col-xl-4">
                <div class="blog-post mb-150">
                    <div class="inner-box">
                        <figure class="image-box">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/blog/blog-1-1.jpg"
                                alt="image">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/blog/blog-1-1.jpg"
                                alt="image">
                        </figure>
                        <div class="content-box">
                            <div class="post-meta">
                                <a href="news-details.html" class="tag">Madrasha</a>
                                <span class="date"><i class="fa-classic fa-light fa-calendar-days"></i> 21 May,
                                    2026</span>
                            </div>
                            <div class="h4 title"><a href="news-details.html">Renovation of Prayer Hall Completed —
                                    Alhamdulillah!</a></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-4">
                <div class="blog-post mb-150">
                    <div class="inner-box">
                        <figure class="image-box">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/blog/blog-1-2.jpg"
                                alt="image">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/blog/blog-1-2.jpg"
                                alt="image">
                        </figure>
                        <div class="content-box">
                            <div class="post-meta">
                                <a href="news-details.html" class="tag">Madrasha</a>
                                <span class="date"><i class="fa-classic fa-light fa-calendar-days"></i> 21 May,
                                    2026</span>
                            </div>
                            <div class="h4 title"><a href="news-details.html">Transformative Stories of Faith from
                                    Recent
                                    Pilgrims</a></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-4">
                <div class="blog-post mb-150">
                    <div class="inner-box">
                        <figure class="image-box">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/blog/blog-1-3.jpg"
                                alt="image">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/blog/blog-1-3.jpg"
                                alt="image">
                        </figure>
                        <div class="content-box">
                            <div class="post-meta">
                                <a href="news-details.html" class="tag">Madrasha</a>
                                <span class="date"><i class="fa-classic fa-light fa-calendar-days"></i> 21 May,
                                    2026</span>
                            </div>
                            <div class="h4 title"><a href="news-details.html">Eid Celebration Highlights: Joy, Faith,
                                    and
                                    Togetherness</a></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-4">
                <div class="blog-post mb-150">
                    <div class="inner-box">
                        <figure class="image-box">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/blog/blog-1-2.jpg"
                                alt="image">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/blog/blog-1-2.jpg"
                                alt="image">
                        </figure>
                        <div class="content-box">
                            <div class="post-meta">
                                <a href="news-details.html" class="tag">Madrasha</a>
                                <span class="date"><i class="fa-classic fa-light fa-calendar-days"></i> 21 May,
                                    2026</span>
                            </div>
                            <div class="h4 title"><a href="news-details.html">Transformative Stories of Faith from
                                    Recent
                                    Pilgrims</a></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-4">
                <div class="blog-post mb-150">
                    <div class="inner-box">
                        <figure class="image-box">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/blog/blog-1-3.jpg"
                                alt="image">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/blog/blog-1-3.jpg"
                                alt="image">
                        </figure>
                        <div class="content-box">
                            <div class="post-meta">
                                <a href="news-details.html" class="tag">Madrasha</a>
                                <span class="date"><i class="fa-classic fa-light fa-calendar-days"></i> 21 May,
                                    2026</span>
                            </div>
                            <div class="h4 title"><a href="news-details.html">Eid Celebration Highlights: Joy, Faith,
                                    and
                                    Togetherness</a></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-4">
                <div class="blog-post mb-150">
                    <div class="inner-box">
                        <figure class="image-box">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/blog/blog-1-1.jpg"
                                alt="image">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/blog/blog-1-1.jpg"
                                alt="image">
                        </figure>
                        <div class="content-box">
                            <div class="post-meta">
                                <a href="news-details.html" class="tag">Madrasha</a>
                                <span class="date"><i class="fa-classic fa-light fa-calendar-days"></i> 21 May,
                                    2026</span>
                            </div>
                            <div class="h4 title"><a href="news-details.html">Renovation of Prayer Hall Completed —
                                    Alhamdulillah!</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Blog Section end -->

<?php

get_footer();
