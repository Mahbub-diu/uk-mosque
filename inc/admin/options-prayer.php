<?php

/**
 * Prayer Times field definitions.
 *
 * Shared by the homepage, the About page and the Prayer Times page template,
 * so these live on their own screen rather than under any one page.
 *
 * @package uk-mosque
 */

defined('ABSPATH') || exit;


function uk_mosque_prayer_sections()
{
    $fields = array();

    foreach (uk_mosque_prayer_list() as $key => $label) {
        $fields['prayer_' . $key . '_azan'] = array(
            'type'  => 'text',
            /* translators: %s: prayer name, e.g. Fajr */
            'label' => sprintf(__('%s — Azan', 'uk-mosque'), $label),
        );

        $fields['prayer_' . $key . '_iqamah'] = array(
            'type'  => 'text',
            /* translators: %s: prayer name, e.g. Fajr */
            'label' => sprintf(__('%s — Iqamah', 'uk-mosque'), $label),
        );
    }

    return array(

        'times' => array(
            'title'       => __('Daily Salah Timings', 'uk-mosque'),
            'description' => __('Enter times exactly as you want them displayed, e.g. 5:12 am.', 'uk-mosque'),
            'fields'      => $fields,
        ),

        'extra' => array(
            'title'  => __('Additional Information', 'uk-mosque'),
            'fields' => array(
                'prayer_sunrise' => array(
                    'type'  => 'text',
                    'label' => __('Sunrise', 'uk-mosque'),
                ),
                'prayer_note' => array(
                    'type'  => 'textarea',
                    'label' => __('Note', 'uk-mosque'),
                    'rows'  => 3,
                    'help'  => __('Shown under the timetable on the Prayer Times page.', 'uk-mosque'),
                ),
            ),
        ),

    );
}
