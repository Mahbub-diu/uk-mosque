<?php

/**
 * Theme Options framework.
 *
 * Every option screen is described by an array of sections and fields; this file
 * renders them, sanitizes them and registers the menu. To add a screen, add an
 * entry to uk_mosque_option_pages() — nothing else needs changing.
 *
 * @package uk-mosque
 */

defined('ABSPATH') || exit;


/**
 * Every option screen in the theme.
 * Add a new page here and it appears in the menu automatically.
 */
function uk_mosque_option_pages()
{
    static $pages = null;

    if (null !== $pages) {
        return $pages;
    }

    $pages = array(
        'home' => array(
            'menu_title' => __('Home Page', 'uk-mosque'),
            'page_title' => __('Home Page Settings', 'uk-mosque'),
            'option'     => 'uk_mosque_home_options',
            'sections'   => uk_mosque_home_sections(),
        ),
        'about' => array(
            'menu_title' => __('About Page', 'uk-mosque'),
            'page_title' => __('About Page Settings', 'uk-mosque'),
            'option'     => 'uk_mosque_about_options',
            'sections'   => uk_mosque_about_sections(),
        ),
        'contact' => array(
            'menu_title' => __('Contact Page', 'uk-mosque'),
            'page_title' => __('Contact Page Settings', 'uk-mosque'),
            'option'     => 'uk_mosque_contact_options',
            'sections'   => uk_mosque_contact_sections(),
        ),
        'prayer' => array(
            'menu_title' => __('Prayer Times', 'uk-mosque'),
            'page_title' => __('Prayer Times', 'uk-mosque'),
            'option'     => 'uk_mosque_prayer_options',
            'sections'   => uk_mosque_prayer_sections(),
        ),
    );

    $pages = apply_filters('uk_mosque_option_pages', $pages);

    return $pages;
}


/**
 * Look up one page definition.
 */
function uk_mosque_get_option_page($slug)
{
    $pages = uk_mosque_option_pages();
    return $pages[$slug] ?? null;
}


/**
 * Top-level "Theme Options" menu + one submenu per page.
 */
function uk_mosque_register_option_menus()
{
    add_menu_page(
        __('Theme Options', 'uk-mosque'),
        __('Theme Options', 'uk-mosque'),
        'manage_options',
        'uk-mosque-options',
        'uk_mosque_render_option_page',
        'dashicons-admin-customizer',
        59
    );

    foreach (uk_mosque_option_pages() as $slug => $page) {
        add_submenu_page(
            'uk-mosque-options',
            $page['page_title'],
            $page['menu_title'],
            'manage_options',
            'uk-mosque-' . $slug,
            'uk_mosque_render_option_page'
        );
    }

    // Drop the duplicate parent entry WordPress adds; clicking the parent falls
    // through to the first real screen.
    remove_submenu_page('uk-mosque-options', 'uk-mosque-options');
}
add_action('admin_menu', 'uk_mosque_register_option_menus');


/**
 * Work out which page slug the current admin screen is showing.
 *
 * Only reliable while rendering (a GET request). Saving posts to options.php,
 * where $_GET['page'] is absent — that path passes the slug explicitly instead.
 */
function uk_mosque_current_option_slug()
{
    $page = isset($_GET['page']) ? sanitize_key(wp_unslash($_GET['page'])) : '';
    $slug = str_replace('uk-mosque-', '', $page);

    return uk_mosque_get_option_page($slug) ? $slug : 'home';
}


/**
 * One registered setting per page; the whole array is sanitized in one callback.
 *
 * The callback is a closure bound to this page's slug. A shared named callback
 * cannot work here: options.php posts without $_GET['page'], so the sanitizer
 * would have no way to tell which screen it is validating.
 */
function uk_mosque_register_options()
{
    foreach (uk_mosque_option_pages() as $slug => $page) {
        register_setting(
            'uk_mosque_' . $slug . '_group',
            $page['option'],
            array(
                'type'              => 'array',
                'default'           => array(),
                'sanitize_callback' => static function ($input) use ($slug) {
                    return uk_mosque_sanitize_options($input, $slug);
                },
            )
        );
    }
}
add_action('admin_init', 'uk_mosque_register_options');


/**
 * Sanitize a whole page's values according to each field's declared type.
 *
 * Fields the form did not submit (an unchecked checkbox, a field added since the
 * last save) fall back to '' and are still written, so the stored array always
 * matches the current field definitions.
 *
 * @param mixed  $input Raw $_POST value for this option.
 * @param string $slug  Page slug being saved.
 * @return array
 */
function uk_mosque_sanitize_options($input, $slug = '')
{
    $slug = $slug ?: uk_mosque_current_option_slug();
    $page = uk_mosque_get_option_page($slug);

    if (!$page || !is_array($input)) {
        return array();
    }

    $clean = array();

    foreach ($page['sections'] as $section) {
        foreach ($section['fields'] as $key => $field) {
            $type  = $field['type'] ?? 'text';
            $value = $input[$key] ?? '';

            // A field may supply its own validator. Needed where a whitelist of
            // valid values cannot be built cheaply on every request.
            if (isset($field['sanitize']) && is_callable($field['sanitize'])) {
                $clean[$key] = call_user_func($field['sanitize'], $value);
                continue;
            }

            switch ($type) {
                case 'checkbox':
                    $clean[$key] = empty($value) ? 0 : 1;
                    break;

                case 'number':
                case 'image': // stores an attachment ID
                    $clean[$key] = absint($value);
                    break;

                case 'url':
                    $clean[$key] = esc_url_raw($value);
                    break;

                case 'email':
                    $clean[$key] = sanitize_email($value);
                    break;

                case 'textarea':
                    $clean[$key] = sanitize_textarea_field($value);
                    break;

                case 'richtext': // headings that allow <br>, <span>, <strong>, <em>
                    $clean[$key] = wp_kses($value, uk_mosque_allowed_title_html());
                    break;

                case 'wysiwyg':
                    $clean[$key] = wp_kses_post($value);
                    break;

                case 'select':
                    $choices     = array_keys($field['choices'] ?? array());
                    $clean[$key] = in_array($value, $choices, true)
                        ? $value
                        : ($field['default'] ?? '');
                    break;

                default:
                    $clean[$key] = sanitize_text_field($value);
            }
        }
    }

    return $clean;
}


/**
 * The design puts <br> inside headings — allow a tiny, safe subset.
 */
function uk_mosque_allowed_title_html()
{
    return array(
        'br'     => array(),
        'span'   => array('class' => array()),
        'strong' => array(),
        'em'     => array(),
    );
}


/**
 * Render one settings screen.
 */
function uk_mosque_render_option_page()
{
    if (!current_user_can('manage_options')) {
        return;
    }

    $slug = uk_mosque_current_option_slug();
    $page = uk_mosque_get_option_page($slug);
    $name = $page['option'];
    $vals = get_option($name, array());

    if (!is_array($vals)) {
        $vals = array();
    }
?>
    <div class="wrap uk-mosque-options">
        <h1><?php echo esc_html($page['page_title']); ?></h1>

        <form method="post" action="options.php">
            <?php settings_fields('uk_mosque_' . $slug . '_group'); ?>

            <?php foreach ($page['sections'] as $section) : ?>
                <div class="uk-mosque-panel">
                    <h2 class="uk-mosque-panel__title"><?php echo esc_html($section['title']); ?></h2>

                    <?php if (!empty($section['description'])) : ?>
                        <p class="description"><?php echo esc_html($section['description']); ?></p>
                    <?php endif; ?>

                    <table class="form-table" role="presentation">
                        <tbody>
                            <?php foreach ($section['fields'] as $key => $field) : ?>
                                <tr>
                                    <th scope="row">
                                        <label for="<?php echo esc_attr($key); ?>">
                                            <?php echo esc_html($field['label']); ?>
                                        </label>
                                    </th>
                                    <td>
                                        <?php
                                        uk_mosque_render_field(
                                            $key,
                                            $field,
                                            $vals[$key] ?? ($field['default'] ?? ''),
                                            $name
                                        );
                                        ?>
                                        <?php if (!empty($field['help'])) : ?>
                                            <p class="description"><?php echo esc_html($field['help']); ?></p>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endforeach; ?>

            <?php submit_button(); ?>
        </form>
    </div>
<?php
}


/**
 * Render a single field control.
 *
 * @param string $key      Field key.
 * @param array  $field    Field definition.
 * @param mixed  $value    Current value.
 * @param string $opt_name The wp_options row name, used to namespace input names.
 */
function uk_mosque_render_field($key, $field, $value, $opt_name)
{
    $type = $field['type'] ?? 'text';
    $name = $opt_name . '[' . $key . ']';
    $id   = esc_attr($key);

    switch ($type) {

        case 'textarea':
            printf(
                '<textarea id="%s" name="%s" rows="%d" class="large-text">%s</textarea>',
                $id,
                esc_attr($name),
                (int) ($field['rows'] ?? 4),
                esc_textarea($value)
            );
            break;

        case 'richtext':
            printf(
                '<textarea id="%s" name="%s" rows="3" class="large-text code">%s</textarea>',
                $id,
                esc_attr($name),
                esc_textarea($value)
            );
            echo '<p class="description">'
                . esc_html__('You may use <br> to force a line break.', 'uk-mosque')
                . '</p>';
            break;

        case 'wysiwyg':
            wp_editor(
                $value,
                $id,
                array(
                    'textarea_name' => $name,
                    'textarea_rows' => 8,
                    'media_buttons' => false,
                )
            );
            break;

        case 'checkbox':
            printf(
                '<label><input type="checkbox" id="%s" name="%s" value="1" %s> %s</label>',
                $id,
                esc_attr($name),
                checked(1, (int) $value, false),
                esc_html($field['checkbox_label'] ?? __('Enable', 'uk-mosque'))
            );
            break;

        case 'number':
            printf(
                '<input type="number" id="%s" name="%s" value="%s" min="%s" max="%s" step="1" class="small-text">',
                $id,
                esc_attr($name),
                esc_attr($value),
                esc_attr($field['min'] ?? 0),
                esc_attr($field['max'] ?? 100)
            );
            break;

        case 'select':
            printf('<select id="%s" name="%s">', $id, esc_attr($name));
            foreach (($field['choices'] ?? array()) as $choice_key => $choice_label) {
                printf(
                    '<option value="%s" %s>%s</option>',
                    esc_attr($choice_key),
                    selected($value, $choice_key, false),
                    esc_html($choice_label)
                );
            }
            echo '</select>';
            break;

        case 'image':
            $img_id  = absint($value);
            $preview = $img_id ? wp_get_attachment_image($img_id, 'medium') : '';
?>
            <div class="uk-mosque-image-field">
                <div class="uk-mosque-image-field__preview"><?php echo $preview; ?></div>
                <input type="hidden" id="<?php echo $id; ?>"
                    name="<?php echo esc_attr($name); ?>"
                    value="<?php echo esc_attr($img_id); ?>">
                <button type="button" class="button uk-mosque-image-upload">
                    <?php esc_html_e('Select image', 'uk-mosque'); ?>
                </button>
                <button type="button" class="button uk-mosque-image-remove" <?php disabled(!$img_id); ?>>
                    <?php esc_html_e('Remove', 'uk-mosque'); ?>
                </button>
            </div>
<?php
            break;

        case 'url':
        case 'email':
        case 'text':
        default:
            $input_type = in_array($type, array('url', 'email'), true) ? $type : 'text';
            printf(
                '<input type="%s" id="%s" name="%s" value="%s" class="regular-text">',
                esc_attr($input_type),
                $id,
                esc_attr($name),
                esc_attr($value)
            );
    }
}


/**
 * Load the media frame and screen styling on the theme's own option screens only.
 */
function uk_mosque_options_admin_assets($hook)
{
    if (false === strpos($hook, 'uk-mosque-')) {
        return;
    }

    $version = wp_get_theme()->get('Version');

    wp_enqueue_media();

    wp_enqueue_style(
        'uk-mosque-options',
        get_template_directory_uri() . '/assets/css/admin/options.css',
        array(),
        $version
    );

    wp_enqueue_script(
        'uk-mosque-options',
        get_template_directory_uri() . '/assets/js/admin/options.js',
        array('jquery'),
        $version,
        true
    );
}
add_action('admin_enqueue_scripts', 'uk_mosque_options_admin_assets');
