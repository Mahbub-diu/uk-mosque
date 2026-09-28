<?php

/**
 * Home Page field definitions.
 *
 * Each field's `default` is the copy that used to be hardcoded in front-page.php,
 * so the front page renders identically before anyone opens this screen.
 *
 * @package uk-mosque
 */

defined('ABSPATH') || exit;


/**
 * Reusable "Show this section" toggle.
 */
function uk_mosque_section_toggle()
{
    return array(
        'type'           => 'checkbox',
        'label'          => __('Section', 'uk-mosque'),
        'checkbox_label' => __('Show this section', 'uk-mosque'),
        'default'        => 1,
    );
}


/**
 * How many posts to pull into a section.
 */
function uk_mosque_count_field($default, $label = null)
{
    return array(
        'type'    => 'number',
        'label'   => $label ?: __('How many to show', 'uk-mosque'),
        'min'     => 1,
        'max'     => 12,
        'default' => $default,
    );
}


function uk_mosque_home_sections()
{
    return array(

        /* ------------------------------------------------------------ 1. Hero */
        'hero' => array(
            'title'  => __('1. Hero Banner', 'uk-mosque'),
            'fields' => array(
                'hero_enable'   => uk_mosque_section_toggle(),
                'hero_subtitle' => array(
                    'type'    => 'text',
                    'label'   => __('Sub title', 'uk-mosque'),
                    'default' => 'Bismillahir Rahmanir Rahim',
                ),
                'hero_title' => array(
                    'type'    => 'richtext',
                    'label'   => __('Main heading', 'uk-mosque'),
                    'default' => 'A Peaceful Place to Pray, Learn, and Belong.',
                ),
                'hero_btn1_text' => array(
                    'type'    => 'text',
                    'label'   => __('Button 1 text', 'uk-mosque'),
                    'default' => 'Discover More',
                    'help'    => __('Leave empty to hide this button.', 'uk-mosque'),
                ),
                'hero_btn1_url' => array(
                    'type'  => 'url',
                    'label' => __('Button 1 link', 'uk-mosque'),
                ),
                'hero_btn2_text' => array(
                    'type'    => 'text',
                    'label'   => __('Button 2 text', 'uk-mosque'),
                    'default' => 'Listen the Quran',
                ),
                'hero_btn2_url' => array(
                    'type'  => 'url',
                    'label' => __('Button 2 link', 'uk-mosque'),
                ),
                'hero_image' => array(
                    'type'  => 'image',
                    'label' => __('Side image', 'uk-mosque'),
                    'help'  => __('Portrait. Leave empty to use the bundled image.', 'uk-mosque'),
                ),
                'hero_bg' => array(
                    'type'  => 'image',
                    'label' => __('Background image', 'uk-mosque'),
                ),
            ),
        ),

        /* ----------------------------------------------------------- 2. About */
        'about' => array(
            'title'  => __('2. About', 'uk-mosque'),
            'fields' => array(
                'about_enable'   => uk_mosque_section_toggle(),
                'about_subtitle' => array(
                    'type'    => 'text',
                    'label'   => __('Sub title', 'uk-mosque'),
                    'default' => 'Welcome to the islamic center',
                ),
                'about_title' => array(
                    'type'    => 'richtext',
                    'label'   => __('Heading', 'uk-mosque'),
                    'default' => 'Your Spiritual Home Guided by the Qur’an and Sunnah',
                ),
                'about_text' => array(
                    'type'    => 'textarea',
                    'label'   => __('Intro text', 'uk-mosque'),
                    'rows'    => 5,
                    'default' => 'Established in 1996, Islamus is dedicated to nurturing faith, knowledge, and unity within our community. We provide regular prayers, Islamic education, community programs, and youth activities — all guided by the principles of the Qur’an and Sunnah.',
                ),
                'about_image1'     => array('type' => 'image', 'label' => __('Image 1', 'uk-mosque')),
                'about_image2'     => array('type' => 'image', 'label' => __('Image 2', 'uk-mosque')),
                'about_tab1_label' => array(
                    'type'    => 'text',
                    'label'   => __('Tab 1 label', 'uk-mosque'),
                    'default' => 'Our Mission',
                ),
                'about_tab1_text' => array(
                    'type'    => 'textarea',
                    'label'   => __('Tab 1 text', 'uk-mosque'),
                    'rows'    => 4,
                    'default' => 'To serve our community through worship, education and outreach, and to be a welcoming home for everyone seeking knowledge of Islam.',
                ),
                'about_tab2_label' => array(
                    'type'    => 'text',
                    'label'   => __('Tab 2 label', 'uk-mosque'),
                    'default' => 'Our Vision',
                ),
                'about_tab2_text' => array(
                    'type'    => 'textarea',
                    'label'   => __('Tab 2 text', 'uk-mosque'),
                    'rows'    => 4,
                    'default' => 'A connected, confident community grounded in the Qur’an and Sunnah, serving the wider society with compassion and integrity.',
                ),
                'about_btn_text' => array(
                    'type'    => 'text',
                    'label'   => __('Button text', 'uk-mosque'),
                    'default' => 'Discover More',
                ),
                'about_btn_url' => array('type' => 'url', 'label' => __('Button link', 'uk-mosque')),
            ),
        ),

        /* ---------------------------------------------------------- 3. Causes */
        'causes' => array(
            'title'       => __('3. Causes', 'uk-mosque'),
            'description' => __('Content comes from Causes (Donations). This panel controls the heading and how many appear.', 'uk-mosque'),
            'fields'      => array(
                'causes_enable'   => uk_mosque_section_toggle(),
                'causes_subtitle' => array(
                    'type'    => 'text',
                    'label'   => __('Sub title', 'uk-mosque'),
                    'default' => 'Make a Donation',
                ),
                'causes_title' => array(
                    'type'    => 'richtext',
                    'label'   => __('Heading', 'uk-mosque'),
                    'default' => 'Empowering Lives Through Islamic Charity',
                ),
                'causes_count'   => uk_mosque_count_field(3),
                'causes_orderby' => array(
                    'type'    => 'select',
                    'label'   => __('Order by', 'uk-mosque'),
                    'default' => 'date',
                    'choices' => array(
                        'date'       => __('Newest first', 'uk-mosque'),
                        'title'      => __('Title (A–Z)', 'uk-mosque'),
                        'menu_order' => __('Manual order', 'uk-mosque'),
                        'rand'       => __('Random', 'uk-mosque'),
                    ),
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

        /* -------------------------------------------------------- 5. Services */
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

        /* ---------------------------------------------------------- 6. Events */
        'events' => array(
            'title'       => __('6. Events', 'uk-mosque'),
            'description' => __('Only events dated today or later are shown, soonest first.', 'uk-mosque'),
            'fields'      => array(
                'events_enable'   => uk_mosque_section_toggle(),
                'events_subtitle' => array(
                    'type'    => 'text',
                    'label'   => __('Sub title', 'uk-mosque'),
                    'default' => 'Events',
                ),
                'events_title' => array(
                    'type'    => 'richtext',
                    'label'   => __('Heading', 'uk-mosque'),
                    'default' => 'Upcoming Events & Activities',
                ),
                'events_text' => array(
                    'type'    => 'textarea',
                    'label'   => __('Intro text', 'uk-mosque'),
                    'rows'    => 3,
                    'default' => 'Join us in our upcoming gatherings and activities to strengthen faith and unity.',
                ),
                'events_count'    => uk_mosque_count_field(3),
                'events_btn_text' => array(
                    'type'    => 'text',
                    'label'   => __('Card button text', 'uk-mosque'),
                    'default' => 'Join Now',
                ),
                'events_btn_url' => array(
                    'type'  => 'url',
                    'label' => __('Card button link', 'uk-mosque'),
                    'help'  => __('Leave empty to link to the event itself.', 'uk-mosque'),
                ),
            ),
        ),

        /* --------------------------------------------------------- 7. Marquee */
        'marquee' => array(
            'title'  => __('7. Marquee', 'uk-mosque'),
            'fields' => array(
                'marquee_enable' => uk_mosque_section_toggle(),
                'marquee_items'  => array(
                    'type'    => 'textarea',
                    'label'   => __('Phrases', 'uk-mosque'),
                    'rows'    => 5,
                    'help'    => __('One phrase per line.', 'uk-mosque'),
                    'default' => "Ask the Imam\nNew to Islam\nDonate Now\nArabic School",
                ),
                'marquee_repeat' => array(
                    'type'    => 'number',
                    'label'   => __('Repeat groups', 'uk-mosque'),
                    'min'     => 1,
                    'max'     => 12,
                    'default' => 6,
                    'help'    => __('How many times the phrase list repeats, so the scroll loops seamlessly.', 'uk-mosque'),
                ),
            ),
        ),

        /* ------------------------------------------------------------ 8. Team */
        'team' => array(
            'title'       => __('8. Team', 'uk-mosque'),
            'description' => __('Content comes from Team Members.', 'uk-mosque'),
            'fields'      => array(
                'team_enable'   => uk_mosque_section_toggle(),
                'team_subtitle' => array(
                    'type'    => 'text',
                    'label'   => __('Sub title', 'uk-mosque'),
                    'default' => 'Our Teachers',
                ),
                'team_title' => array(
                    'type'    => 'richtext',
                    'label'   => __('Heading', 'uk-mosque'),
                    'default' => 'Teachers & Scholars',
                ),
                'team_count' => uk_mosque_count_field(4),
            ),
        ),

        /* ---------------------------------------------------- 9. Donation CTA */
        'donate' => array(
            'title'  => __('9. Donation Call-to-Action', 'uk-mosque'),
            'fields' => array(
                'donate_enable'   => uk_mosque_section_toggle(),
                'donate_subtitle' => array(
                    'type'    => 'text',
                    'label'   => __('Sub title', 'uk-mosque'),
                    'default' => 'Help & Donate',
                ),
                'donate_title' => array(
                    'type'    => 'richtext',
                    'label'   => __('Heading', 'uk-mosque'),
                    'default' => 'Donate / Support <br> Our Center',
                ),
                'donate_text' => array(
                    'type'    => 'textarea',
                    'label'   => __('Text', 'uk-mosque'),
                    'rows'    => 4,
                    'default' => 'Your generous donations help us maintain our masjid, provide community services, and educate future generations. Every contribution counts and is greatly appreciated.',
                ),
                'donate_image'      => array('type' => 'image', 'label' => __('Image', 'uk-mosque')),
                'donate_form_title' => array(
                    'type'    => 'text',
                    'label'   => __('Form heading', 'uk-mosque'),
                    'default' => 'Make Donation',
                ),
                'donate_amounts' => array(
                    'type'    => 'text',
                    'label'   => __('Amount buttons', 'uk-mosque'),
                    'default' => '50,60,70,80,90,100',
                    'help'    => __('Comma-separated numbers. The last one starts selected.', 'uk-mosque'),
                ),
                'donate_paypal_client_id' => array(
                    'type'    => 'text',
                    'label'   => __('PayPal Client ID', 'uk-mosque'),
                    'default' => '',
                    'help'    => __('From developer.paypal.com → Apps & Credentials. Leave empty to hide the PayPal buttons.', 'uk-mosque'),
                ),
                'donate_paypal_currency' => array(
                    'type'    => 'select',
                    'label'   => __('PayPal currency', 'uk-mosque'),
                    'default' => 'GBP',
                    'choices' => array(
                        'GBP' => __('Pound Sterling (GBP)', 'uk-mosque'),
                        'USD' => __('US Dollar (USD)', 'uk-mosque'),
                        'EUR' => __('Euro (EUR)', 'uk-mosque'),
                    ),
                ),
            ),
        ),

        /* ------------------------------------------------------------ 10. FAQ */
        'faq' => array(
            'title'       => __('10. FAQ', 'uk-mosque'),
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

        /* --------------------------------------------------- 11. Testimonials */
        'testi' => array(
            'title'       => __('11. Testimonials', 'uk-mosque'),
            'description' => __('Content comes from Testimonials.', 'uk-mosque'),
            'fields'      => array(
                'testi_enable'   => uk_mosque_section_toggle(),
                'testi_subtitle' => array(
                    'type'    => 'text',
                    'label'   => __('Sub title', 'uk-mosque'),
                    'default' => 'Testimonial',
                ),
                'testi_title' => array(
                    'type'    => 'richtext',
                    'label'   => __('Heading', 'uk-mosque'),
                    'default' => 'Stories of Hope and Change',
                ),
                'testi_count' => uk_mosque_count_field(6),
            ),
        ),

        /* ----------------------------------------------------------- 12. Blog */
        'blog' => array(
            'title'       => __('12. Blog', 'uk-mosque'),
            'description' => __('Content comes from your latest blog posts.', 'uk-mosque'),
            'fields'      => array(
                'blog_enable'   => uk_mosque_section_toggle(),
                'blog_subtitle' => array(
                    'type'    => 'text',
                    'label'   => __('Sub title', 'uk-mosque'),
                    'default' => 'Community News',
                ),
                'blog_title' => array(
                    'type'    => 'richtext',
                    'label'   => __('Heading', 'uk-mosque'),
                    'default' => 'Latest Updates from Our <br> Islamic Center',
                ),
                'blog_count' => uk_mosque_count_field(4),
            ),
        ),

        /* -------------------------------------------------------- 13. Contact */
        'contactsec' => array(
            'title'       => __('13. Contact', 'uk-mosque'),
            'description' => __('Phone, email and address come from Appearance → Customize → Contact Information.', 'uk-mosque'),
            'fields'      => array(
                'contactsec_enable'   => uk_mosque_section_toggle(),
                'contactsec_subtitle' => array(
                    'type'    => 'text',
                    'label'   => __('Sub title', 'uk-mosque'),
                    'default' => 'Contact With Us',
                ),
                'contactsec_title' => array(
                    'type'    => 'richtext',
                    'label'   => __('Heading', 'uk-mosque'),
                    'default' => 'Feel Free to <br> Write us Anytime',
                ),
                'contactsec_map_image' => array('type' => 'image', 'label' => __('Map image', 'uk-mosque')),
                'contactsec_bg_image'  => array('type' => 'image', 'label' => __('Background image', 'uk-mosque')),
                'contactsec_website'   => array(
                    'type'  => 'text',
                    'label' => __('Website shown in the info bar', 'uk-mosque'),
                    'help'  => __('Display text only, e.g. www.example.com. Leave empty to hide.', 'uk-mosque'),
                ),
            ),
        ),

    );
}
