<?php

/**
 * About Page field definitions.
 *
 * Each field's `default` is the copy that used to be hardcoded in page-about.php,
 * so the page renders identically before anyone opens this screen.
 *
 * @package uk-mosque
 */

defined('ABSPATH') || exit;


function uk_mosque_about_sections()
{
    return array(

        /* ------------------------------------------------------- 1. Who We Are */
        'intro' => array(
            'title'       => __('1. Who We Are', 'uk-mosque'),
            'description' => __('The page heading and breadcrumb come from the WordPress page title.', 'uk-mosque'),
            'fields'      => array(
                'intro_enable'   => uk_mosque_section_toggle(),
                'intro_subtitle' => array(
                    'type'    => 'text',
                    'label'   => __('Sub title', 'uk-mosque'),
                    'default' => 'Who We Are',
                ),
                'intro_title' => array(
                    'type'    => 'richtext',
                    'label'   => __('Heading', 'uk-mosque'),
                    'default' => 'Guided by Faith, Driven by Compassion',
                ),
                'intro_image1' => array(
                    'type'  => 'image',
                    'label' => __('Image 1', 'uk-mosque'),
                    'help'  => __('Leave empty to use the bundled image.', 'uk-mosque'),
                ),
                'intro_image2' => array('type' => 'image', 'label' => __('Image 2', 'uk-mosque')),
            ),
        ),

        /* ------------------------------------------------- 2. Mission & Vision */
        'pillars' => array(
            'title'  => __('2. Mission & Vision', 'uk-mosque'),
            'fields' => array(
                'mission_title' => array(
                    'type'    => 'text',
                    'label'   => __('Mission heading', 'uk-mosque'),
                    'default' => 'Our Mission',
                ),
                'mission_text' => array(
                    'type'    => 'textarea',
                    'label'   => __('Mission text', 'uk-mosque'),
                    'rows'    => 3,
                    'default' => 'To uplift the needy and strengthen communities through Zakat, Sadaqah, and compassionate giving.',
                ),
                'mission_icon' => array(
                    'type'  => 'image',
                    'label' => __('Mission icon', 'uk-mosque'),
                ),
                'vision_title' => array(
                    'type'    => 'text',
                    'label'   => __('Vision heading', 'uk-mosque'),
                    'default' => 'Our Vision',
                ),
                'vision_text' => array(
                    'type'    => 'textarea',
                    'label'   => __('Vision text', 'uk-mosque'),
                    'rows'    => 3,
                    'default' => 'A world where every Muslim fulfills their duty of giving, and no one is left behind in poverty or despair.',
                ),
                'vision_icon' => array(
                    'type'  => 'image',
                    'label' => __('Vision icon', 'uk-mosque'),
                ),
            ),
        ),

        /* --------------------------------------------- 3. Counter & call to action */
        'counter' => array(
            'title'  => __('3. Counter & Button', 'uk-mosque'),
            'fields' => array(
                'counter_number' => array(
                    'type'    => 'number',
                    'label'   => __('Counter number', 'uk-mosque'),
                    'min'     => 0,
                    'max'     => 1000000,
                    'default' => 98,
                ),
                'counter_suffix' => array(
                    'type'    => 'text',
                    'label'   => __('Counter suffix', 'uk-mosque'),
                    'default' => '%',
                    'help'    => __('Shown straight after the number, e.g. % or +.', 'uk-mosque'),
                ),
                'counter_text' => array(
                    'type'    => 'text',
                    'label'   => __('Counter caption', 'uk-mosque'),
                    'default' => 'Of donations go directly to programs',
                ),
                'intro_btn_text' => array(
                    'type'    => 'text',
                    'label'   => __('Button text', 'uk-mosque'),
                    'default' => 'Give Zakat Now',
                    'help'    => __('Leave empty to hide the button.', 'uk-mosque'),
                ),
                'intro_btn_url' => array(
                    'type'  => 'url',
                    'label' => __('Button link', 'uk-mosque'),
                    'help'  => __('Leave empty to link to the Causes archive.', 'uk-mosque'),
                ),
            ),
        ),

        /* --------------------------------------------------- 4. Prayer Times */
        'prayer' => array(
            'title'       => __('4. Prayer Times', 'uk-mosque'),
            'description' => __('The times themselves live under Theme Options → Prayer Times.', 'uk-mosque'),
            'fields'      => array(
                'prayer_enable'   => uk_mosque_section_toggle(),
                'prayer_subtitle' => array(
                    'type'    => 'text',
                    'label'   => __('Sub title', 'uk-mosque'),
                    'default' => 'Time',
                ),
                'prayer_title' => array(
                    'type'    => 'richtext',
                    'label'   => __('Heading', 'uk-mosque'),
                    'default' => 'Prayer Times (Salah Timings)',
                ),
                'prayer_text' => array(
                    'type'    => 'textarea',
                    'label'   => __('Intro text', 'uk-mosque'),
                    'rows'    => 3,
                    'default' => 'Stay connected with your daily prayers. Our masjid doors are always open to worshippers.',
                ),
            ),
        ),

        /* ------------------------------------------------------- 5. Services */
        'services' => array(
            'title'       => __('5. Services', 'uk-mosque'),
            'description' => __('Content comes from Services.', 'uk-mosque'),
            'fields'      => array(
                'services_enable'   => uk_mosque_section_toggle(),
                'services_subtitle' => array(
                    'type'    => 'text',
                    'label'   => __('Sub title', 'uk-mosque'),
                    'default' => 'Service',
                ),
                'services_title' => array(
                    'type'    => 'richtext',
                    'label'   => __('Heading', 'uk-mosque'),
                    'default' => 'Our Programs & Services',
                ),
                'services_side_text' => array(
                    'type'    => 'textarea',
                    'label'   => __('Text beside the heading', 'uk-mosque'),
                    'rows'    => 3,
                    'default' => 'We offer a wide range of programs to strengthen faith, serve the community, and inspire the next generation.',
                ),
                'services_count' => uk_mosque_count_field(4),
            ),
        ),

        /* ------------------------------------------------------------ 6. FAQ */
        'faq' => array(
            'title'       => __('6. FAQ', 'uk-mosque'),
            'description' => __('Content comes from FAQs. Title = question, content = answer.', 'uk-mosque'),
            'fields'      => array(
                'faq_enable'   => uk_mosque_section_toggle(),
                'faq_subtitle' => array(
                    'type'    => 'text',
                    'label'   => __('Sub title', 'uk-mosque'),
                    'default' => 'FAQS',
                ),
                'faq_title' => array(
                    'type'    => 'richtext',
                    'label'   => __('Heading', 'uk-mosque'),
                    'default' => 'Have questions? Find your <br> answers here',
                ),
                'faq_count' => uk_mosque_count_field(6),
            ),
        ),

    );
}
