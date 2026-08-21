<?php

if (!defined('ABSPATH')) {
    exit;
}

/**
 * =========================================================
 * Event Details Metabox
 * =========================================================
 */

/**
 * Register Event Details Metabox
 */
function uk_mosque_event_details_metabox()
{
    add_meta_box(
        'uk_mosque_event_details',
        __('Event Details', 'uk-mosque'),
        'uk_mosque_event_details_callback',
        'event',
        'side',
        'high'
    );
}

add_action(
    'add_meta_boxes',
    'uk_mosque_event_details_metabox'
);


/**
 * Event Details Metabox Callback
 */
function uk_mosque_event_details_callback($post)
{

    wp_nonce_field(
        'uk_mosque_save_event_details',
        'uk_mosque_event_nonce'
    );



    $event_date = get_post_meta(
        $post->ID,
        '_event_date',
        true
    );

    $event_location = get_post_meta(
        $post->ID,
        '_event_location',
        true
    );

    $event_start = get_post_meta(
        $post->ID,
        '_event_start',
        true
    );

    $event_end = get_post_meta(
        $post->ID,
        '_event_end',
        true
    );

?>

<div class="common-metabox-flex">

    <div class="common-metabox-field">

        <label for="event_date">
            <strong>
                <?php esc_html_e('Event Date', 'uk-mosque'); ?>
            </strong>
        </label>

        <input type="date" id="event_date" name="event_date" value="<?php echo esc_attr($event_date); ?>">

    </div>

    <div class="common-metabox-field">

        <label for="event_location">
            <strong>
                <?php esc_html_e('Event Location', 'uk-mosque'); ?>
            </strong>
        </label>

        <input type="text" id="event_location" name="event_location" value="<?php echo esc_attr($event_location); ?>">

    </div>

</div>


<div class="common-metabox-flex">

    <div class="common-metabox-field">

        <label for="event_start">
            <strong>
                <?php esc_html_e('Start Time', 'uk-mosque'); ?>
            </strong>
        </label>

        <input type="time" id="event_start" name="event_start" value="<?php echo esc_attr($event_start); ?>">

    </div>

    <div class="common-metabox-field">

        <label for="event_end">
            <strong>
                <?php esc_html_e('End Time', 'uk-mosque'); ?>
            </strong>
        </label>

        <input type="time" id="event_end" name="event_end" value="<?php echo esc_attr($event_end); ?>">

    </div>

</div>

<?php
}


/**
 * =========================================================
 * Save Event Details
 * =========================================================
 */

function uk_mosque_save_event_details($post_id)
{

    if (
        !isset($_POST['uk_mosque_event_nonce']) ||
        !wp_verify_nonce(
            sanitize_text_field(
                wp_unslash($_POST['uk_mosque_event_nonce'])
            ),
            'uk_mosque_save_event_details'
        )
    ) {
        return;
    }


    if (
        defined('DOING_AUTOSAVE') &&
        DOING_AUTOSAVE
    ) {
        return;
    }



    if (!current_user_can('edit_post', $post_id)) {
        return;
    }


    if (get_post_type($post_id) !== 'event') {
        return;
    }


    if (isset($_POST['event_date'])) {

        update_post_meta(
            $post_id,
            '_event_date',
            sanitize_text_field(
                wp_unslash($_POST['event_date'])
            )
        );
    }


    if (isset($_POST['event_location'])) {

        update_post_meta(
            $post_id,
            '_event_location',
            sanitize_text_field(
                wp_unslash($_POST['event_location'])
            )
        );
    }


    if (isset($_POST['event_start'])) {

        update_post_meta(
            $post_id,
            '_event_start',
            sanitize_text_field(
                wp_unslash($_POST['event_start'])
            )
        );
    }



    if (isset($_POST['event_end'])) {

        update_post_meta(
            $post_id,
            '_event_end',
            sanitize_text_field(
                wp_unslash($_POST['event_end'])
            )
        );
    }
}

add_action(
    'save_post_event',
    'uk_mosque_save_event_details'
);


/**
 * =========================================================
 * Event Admin CSS
 * =========================================================
 */

function uk_mosque_event_admin_styles($hook)
{
    global $post_type;

    if (
        $post_type !== 'event' ||
        !in_array(
            $hook,
            array(
                'post.php',
                'post-new.php'
            ),
            true
        )
    ) {
        return;
    }


    wp_enqueue_style(
        'uk-mosque-event-admin',
        get_template_directory_uri() . '/assets/css/admin/admin-events.css',
        array(),
        '1.0.0'
    );
}

add_action(
    'admin_enqueue_scripts',
    'uk_mosque_event_admin_styles'
);