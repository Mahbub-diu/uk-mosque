# Making `front-page.php` Dynamic — Step-by-Step Guide

**Goal:** turn all 1498 lines of static markup in [front-page.php](front-page.php) into a
template driven by the database, where **every section is editable from a dedicated
"Home Page" screen in the WordPress dashboard**.

Companion to [development.md](development.md) — that file covers the whole theme, this one
covers only the front page, in much more detail.

---

## Part 0 — What you are building

When this is done, the dashboard will have:

```
WP Admin sidebar
└── Theme Options              ← new top-level menu
    ├── Home Page              ← this guide
    ├── About Page             ← same pattern, later
    ├── Contact Page           ← same pattern, later
    └── Prayer Times           ← same pattern, later
```

And the **Home Page** screen will have one panel per section of the front page:

```
Home Page Settings
├── 1. Hero Banner          [ Show section ✓ ]  subtitle, title, 2 buttons, image
├── 2. About                [ Show section ✓ ]  subtitle, title, text, 2 images, mission/vision tabs
├── 3. Causes               [ Show section ✓ ]  subtitle, title, how many to show
├── 4. Prayer Times         [ Show section ✓ ]  subtitle, title, text  (times live on their own screen)
├── 5. Services             [ Show section ✓ ]  subtitle, title, side text, how many
├── 6. Events               [ Show section ✓ ]  subtitle, title, text, how many
├── 7. Marquee              [ Show section ✓ ]  the scrolling phrases
├── 8. Team                 [ Show section ✓ ]  subtitle, title, how many
├── 9. Donation CTA         [ Show section ✓ ]  subtitle, title, text, image, amount buttons
├── 10. FAQ                 [ Show section ✓ ]  subtitle, title, how many
├── 11. Testimonials        [ Show section ✓ ]  subtitle, title, how many
├── 12. Blog                [ Show section ✓ ]  subtitle, title, how many
└── 13. Contact             [ Show section ✓ ]  subtitle, title, map image
```

Each section also gets a **Show section** checkbox, so the client can hide a whole block
without calling you.

### The split: what lives where

| Kind of content                                                | Stored in                        | Why                                                          |
| -------------------------------------------------------------- | -------------------------------- | ------------------------------------------------------------ |
| Section headings, intro text, buttons, background images       | **Home Page options screen**     | One value, only appears on Home                              |
| Causes, Services, Events, Team, FAQs, Testimonials, Blog posts | **The CPTs you already built**   | Repeatable, reused on other pages, needs its own edit screen |
| Prayer times                                                   | **Theme Options → Prayer Times** | Shared by Home, About and the Prayer Times page              |
| Address, phone, email, social links                            | **Customizer** (already done)    | Site-wide identity, appears in header and footer too         |

> **Do not** build repeater fields for causes/services/events. You already have CPTs for all
> of them. The Home screen only chooses _how many_ to show and _in what order_.

### One setting you must change first

Right now WordPress is probably on **Settings → Reading → Your latest posts**. In that mode
`front-page.php` renders the homepage and [home.php](home.php) **never runs at all**.

Go to **Settings → Reading** and set:

- _Your homepage displays:_ **A static page**
- _Homepage:_ create and pick a page called "Home"
- _Posts page:_ create and pick a page called "Blog"

Now `front-page.php` renders `/` and `home.php` renders `/blog/`. Do this before you start.

---

## Part 1 — Architecture decision

[development.md](development.md) §B.1 recommended keeping everything in the Customizer. Your
requirement — _edit page-wise from the dashboard_ — points the other way for page content, so:

- **Customizer keeps** the 7 global settings already built (address, phone, email, 4 socials).
  Do not migrate them; they are site-wide, not page content.
- **New dashboard screens** hold page content, one screen per page, built on the Settings API.

Storage: **one `wp_options` row per page**, holding an array.

```
uk_mosque_home_options     = array('hero_title' => '…', 'hero_image' => 123, …)
uk_mosque_about_options    = array(…)
uk_mosque_contact_options  = array(…)
uk_mosque_prayer_options   = array(…)
```

One row instead of 60 keeps `wp_options` clean and makes the whole page's settings load in a
single query. It also means one `register_setting()` call and one sanitize callback per page.

**Everything is driven by a field-definition array.** You describe the fields once; the
framework renders them, sanitizes them and supplies defaults. You never hand-write an
`add_settings_field()` call.

---

## Part 2 — Build the options framework

Do this once. Every later page screen is then just an array of field definitions.

### Step 2.1 — Create the folder

```
inc/admin/
├── options-framework.php     ← the engine (Step 2.2–2.5)
└── options-home.php          ← Home field definitions (Part 3)
assets/js/admin/
└── options.js                ← media uploader (Step 2.6)
assets/css/admin/
└── options.css               ← light styling (Step 2.7)
```

### Step 2.2 — `inc/admin/options-framework.php` — page registry and menu

```php
<?php
if (!defined('ABSPATH')) { exit; }

/**
 * Every option screen in the theme.
 * Add a new page here and it appears in the menu automatically.
 */
function uk_mosque_option_pages()
{
    $pages = array(
        'home' => array(
            'menu_title' => __('Home Page', 'uk-mosque'),
            'page_title' => __('Home Page Settings', 'uk-mosque'),
            'option'     => 'uk_mosque_home_options',
            'sections'   => uk_mosque_home_sections(),
        ),
    );

    return apply_filters('uk_mosque_option_pages', $pages);
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
            'uk-mosque-options' === $slug ? 'uk-mosque-options' : 'uk-mosque-' . $slug,
            'uk_mosque_render_option_page'
        );
    }

    // The auto-created duplicate of the parent item: point it at the first real page.
    remove_submenu_page('uk-mosque-options', 'uk-mosque-options');
}
add_action('admin_menu', 'uk_mosque_register_option_menus');

/**
 * Work out which page slug the current admin screen is showing.
 */
function uk_mosque_current_option_slug()
{
    $page = isset($_GET['page']) ? sanitize_key($_GET['page']) : '';
    $slug = str_replace('uk-mosque-', '', $page);
    return uk_mosque_get_option_page($slug) ? $slug : 'home';
}
```

> `remove_submenu_page()` deletes the duplicate top-level entry WordPress adds. Because of it,
> clicking "Theme Options" lands on the first submenu — "Home Page". That is what you want.

### Step 2.3 — Register the settings

```php
/**
 * One registered setting per page; the whole array is sanitized in one callback.
 */
function uk_mosque_register_options()
{
    foreach (uk_mosque_option_pages() as $slug => $page) {
        register_setting(
            'uk_mosque_' . $slug . '_group',
            $page['option'],
            array(
                'type'              => 'array',
                'sanitize_callback' => 'uk_mosque_sanitize_options',
                'default'           => array(),
            )
        );
    }
}
add_action('admin_init', 'uk_mosque_register_options');

/**
 * Sanitize a whole page's values according to each field's declared type.
 */
function uk_mosque_sanitize_options($input)
{
    $slug = uk_mosque_current_option_slug();
    $page = uk_mosque_get_option_page($slug);

    if (!$page || !is_array($input)) {
        return array();
    }

    $clean = array();

    foreach ($page['sections'] as $section) {
        foreach ($section['fields'] as $key => $field) {
            $type  = $field['type'] ?? 'text';
            $value = $input[$key] ?? '';

            switch ($type) {
                case 'checkbox':
                    $clean[$key] = empty($value) ? 0 : 1;
                    break;

                case 'number':
                case 'image':               // stores an attachment ID
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

                case 'richtext':            // headings that allow <br>, <span>, <strong>
                    $clean[$key] = wp_kses($value, uk_mosque_allowed_title_html());
                    break;

                case 'wysiwyg':
                    $clean[$key] = wp_kses_post($value);
                    break;

                case 'select':
                    $choices     = array_keys($field['choices'] ?? array());
                    $clean[$key] = in_array($value, $choices, true) ? $value : ($field['default'] ?? '');
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
```

> **Why `richtext` exists:** headings in this design contain line breaks, e.g.
> `Latest Updates from Our <br> Islamic Center`. `esc_html()` would print the tag literally.
> `wp_kses()` with a 4-tag whitelist is the safe middle ground.

### Step 2.4 — Render the screen

```php
function uk_mosque_render_option_page()
{
    if (!current_user_can('manage_options')) {
        return;
    }

    $slug = uk_mosque_current_option_slug();
    $page = uk_mosque_get_option_page($slug);
    $name = $page['option'];
    $vals = get_option($name, array());
    ?>
    <div class="wrap uk-mosque-options">
        <h1><?php echo esc_html($page['page_title']); ?></h1>

        <form method="post" action="options.php">
            <?php settings_fields('uk_mosque_' . $slug . '_group'); ?>

            <?php foreach ($page['sections'] as $section_key => $section) : ?>
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
```

### Step 2.5 — Render one field

```php
/**
 * @param string $key       Field key.
 * @param array  $field     Field definition.
 * @param mixed  $value     Current value.
 * @param string $opt_name  The wp_options row name (used to namespace input names).
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
            echo '<p class="description">' .
                esc_html__('You may use <br> to force a line break.', 'uk-mosque') .
                '</p>';
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
                '<input type="number" id="%s" name="%s" value="%s" min="%s" max="%s" class="small-text">',
                $id,
                esc_attr($name),
                esc_attr($value),
                esc_attr($field['min'] ?? 0),
                esc_attr($field['max'] ?? 100)
            );
            break;

        case 'select':
            printf('<select id="%s" name="%s">', $id, esc_attr($name));
            foreach (($field['choices'] ?? array()) as $ck => $cl) {
                printf(
                    '<option value="%s" %s>%s</option>',
                    esc_attr($ck),
                    selected($value, $ck, false),
                    esc_html($cl)
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
        default:
            printf(
                '<input type="%s" id="%s" name="%s" value="%s" class="regular-text">',
                esc_attr($type === 'default' ? 'text' : $type),
                $id,
                esc_attr($name),
                esc_attr($value)
            );
    }
}
```

### Step 2.6 — Media uploader — `assets/js/admin/options.js`

```js
jQuery(function ($) {
  var frame;

  $(document).on('click', '.uk-mosque-image-upload', function (e) {
    e.preventDefault();
    var $wrap = $(this).closest('.uk-mosque-image-field');

    frame = wp.media({
      title: 'Select image',
      button: { text: 'Use this image' },
      multiple: false,
    });

    frame.on('select', function () {
      var att = frame.state().get('selection').first().toJSON();
      var src = att.sizes && att.sizes.medium ? att.sizes.medium.url : att.url;

      $wrap.find('input[type="hidden"]').val(att.id);
      $wrap
        .find('.uk-mosque-image-field__preview')
        .html($('<img>', { src: src, alt: '' }));
      $wrap.find('.uk-mosque-image-remove').prop('disabled', false);
    });

    frame.open();
  });

  $(document).on('click', '.uk-mosque-image-remove', function (e) {
    e.preventDefault();
    var $wrap = $(this).closest('.uk-mosque-image-field');
    $wrap.find('input[type="hidden"]').val('');
    $wrap.find('.uk-mosque-image-field__preview').empty();
    $(this).prop('disabled', true);
  });
});
```

Enqueue it **only on your own screens** — never load `wp_enqueue_media()` site-wide:

```php
function uk_mosque_options_admin_assets($hook)
{
    if (strpos($hook, 'uk-mosque-') === false && strpos($hook, 'uk-mosque-options') === false) {
        return;
    }

    wp_enqueue_media();

    wp_enqueue_style(
        'uk-mosque-options',
        get_template_directory_uri() . '/assets/css/admin/options.css',
        array(),
        wp_get_theme()->get('Version')
    );

    wp_enqueue_script(
        'uk-mosque-options',
        get_template_directory_uri() . '/assets/js/admin/options.js',
        array('jquery'),
        wp_get_theme()->get('Version'),
        true
    );
}
add_action('admin_enqueue_scripts', 'uk_mosque_options_admin_assets');
```

### Step 2.7 — `assets/css/admin/options.css`

```css
.uk-mosque-panel {
  background: #fff;
  border: 1px solid #c3c4c7;
  border-radius: 4px;
  margin: 20px 0;
  padding: 0 20px 10px;
}
.uk-mosque-panel__title {
  border-bottom: 1px solid #f0f0f1;
  font-size: 15px;
  margin: 0 -20px 10px;
  padding: 14px 20px;
}
.uk-mosque-image-field__preview img {
  border: 1px solid #dcdcde;
  display: block;
  height: auto;
  margin-bottom: 8px;
  max-width: 220px;
}
```

### Step 2.8 — The read helper

Add to `inc/helpers.php` (create it if you have not yet — see
[development.md](development.md) Step 1a):

```php
/**
 * Read one value from a page's option array, falling back to the declared default.
 *
 * @param string $page Page slug, e.g. 'home'.
 * @param string $key  Field key, e.g. 'hero_title'.
 */
function uk_mosque_opt($page, $key, $fallback = '')
{
    static $cache = array();

    if (!isset($cache[$page])) {
        $def              = uk_mosque_get_option_page($page);
        $cache[$page]     = get_option($def['option'] ?? 'uk_mosque_' . $page . '_options', array());
        $cache[$page . '_defaults'] = uk_mosque_option_defaults($page);
    }

    $vals     = $cache[$page];
    $defaults = $cache[$page . '_defaults'];

    if (isset($vals[$key]) && $vals[$key] !== '') {
        return $vals[$key];
    }

    if (isset($defaults[$key]) && $defaults[$key] !== '') {
        return $defaults[$key];
    }

    return $fallback;
}

/**
 * Flatten a page's field definitions into key => default.
 */
function uk_mosque_option_defaults($page_slug)
{
    $page = uk_mosque_get_option_page($page_slug);
    $out  = array();

    if (!$page) {
        return $out;
    }

    foreach ($page['sections'] as $section) {
        foreach ($section['fields'] as $key => $field) {
            $out[$key] = $field['default'] ?? '';
        }
    }

    return $out;
}

/** Shorthand for the Home page. */
function uk_mosque_home($key, $fallback = '')
{
    return uk_mosque_opt('home', $key, $fallback);
}

/** Is a Home section switched on? */
function uk_mosque_home_on($key)
{
    return (bool) uk_mosque_home($key . '_enable', 1);
}

/**
 * Echo an image from a stored attachment ID, falling back to a bundled theme asset.
 */
function uk_mosque_option_image($attachment_id, $fallback_path, $size = 'full', $attr = array())
{
    $attachment_id = absint($attachment_id);

    if ($attachment_id && wp_get_attachment_image($attachment_id, $size)) {
        echo wp_get_attachment_image($attachment_id, $size, false, $attr);
        return;
    }

    printf(
        '<img src="%s" alt="%s">',
        esc_url(get_template_directory_uri() . '/assets/images/' . ltrim($fallback_path, '/')),
        esc_attr($attr['alt'] ?? '')
    );
}
```

> The default fallback matters: the client will not fill in 60 fields on day one. Every field
> declares the text currently hardcoded in the template, so the site looks identical the moment
> you switch over and gets better as they edit.

### Step 2.9 — Wire it up in `functions.php`

```php
require_once get_template_directory() . '/inc/helpers.php';
require_once get_template_directory() . '/inc/admin/options-home.php';       // defines the field arrays
require_once get_template_directory() . '/inc/admin/options-framework.php';  // consumes them
```

Order matters: `options-framework.php` calls `uk_mosque_home_sections()`, so load the
definitions first.

**Checkpoint:** reload wp-admin. You should see **Theme Options → Home Page** with empty
panels (no fields yet). Fix any fatals before moving on.

---

## Part 3 — Define the Home Page fields

`inc/admin/options-home.php`. This is long but entirely mechanical — it is one array.
Here are the first two sections in full so you have the shape, then a table for the rest.

```php
<?php
if (!defined('ABSPATH')) { exit; }

function uk_mosque_home_sections()
{
    return array(

        /* ---------------------------------------------------------- 1. Hero */
        'hero' => array(
            'title'  => __('1. Hero Banner', 'uk-mosque'),
            'fields' => array(
                'hero_enable' => array(
                    'type'           => 'checkbox',
                    'label'          => __('Section', 'uk-mosque'),
                    'checkbox_label' => __('Show this section', 'uk-mosque'),
                    'default'        => 1,
                ),
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

        /* --------------------------------------------------------- 2. About */
        'about' => array(
            'title'  => __('2. About', 'uk-mosque'),
            'fields' => array(
                'about_enable' => array(
                    'type'           => 'checkbox',
                    'label'          => __('Section', 'uk-mosque'),
                    'checkbox_label' => __('Show this section', 'uk-mosque'),
                    'default'        => 1,
                ),
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
                    'default' => 'Established in 1996, Islamus is dedicated to nurturing faith, knowledge, and unity within our community.',
                ),
                'about_image1' => array('type' => 'image', 'label' => __('Image 1', 'uk-mosque')),
                'about_image2' => array('type' => 'image', 'label' => __('Image 2', 'uk-mosque')),
                'about_tab1_label' => array(
                    'type'    => 'text',
                    'label'   => __('Tab 1 label', 'uk-mosque'),
                    'default' => 'Our Mission',
                ),
                'about_tab1_text' => array(
                    'type'  => 'textarea',
                    'label' => __('Tab 1 text', 'uk-mosque'),
                    'rows'  => 4,
                ),
                'about_tab2_label' => array(
                    'type'    => 'text',
                    'label'   => __('Tab 2 label', 'uk-mosque'),
                    'default' => 'Our Vision',
                ),
                'about_tab2_text' => array(
                    'type'  => 'textarea',
                    'label' => __('Tab 2 text', 'uk-mosque'),
                    'rows'  => 4,
                ),
                'about_btn_text' => array(
                    'type'    => 'text',
                    'label'   => __('Button text', 'uk-mosque'),
                    'default' => 'Discover More',
                ),
                'about_btn_url' => array('type' => 'url', 'label' => __('Button link', 'uk-mosque')),
            ),
        ),

        // … sections 3–13 follow the same shape — see the table below.

    );
}
```

### Sections 3–13 — field list

Build each of these as another entry in the array above. Every section starts with its
`*_enable` checkbox (default `1`).

| Section              | Key prefix    | Fields (key → type)                                                                                                                                       |
| -------------------- | ------------- | --------------------------------------------------------------------------------------------------------------------------------------------------------- |
| **3. Causes**        | `causes_`     | `subtitle` text · `title` richtext · `count` number (1–12, default 3) · `orderby` select {date, title, menu_order}                                        |
| **4. Prayer Times**  | `prayer_`     | `subtitle` text · `title` richtext · `text` textarea — _the times themselves live on the Prayer Times screen_                                             |
| **5. Services**      | `services_`   | `subtitle` text · `title` richtext · `side_text` textarea · `count` number (default 4)                                                                    |
| **6. Events**        | `events_`     | `subtitle` text · `title` richtext · `text` textarea · `count` number (default 3) · `btn_text` text (default "Join Now") · `btn_url` url                  |
| **7. Marquee**       | `marquee_`    | `items` textarea — _one phrase per line_ · `repeat` number (default 6)                                                                                    |
| **8. Team**          | `team_`       | `subtitle` text · `title` richtext · `count` number (default 4)                                                                                           |
| **9. Donation CTA**  | `donate_`     | `subtitle` text · `title` richtext · `text` textarea · `image` image · `form_title` text · `amounts` text (comma-separated, default `50,60,70,80,90,100`) |
| **10. FAQ**          | `faq_`        | `subtitle` text · `title` richtext · `count` number (default 6)                                                                                           |
| **11. Testimonials** | `testi_`      | `subtitle` text · `title` richtext · `count` number (default 6)                                                                                           |
| **12. Blog**         | `blog_`       | `subtitle` text · `title` richtext · `count` number (default 4)                                                                                           |
| **13. Contact**      | `contactsec_` | `subtitle` text · `title` richtext · `map_image` image · `bg_image` image                                                                                 |

> **Why `contactsec_` and not `contact_`:** you will add a Contact Page screen later with its
> own `contact_*` keys. Distinct prefixes stop the two screens colliding if you ever merge
> option arrays.

**Checkpoint:** save the Home Page screen with some test values, then run
`get_option('uk_mosque_home_options')` in a debug snippet and confirm the array looks right.

---

## Part 4 — Convert the template, section by section

**Rules for this part:**

1. One section per commit. Convert, reload `/`, confirm it looks identical, commit, next.
2. Every section gets wrapped in its enable check.
3. Every repeating block becomes a `template-parts/` partial, so Home and the archives share it.
4. Every loop needs an `else:` branch — the client will have zero events at some point.

### The wrapper pattern

Every section becomes:

```php
<?php if (uk_mosque_home_on('hero')) : ?>
<section class="banner-section">
    …
</section>
<?php endif; ?>
```

### The heading pattern

Replace this, which appears 12 times:

```php
<span class="sub-title tz-sub-tilte tz-sub-anim tx-subTitle">Make a Donation</span>
<div class="h2 title tm-itm-title tm-itm-anim">Empowering Lives Through Islamic Charity</div>
```

with:

```php
<span class="sub-title tz-sub-tilte tz-sub-anim tx-subTitle">
    <?php echo esc_html(uk_mosque_home('causes_subtitle')); ?>
</span>
<div class="h2 title tm-itm-title tm-itm-anim">
    <?php echo wp_kses(uk_mosque_home('causes_title'), uk_mosque_allowed_title_html()); ?>
</div>
```

`esc_html` for the sub-title (plain text), `wp_kses` for the heading (may contain `<br>`).

---

### 4.1 — Hero banner (lines 20–72)

```php
<?php if (uk_mosque_home_on('hero')) : ?>
<section class="banner-section">
    <div class="outer-box">
        <div class="leaf">
            <img class="animation__arryUpDown"
                 src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/shape/banner-leaf.png'); ?>" alt="">
        </div>
        <div class="inner-box">
            <div class="row g-5 align-items-end">
                <div class="col-xl-8">
                    <div class="banner-content">
                        <span class="sub-title wow fadeInUp" data-wow-delay=".3s">
                            <?php echo esc_html(uk_mosque_home('hero_subtitle')); ?>
                        </span>
                        <div class="h1 title wa_title_spilt_1">
                            <?php echo wp_kses(uk_mosque_home('hero_title'), uk_mosque_allowed_title_html()); ?>
                        </div>

                        <div class="btn-box mt-30 wow fadeInUp" data-wow-delay=".5s">
                            <?php if (uk_mosque_home('hero_btn1_text')) : ?>
                                <a class="theme-btn btn-style-one mr-10 mb-2 mb-sm-0"
                                   href="<?php echo esc_url(uk_mosque_home('hero_btn1_url', home_url('/'))); ?>">
                                    <span class="btn-arrow-left"><i class="fal fa-arrow-right"></i></span>
                                    <span class="btn-title"><?php echo esc_html(uk_mosque_home('hero_btn1_text')); ?></span>
                                    <span class="btn-arrow-right"><i class="fal fa-arrow-right"></i></span>
                                </a>
                            <?php endif; ?>

                            <?php if (uk_mosque_home('hero_btn2_text')) : ?>
                                <a class="theme-btn btn-style-two"
                                   href="<?php echo esc_url(uk_mosque_home('hero_btn2_url', home_url('/'))); ?>">
                                    <span class="btn-arrow-left"><i class="fa-solid fa-play"></i></span>
                                    <span class="btn-title"><?php echo esc_html(uk_mosque_home('hero_btn2_text')); ?></span>
                                    <span class="btn-arrow-right"><i class="fa-solid fa-play"></i></span>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="banner-image bounce-y">
                        <figure class="image overlay-anim">
                            <?php uk_mosque_option_image(uk_mosque_home('hero_image'), 'banner/banner-image.jpg', 'large'); ?>
                        </figure>
                        <div class="image-bg">
                            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/shape/banner-image-bg.png'); ?>" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="sec-bg ripple-image ripples z-0">
            <?php uk_mosque_option_image(uk_mosque_home('hero_bg'), 'banner/banner-bg.jpg', 'full'); ?>
        </div>
        <div class="shape1">
            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/shape/banner-shape1.png'); ?>" alt="">
        </div>
        <div class="shape2">
            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/shape/banner-shape2.png'); ?>" alt="">
        </div>
    </div>
</section>
<?php endif; ?>
```

Decorative shapes (leaf, shape1, shape2) stay hardcoded — they are part of the design, not
content. Do not make everything editable; you will regret it.

---

### 4.2 — About (lines 75–189)

Same pattern. Two tabs → `about_tab1_*` / `about_tab2_*`. The tab **labels** are editable, the
Bootstrap `data-bs-target="#mission"` / `#vision` IDs stay hardcoded — they are wiring, not copy.

Fix while you are here: the two `href="page-about.html"` links at lines 33 and 39 →
`esc_url(uk_mosque_home('about_btn_url'))`.

---

### 4.3 — Causes (lines 192–339) → `donation` CPT

The static card markup here is **identical** to the one already inlined in
[archive-donation.php](archive-donation.php) — both use `.causes-block`. So build the partial
once and both files use it.

**Step 1.** Create `template-parts/donation/donation-card.php`, moving the markup out of
`archive-donation.php` lines 92–150 (including the `$goal_amount` / `$raised_amount` /
`$progress` / `$donation_category` calculation block at lines 59–90).

**Step 2.** Replace the whole causes grid in `front-page.php` with:

```php
<?php if (uk_mosque_home_on('causes')) : ?>
<section class="our-causes pt-120">
    <div class="floating-img-1 bounce-y">
        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/icon/obj-img-1.png'); ?>" alt="">
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mx-auto">
                <div class="sec-title text-center mb-60">
                    <span class="sub-title tz-sub-tilte tz-sub-anim tx-subTitle">
                        <?php echo esc_html(uk_mosque_home('causes_subtitle')); ?>
                    </span>
                    <div class="h2 title tm-itm-title tm-itm-anim">
                        <?php echo wp_kses(uk_mosque_home('causes_title'), uk_mosque_allowed_title_html()); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <?php
            $causes = new WP_Query(array(
                'post_type'           => 'donation',
                'post_status'         => 'publish',
                'posts_per_page'      => (int) uk_mosque_home('causes_count', 3),
                'orderby'             => uk_mosque_home('causes_orderby', 'date'),
                'order'               => 'DESC',
                'ignore_sticky_posts' => true,
                'no_found_rows'       => true,
            ));

            if ($causes->have_posts()) :
                while ($causes->have_posts()) : $causes->the_post();
                    get_template_part('template-parts/donation/donation-card');
                endwhile;
                wp_reset_postdata();
            else : ?>
                <div class="col-12">
                    <p><?php esc_html_e('No causes have been added yet.', 'uk-mosque'); ?></p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php endif; ?>
```

**Also fix:** line 194 has `src="images/icon/obj-img-1.png"` with no theme URI — broken today.

> `'no_found_rows' => true` skips the `SQL_CALC_FOUND_ROWS` count. Use it on every homepage
> query — you are never paginating them.

---

### 4.4 — Prayer times (lines 341–495) → shared partial

Six blocks, each with a **different inline SVG icon**. Do not try to store SVGs in options.

**Step 1.** Save each SVG as its own file:

```
assets/images/icons/prayer/fajr.svg
assets/images/icons/prayer/dhuhr.svg
assets/images/icons/prayer/asr.svg
assets/images/icons/prayer/maghrib.svg
assets/images/icons/prayer/isha.svg
assets/images/icons/prayer/jummah.svg
```

**Step 2.** Add an inliner to `inc/helpers.php`:

```php
function uk_mosque_prayer_icon($key)
{
    $file = get_template_directory() . '/assets/images/icons/prayer/' . sanitize_key($key) . '.svg';

    if (!file_exists($file)) {
        return '';
    }

    return file_get_contents($file);
}
```

The SVGs are your own files, not user input, so echoing them raw is fine. Never do this with
an uploaded file.

**Step 3.** Create `template-parts/global/prayer-times.php`:

```php
<?php
$prayers = array(
    'fajr'    => __('Fajr', 'uk-mosque'),
    'dhuhr'   => __('Zuhr', 'uk-mosque'),
    'asr'     => __('Asr', 'uk-mosque'),
    'maghrib' => __('Magrib', 'uk-mosque'),
    'isha'    => __('Isha', 'uk-mosque'),
    'jummah'  => __('Jummah', 'uk-mosque'),
);

$i = 0;
foreach ($prayers as $key => $label) :
    $azan   = uk_mosque_opt('prayer', 'prayer_' . $key . '_azan');
    $iqamah = uk_mosque_opt('prayer', 'prayer_' . $key . '_iqamah');
    $delay  = array('.3s', '.5s', '.7s')[$i % 3];
    $col    = ('jummah' === $key) ? 'col-lg-5 col-md-6' : 'col-lg-4 col-md-6';
    $i++;
    ?>
    <div class="<?php echo esc_attr($col); ?> wow fadeInUp" data-wow-delay="<?php echo esc_attr($delay); ?>">
        <div class="time-block<?php echo ('jummah' === $key) ? ' mx-lg-auto' : ''; ?>">
            <div class="icon">
                <?php echo uk_mosque_prayer_icon($key); ?>
                <div class="h5 title"><?php echo esc_html($label); ?></div>
            </div>
            <div class="content">
                <div class="h6 title"><span><?php esc_html_e('Time', 'uk-mosque'); ?></span> <?php esc_html_e('Iqamah', 'uk-mosque'); ?></div>
                <div class="h6 title"><span><?php echo esc_html($azan); ?> </span> <?php echo esc_html($iqamah); ?></div>
            </div>
        </div>
    </div>
<?php endforeach; ?>
```

**Step 4.** In `front-page.php`, the whole `<div class="row justify-content-center">` becomes:

```php
<div class="row justify-content-center">
    <?php get_template_part('template-parts/global/prayer-times'); ?>
</div>
```

That is ~150 lines down to 3, and the same partial serves `page-about.php` and
`page-prayer-times.php`.

You will need the **Prayer Times** options screen for this. Add it to
`uk_mosque_option_pages()` with 12 text fields (`prayer_fajr_azan`, `prayer_fajr_iqamah`, …)
plus `prayer_sunrise` and `prayer_note`.

---

### 4.5 — Services (lines 499–643) → `service` CPT

Create `template-parts/service/service-card.php` from one `.service-block`. Map:

| Markup                                                    | Source                               |
| --------------------------------------------------------- | ------------------------------------ |
| `<figure class="image"><img …>`                           | `the_post_thumbnail('medium_large')` |
| `<div class="h4 title">Daily Prayers <br> & Jummah</div>` | `the_title()`                        |
| `<p class="text">…</p>`                                   | `the_excerpt()`                      |
| `<a href="page-service-details.html" class="btn-more">`   | `the_permalink()`                    |

The `image-bg`, `hover-bg` and `item-shape` images stay hardcoded.

**Also fix:** the 4th card (lines 616, 617, 628) has three `src="images/…"` paths missing the
theme URI. They break today.

---

### 4.6 — Events (lines 645–756) → `event` CPT

Create `template-parts/event/event-card.php`. The date badge needs splitting:

```php
$event_date = get_post_meta(get_the_ID(), '_event_date', true);
$month = $day = '';

if ($event_date) {
    $ts    = strtotime($event_date);
    $month = wp_date('M', $ts);
    $day   = wp_date('d', $ts);
}
?>
<div class="h4 tag"><?php echo esc_html($month); ?> <span><?php echo esc_html($day); ?></span></div>
```

Time line:

```php
$start = get_post_meta(get_the_ID(), '_event_start', true);
$end   = get_post_meta(get_the_ID(), '_event_end', true);
?>
<div class="h4 info-title">
    <span><?php esc_html_e('Time:', 'uk-mosque'); ?></span>
    <?php echo esc_html(trim($start . ($end ? ' - ' . $end : ''))); ?>
</div>
```

Use `uk_mosque_upcoming_events()` (see [development.md](development.md) Step 7) so only future
events show, ordered soonest first. Pass `uk_mosque_home('events_count', 3)` as the limit.

**Also refactor:** [archive-event.php](archive-event.php) has the same meta-extraction block
inlined at lines 66–110. Move it into the partial and have the archive use it too.

---

### 4.7 — Marquee (lines 758–793)

Six `.marquee-group` divs, each with three phrases. The repetition is what makes the animation
loop seamlessly, so it must stay — but the phrases should come from one place.

```php
<?php if (uk_mosque_home_on('marquee')) :
    $lines = array_filter(array_map('trim', explode("\n", uk_mosque_home('marquee_items'))));
    $repeat = max(1, (int) uk_mosque_home('marquee_repeat', 6));

    if ($lines) : ?>
    <section class="marquee-section">
        <div class="marquee anim-fade-move">
            <?php for ($g = 0; $g < $repeat; $g++) : ?>
                <div class="marquee-group">
                    <?php foreach ($lines as $line) : ?>
                        <div class="text"><?php echo esc_html($line); ?></div>
                    <?php endforeach; ?>
                </div>
            <?php endfor; ?>
        </div>
    </section>
    <?php endif;
endif; ?>
```

Default for `marquee_items`:

```
Ask the Imam
New to Islam
Donate Now
Arabic School
```

---

### 4.8 — Team (lines 797–911) → `team_member` CPT

Create `template-parts/team/team-card.php`.

| Markup                                              | Source                                                                    |
| --------------------------------------------------- | ------------------------------------------------------------------------- |
| `<img …team1-1.png>`                                | `the_post_thumbnail('medium')`                                            |
| `<a href="page-team-details.html">Omar Hawkins</a>` | `the_permalink()` + `the_title()`                                         |
| `<p class="sub-title">Islamic Speaker</p>`          | **`team_role` taxonomy** — `get_the_term_list()` or the first term's name |
| Facebook / X / Pinterest links                      | `_team_facebook`, `_team_twitter`, `_team_instagram`                      |

> The markup has a **Pinterest** icon but the metabox stores **Instagram**. Pick one: either
> change the icon to `fa-instagram`, or add a `_team_pinterest` field. Do not leave an
> Instagram URL behind a Pinterest icon.

Render social links conditionally, so an empty field does not leave a dead `#` icon:

```php
$socials = array(
    'facebook-f' => get_post_meta(get_the_ID(), '_team_facebook', true),
    'x-twitter'  => get_post_meta(get_the_ID(), '_team_twitter', true),
    'instagram'  => get_post_meta(get_the_ID(), '_team_instagram', true),
);
?>
<ul>
    <?php foreach ($socials as $icon => $url) : ?>
        <?php if ($url) : ?>
            <li>
                <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener">
                    <i class="fa-brands fa-<?php echo esc_attr($icon); ?>"></i>
                </a>
            </li>
        <?php endif; ?>
    <?php endforeach; ?>
</ul>
```

---

### 4.9 — Donation CTA (lines 911–986)

Text, heading and image come from `donate_*`. The amount buttons come from the
comma-separated `donate_amounts` field:

```php
$amounts = array_filter(array_map('trim', explode(',', uk_mosque_home('donate_amounts', '50,60,70,80,90,100'))));
$last    = end($amounts);
?>
<div class="donation-amounts mt-10">
    <?php foreach ($amounts as $amt) : ?>
        <button type="button"
                class="amount-btn<?php echo ($amt === $last) ? ' active' : ''; ?>"
                data-amount="<?php echo esc_attr($amt); ?>">
            <?php echo esc_html(uk_mosque_money($amt)); ?>
        </button>
    <?php endforeach; ?>
    <button type="button" class="amount-btn custom-btn"><?php esc_html_e('Custom', 'uk-mosque'); ?></button>
</div>
```

> **The form itself stays inert for now.** `#donationForm` has no `action` and no handler.
> Taking money needs a gateway decision — see [development.md](development.md) §B.3. Leave a
> clear `// TODO: payment gateway` comment above the form so it is not mistaken for finished.
> The buttons are currency-symbol-sensitive: the markup says `$`, `uk_mosque_money()` says `£`.
> Settle which currency the mosque uses before you ship this.

---

### 4.10 — FAQ (lines 988–1095) → `faq` CPT

Accordion. Title = question, content = answer. The `01`, `02`, `03` numbers and the
`active-block` / `current` classes on the second item are positional — generate them:

```php
$faqs = new WP_Query(array(
    'post_type'      => 'faq',
    'posts_per_page' => (int) uk_mosque_home('faq_count', 6),
    'orderby'        => 'menu_order date',
    'order'          => 'ASC',
    'no_found_rows'  => true,
));

if ($faqs->have_posts()) : $n = 0; ?>
    <ul class="accordion-box3">
        <?php while ($faqs->have_posts()) : $faqs->the_post();
            $n++;
            $open  = (1 === $n);                       // first item open by default
            $delay = ($n > 1) ? '.' . (($n - 1) * 2) . 's' : '';
            ?>
            <li class="accordion block wow fadeInUp<?php echo $open ? ' active-block' : ''; ?>"
                <?php if ($delay) : ?>data-wow-delay="<?php echo esc_attr($delay); ?>"<?php endif; ?>>
                <div class="acc-btn<?php echo $open ? ' active' : ''; ?>">
                    <span class="number"><?php echo esc_html(str_pad($n, 2, '0', STR_PAD_LEFT)); ?></span>
                    <?php the_title(); ?>
                    <i class="icon fas fa-plus"></i>
                </div>
                <div class="acc-content<?php echo $open ? ' current' : ''; ?>">
                    <div class="content">
                        <div class="text"><?php echo wp_kses_post(get_the_content()); ?></div>
                    </div>
                </div>
            </li>
        <?php endwhile; ?>
    </ul>
<?php wp_reset_postdata(); endif; ?>
```

> The static markup opens item **02**; opening item **01** is the sane default once the order
> is editable. Use `menu_order` so the client can drag-reorder FAQs with a plugin, or add
> `'supports' => array(..., 'page-attributes')` to the `faq` CPT to expose the Order box.

---

### 4.11 — Testimonials (lines 1095–1278) → `testimonial` CPT

Swiper slider. Keep `.swiper`, `.swiper-wrapper` and `.swiper-slide` exactly as they are —
[script.js](assets/js/script.js) initialises on those classes.

Rating stars from `_uk_mosque_testimonial_rating`:

```php
$rating = (int) get_post_meta(get_the_ID(), '_uk_mosque_testimonial_rating', true);
$rating = max(0, min(5, $rating ?: 5));
?>
<div class="rating-star">
    <?php for ($s = 1; $s <= 5; $s++) : ?>
        <i class="fa-<?php echo ($s <= $rating) ? 'solid' : 'regular'; ?> fa-star"></i>
    <?php endfor; ?>
</div>
```

Name = `the_title()`, designation = `_uk_mosque_testimonial_role`, photo = featured image,
quote = `the_content()` or `the_excerpt()`.

---

### 4.12 — Blog (lines 1278–1396) → core `post`

Create `template-parts/post/post-card.php` — this same partial also fixes
[home.php](home.php), which currently has six hardcoded copies of it.

| Markup                                                 | Source                                                                        |
| ------------------------------------------------------ | ----------------------------------------------------------------------------- |
| `<img …blog-1-1.jpg>` ×2                               | `the_post_thumbnail('medium_large')` twice (the duplicate is the hover state) |
| `<a href="news-details.html" class="tag">Madrasha</a>` | first category: `get_the_category()` + `get_category_link()`                  |
| `21 May, 2026`                                         | `get_the_date('j M, Y')`                                                      |
| `<a href="news-details.html">Renovation…</a>`          | `the_permalink()` + `the_title()`                                             |

Guard the category tag — a post with no category should not render an empty link.

---

### 4.13 — Contact (lines 1398–1495)

- Heading and sub-title → `contactsec_*`
- Map image → `contactsec_map_image`
- Background → `contactsec_bg_image`
- The three info blocks (phone / email / address) → **Customizer** values, not new fields:
  `get_theme_mod('mosque_phone')`, `mosque_email`, `mosque_address`. They already exist and are
  used in the header and footer; a second copy would drift.
- **Delete the `__cf_email__` link at line 1471** — it is the theme vendor's Cloudflare
  obfuscation pointing at _their_ domain. Replace with a real `mailto:`.
- The form has no `action` and no nonce. Point it at the contact handler from
  [development.md](development.md) Step 11a.

---

## Part 5 — Partials you will have created

By the end, `front-page.php` should be roughly 350 lines instead of 1498.

```
template-parts/
├── global/
│   ├── page-banner.php
│   └── prayer-times.php
├── donation/
│   ├── donation-card.php        ← also used by archive-donation.php + taxonomy template
│   ├── donation-meta.php
│   └── donation-progress.php
├── event/
│   └── event-card.php           ← also used by archive-event.php
├── service/
│   └── service-card.php
├── team/
│   └── team-card.php
├── testimonial/
│   └── testimonial-card.php
├── faq/
│   └── faq-item.php
└── post/
    └── post-card.php            ← also used by home.php + index.php
```

---

## Part 6 — Testing checklist

Run all of these before calling the front page done.

**Empty state**

- [ ] Trash every `donation`, `event`, `service`, `faq`, `testimonial`, `team_member` and post.
      Load `/`. No PHP notices, no empty grids with stray markup — each section shows its
      "nothing yet" message or hides itself.

**Toggles**

- [ ] Untick every **Show section** box. The page renders header + footer only, no fatals.
- [ ] Re-tick them one at a time and confirm each section returns.

**Content**

- [ ] Change every text field to something obviously different (`ZZZ hero title`) and confirm
      it appears. This catches fields you defined but never wired into the template.
- [ ] Upload an image to each image field; confirm it replaces the bundled fallback.
- [ ] Clear an image field; confirm the bundled fallback returns rather than a broken `<img>`.
- [ ] Put `Line one<br>Line two` in a heading field — it must render as two lines, not print
      the tag.
- [ ] Put `<script>alert(1)</script>` in a heading field, save, and confirm it is stripped.

**Counts and order**

- [ ] Set every `*_count` to 1, then to 12. Confirm the grid respects it.
- [ ] Publish more events than `events_count`; confirm only future ones show, soonest first.

**JavaScript**

- [ ] Testimonial Swiper still slides.
- [ ] Blog Swiper still slides.
- [ ] FAQ accordion still opens and closes.
- [ ] About mission/vision tabs still switch.
- [ ] Marquee still scrolls seamlessly.
- [ ] GSAP title-split animations still fire on the headings.

These break when markup is rearranged — check the browser console for errors, not just the
rendered page.

**Assets**

- [ ] Open DevTools → Network, filter to 404s. There should be none. Today there are five
      (`images/icon/obj-img-1.png`, three in the services section, one in `home.php`).

**Debug**

- [ ] `define('WP_DEBUG', true)` and reload. Zero notices.
- [ ] Query Monitor: the front page should be well under 30 queries.

---

## Part 7 — Pitfalls specific to this template

**GSAP and WOW depend on markup order.** Classes like `tm-itm-anim`, `wa_title_spilt_1`,
`oit-panel-pin` and `advance-item` are animation hooks read by
[custom-gsap.js](assets/js/custom-gsap.js). Keep them on the same elements. If a section stops
animating after conversion, you moved or dropped one of these classes.

**`data-wow-delay` is staggered per item.** The static markup hardcodes `.3s`, `.5s`, `.7s`
across the three or four items in a row. In a loop, generate it:

```php
$delays = array('.3s', '.5s', '.7s');
$delay  = $delays[$index % count($delays)];
```

Without this every card animates simultaneously and the effect is lost.

**Duplicate `<img>` tags are intentional.** Causes cards and blog cards each render the same
image twice — the second is the CSS hover state. Keep both.

**`the_excerpt()` echoes a wrapping `<p>`.** Where the design expects bare text inside
`<div class="text">`, use `wp_trim_words(get_the_excerpt(), 18)` instead.

**Never call `query_posts()`.** Use `new WP_Query()` and always follow with
`wp_reset_postdata()`. On `front-page.php` the main query is the "Home" page object — clobbering
it breaks `the_title()` everywhere downstream.

**Sanitize callback runs once per save, for the current page only.** If you ever add a second
form to one screen, `uk_mosque_sanitize_options()` will drop the fields it does not know about.
One form per screen.

---

## Part 8 — Suggested commit sequence

| Commit | Contains                                                                      |
| ------ | ----------------------------------------------------------------------------- |
| 1      | `inc/helpers.php` + Settings → Reading configured                             |
| 2      | Options framework (Part 2) — menu appears, no fields                          |
| 3      | Home field definitions (Part 3) — screen fully populated, template untouched  |
| 4      | Hero + About sections converted                                               |
| 5      | `donation-card.php` partial, used by both Home and `archive-donation.php`     |
| 6      | Prayer Times screen + `prayer-times.php` partial, used by all three templates |
| 7      | Services + Events sections + their partials                                   |
| 8      | Marquee + Team + Donation CTA                                                 |
| 9      | FAQ + Testimonials                                                            |
| 10     | Blog + Contact sections                                                       |
| 11     | Broken image paths + `.html` links + `__cf_email__` cleanup                   |
| 12     | Testing pass fixes                                                            |

Commit 3 is the natural demo point: the client can see and fill in the whole Home Page screen
before a single line of the template changes.
