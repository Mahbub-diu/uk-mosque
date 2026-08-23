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

    $event_topic = get_post_meta(
        $post->ID,
        '_event_topic',
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

    <div class="common-metabox-field">

        <label for="event_topic">
            <strong>
                <?php esc_html_e('Event Topic', 'uk-mosque'); ?>
            </strong>
        </label>

        <input type="text" id="event_topic" name="event_topic" value="<?php echo esc_attr($event_topic); ?>">

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


    if (isset($_POST['event_topic'])) {

        update_post_meta(
            $post_id,
            '_event_topic',
            sanitize_text_field(
                wp_unslash($_POST['event_topic'])
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
 *  Admin CSS
 * =========================================================
 */

function uk_mosque_admin_styles($hook)
{
    global $post_type;



    if (
        !in_array(
            $post_type,
            array(
                'event',
                'donation',
                'team_member',
                'testimonial'
            ),
            true
        )
        ||
        !in_array(
            $hook,
            array(
                'post.php',
                'post-new.php',
            ),
            true
        )
    ) {
        return;
    }


    wp_enqueue_style(
        'uk-mosque-admin',
        get_template_directory_uri() . '/assets/css/admin/admin-events.css',
        array(),
        '1.0.0'
    );
}

add_action(
    'admin_enqueue_scripts',
    'uk_mosque_admin_styles'
);

/**
 * Donation Details Metabox Callback
 */


function uk_mosque_donation_details_metabox()
{
    add_meta_box(
        'uk_mosque_donation_details',
        __('Donation Details', 'uk-mosque'),
        'uk_mosque_donation_details_callback',
        'donation',
        'normal',
        'high'
    );
}

add_action('add_meta_boxes', 'uk_mosque_donation_details_metabox');

function uk_mosque_donation_details_callback($post)
{

    wp_nonce_field(
        'uk_mosque_save_donation_details',
        'uk_mosque_donation_details_nonce'
    );

    $donation_goal_amount = get_post_meta(
        $post->ID,
        '_donation_goal_amount',
        true
    );

    $donation_raised_amount = get_post_meta(
        $post->ID,
        '_donation_raised_amount',
        true
    );

    $donation_start_date = get_post_meta(
        $post->ID,
        '_donation_start_date',
        true
    );

    $donation_end_date = get_post_meta(
        $post->ID,
        '_donation_end_date',
        true
    );
?>


<!-- input will be here -->
<div class="common-metabox-flex">
    <div class="common-metabox-field">
        <label for="donation_goal_amount">
            <strong>
                <?php esc_html_e('Goal Amount', 'uk-mosque') ?>
            </strong>
        </label>

        <input type="number" id="donation_goal_amount" name="donation_goal_amount"
            value="<?php echo esc_attr($donation_goal_amount) ?>" min="0" step="0.01">
    </div>
    <div class="common-metabox-field">
        <label for="donation_raised_amount">
            <strong><?php esc_html_e('Raised Amount', 'uk-mosque') ?> </strong>
        </label>

        <input type="number" id="donation_raised_amount" name="donation_raised_amount"
            value="<?php echo esc_attr($donation_raised_amount) ?>" min="0" step="0.01">
    </div>
</div>

<div class="common-metabox-flex">

    <div class="common-metabox-field">
        <label for="donation_start_date">
            <strong><?php esc_html_e('Start Date', 'uk-mosque') ?> </strong>
        </label>

        <input type="date" id="donation_start_date" name="donation_start_date"
            value="<?php echo esc_attr($donation_start_date) ?>">
    </div>
    <div class="common-metabox-field">
        <label for="donation_end_date">
            <strong><?php esc_html_e('end Date', 'uk-mosque') ?> </strong>
        </label>

        <input type="date" id="donation_end_date" name="donation_end_date"
            value="<?php echo esc_attr($donation_end_date) ?>">
    </div>
</div>

<?php
}

/**
 * Save Donation Details
 */

function uk_mosque_save_donation_details($post_id)
{

    if (
        !isset($_POST['uk_mosque_donation_details_nonce'])

        ||

        !wp_verify_nonce(
            wp_unslash($_POST['uk_mosque_donation_details_nonce']),
            'uk_mosque_save_donation_details'
        )


    ) {
        return;
    }

    /**
     * Prevent autosave
     */

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (
        !current_user_can(
            'edit_post',
            $post_id
        )
    ) {
        return;
    }


    if (isset($_POST['donation_goal_amount'])) {
        update_post_meta(
            $post_id,
            '_donation_goal_amount',
            sanitize_text_field(
                wp_unslash($_POST['donation_goal_amount'])
            )
        );
    }

    if (isset($_POST['donation_raised_amount'])) {
        update_post_meta(
            $post_id,
            '_donation_raised_amount',
            sanitize_text_field(
                wp_unslash($_POST['donation_raised_amount'])
            )
        );
    }

    if (isset($_POST['donation_start_date'])) {
        update_post_meta(
            $post_id,
            '_donation_start_date',
            sanitize_text_field(
                wp_unslash($_POST['donation_start_date'])
            )
        );
    }

    if (isset($_POST['donation_end_date'])) {
        update_post_meta(
            $post_id,
            '_donation_end_date',
            sanitize_text_field(
                wp_unslash($_POST['donation_end_date'])
            )
        );
    }
}

add_action('save_post_donation', 'uk_mosque_save_donation_details');



function uk_mosque_team_details_metabox()
{
    add_meta_box(
        'uk_mosque_team_details',
        __('Social Media Link', 'uk-mosque'),
        'uk_mosque_team_details_callback',
        'team_member',
        'normal',
        'high'
    );
}

add_action('add_meta_boxes', 'uk_mosque_team_details_metabox');


function uk_mosque_team_details_callback($post)
{

    wp_nonce_field('uk_mosque_save_team_details', 'uk_mosque_team_details_nonce');

    $team_facebook = get_post_meta(
        $post->ID,
        '_team_facebook',
        true
    );

    $team_instagram = get_post_meta(
        $post->ID,
        '_team_instagram',
        true
    );

    $team_twitter = get_post_meta(
        $post->ID,
        '_team_twitter',
        true
    );


?>

<div class="common-metabox-flex">
    <div class="common-metabox-field">
        <label for="team_facebook">
            <strong><?php esc_html_e('Facebook', 'uk-mosque') ?> </strong>
        </label>

        <input type="url" id="team_facebook" name="team_facebook" value="<?php echo esc_attr($team_facebook) ?>">
    </div>

    <div class="common-metabox-field">
        <label for="team_instagram">
            <strong><?php esc_html_e('instagram', 'uk-mosque') ?> </strong>
        </label>

        <input type="url" id="team_instagram" name="team_instagram" value="<?php echo esc_attr($team_instagram) ?>">
    </div>
</div>
<div class="common-metabox-flex">
    <div class="common-metabox-field">
        <label for="team_twitter">
            <strong><?php esc_html_e('twitter', 'uk-mosque') ?> </strong>
        </label>

        <input type="url" id="team_twitter" name="team_twitter" value="<?php echo esc_attr($team_twitter) ?>">
    </div>
</div>



<?php

}

function uk_mosque_save_team_details($post_id)
{
    if (
        !isset($_POST['uk_mosque_team_details_nonce'])

        ||

        !wp_verify_nonce(
            wp_unslash($_POST['uk_mosque_team_details_nonce']),
            'uk_mosque_save_team_details'
        )

    ) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (
        !current_user_can(
            'edit_post',
            $post_id
        )
    ) {
        return;
    }


    if (isset($_POST['team_facebook'])) {
        update_post_meta(
            $post_id,
            '_team_facebook',
            esc_url_raw(
                wp_unslash($_POST['team_facebook'])
            )
        );
    }

    if (isset($_POST['team_instagram'])) {
        update_post_meta(
            $post_id,
            '_team_instagram',
            esc_url_raw(
                wp_unslash($_POST['team_instagram'])
            )
        );
    }

    if (isset($_POST['team_twitter'])) {
        update_post_meta(
            $post_id,
            '_team_twitter',
            esc_url_raw(
                wp_unslash($_POST['team_twitter'])
            )
        );
    }
}

add_action('save_post_team_member', 'uk_mosque_save_team_details');

/**
 * Testimonial Details Meta Box
 */
function uk_mosque_testimonial_details_metabox()
{
    add_meta_box(
        'uk_mosque_testimonial_details',
        __('Testimonial Details', 'uk-mosque'),
        'uk_mosque_testimonial_details_callback',
        'testimonial',
        'side',
        'high'
    );
}

add_action(
    'add_meta_boxes',
    'uk_mosque_testimonial_details_metabox'
);


function uk_mosque_testimonial_details_callback($post)
{

    wp_nonce_field(
        'uk_mosque_testimonial_details_save',
        'uk_mosque_testimonial_details_nonce'
    );

    $role = get_post_meta(
        $post->ID,
        '_uk_mosque_testimonial_role',
        true
    );

    $rating = get_post_meta(
        $post->ID,
        '_uk_mosque_testimonial_rating',
        true
    );


?>

<div class="common-metabox-field">
    <label for="uk_mosque_testimonial_role">
        <strong><?php esc_html_e('Designation / Role', 'uk-mosque'); ?></strong>
    </label>

    <input type="text" id="uk_mosque_testimonial_role" name="uk_mosque_testimonial_role"
        value="<?php echo esc_attr($role); ?>" placeholder="<?php esc_attr_e('e.g. Community Member', 'uk-mosque'); ?>">
</div>

<div class="common-metabox-field">
    <label for="uk_mosque_testimonial_rating">
        <strong> <?php esc_html_e('Rating', 'uk-mosque'); ?></strong>
    </label>

    <input type="number" id="uk_mosque_testimonial_rating" name="uk_mosque_testimonial_rating"
        value="<?php echo esc_attr($rating); ?>" min="1" max="5" step="1"
        placeholder="<?php esc_attr_e('1 - 5', 'uk-mosque'); ?>">
</div>

<?php
}

function uk_mosque_save_testimonial_details($post_id)
{
    if (
        !isset(
            $_POST['uk_mosque_testimonial_details_nonce']
        )
    ) {
        return;
    }

    if (
        !wp_verify_nonce(
            wp_unslash(
                $_POST['uk_mosque_testimonial_details_nonce']
            ),
            'uk_mosque_testimonial_details_save'
        )
    ) {
        return;
    }

    if (
        defined('DOING_AUTOSAVE')
        && DOING_AUTOSAVE
    ) {
        return;
    }

    if (
        get_post_type($post_id) !== 'testimonial'
    ) {
        return;
    }

    if (
        !current_user_can(
            'edit_post',
            $post_id
        )
    ) {
        return;
    }

    /**
     * Save Role
     */
    if (
        isset(
            $_POST['uk_mosque_testimonial_role']
        )
    ) {
        $role = sanitize_text_field(
            wp_unslash(
                $_POST['uk_mosque_testimonial_role']
            )
        );

        update_post_meta(
            $post_id,
            '_uk_mosque_testimonial_role',
            $role
        );
    }

    /**
     * Save Rating
     */
    if (
        isset(
            $_POST['uk_mosque_testimonial_rating']
        )
    ) {
        $rating = absint(
            wp_unslash(
                $_POST['uk_mosque_testimonial_rating']
            )
        );

        if ($rating >= 1 && $rating <= 5) {
            update_post_meta(
                $post_id,
                '_uk_mosque_testimonial_rating',
                $rating
            );
        } else {
            delete_post_meta(
                $post_id,
                '_uk_mosque_testimonial_rating'
            );
        }
    }
}

add_action(
    'save_post_testimonial',
    'uk_mosque_save_testimonial_details'
);