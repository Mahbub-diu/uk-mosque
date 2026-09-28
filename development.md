# UK Mosque Theme — Remaining Development Guide

**Status as of 2026-09-24.** This document replaces the original spec (archived as
[development.old.md](development.old.md), still useful for its original field tables).
It covers only what is **left to build**, in the order to build it.

The original [guideline.md](guideline.md) checklist is now partly out of date — where the
two disagree, this file wins, because it was written against the actual code.

---

## Part A — Progress audit

### A.1 What is done

| Area | File | State |
| --- | --- | --- |
| Theme setup | `inc/setup.php` | title-tag, post-thumbnails, custom-logo, html5, `primary_menu` location |
| Asset loading | `inc/enqueue.php` | Bootstrap, style.css, jQuery, GSAP stack, Swiper, Fancybox, AOS, WOW, custom scripts |
| CPTs (all 7) | `inc/custom-post-type.php` | `event`, `donation`, `team_member`, `testimonial`, `service`, `faq`, `gallery_item` — all public, all with archives |
| Admin columns | `inc/custom-post-type.php` | Event + Donation list-table columns |
| Taxonomies | `inc/custom-taxonomy.php` | `donation_category`, `team_role` |
| Metaboxes (4) | `inc/custom-metabox.php` | Event, Donation, Team, Testimonial — with nonces and sanitised save handlers |
| Global options | `inc/customizer.php` | Contact info (address/phone/email) + 4 social URLs |
| Header | `header.php` | Custom logo, real nav menu, customizer contact + social. JS clones the menu into mobile + sticky nav |
| Footer | `footer.php` | Logo, social, address, phone, email all wired |
| Event front-end | `archive-event.php`, `single-event.php` | Real loops, real meta |
| Donation archive | `archive-donation.php` | Real loop, meta, category term, progress % calculation |

### A.2 Meta key reference (as actually implemented)

The keys in the code differ from the old spec. **These are the live keys — use them.**

| CPT | Meta key | Type |
| --- | --- | --- |
| `event` | `_event_date` | date |
| `event` | `_event_start` | time |
| `event` | `_event_end` | time |
| `event` | `_event_location` | text |
| `event` | `_event_topic` | text |
| `donation` | `_donation_goal_amount` | number |
| `donation` | `_donation_raised_amount` | number |
| `donation` | `_donation_start_date` | date |
| `donation` | `_donation_end_date` | date |
| `team_member` | `_team_facebook` / `_team_twitter` / `_team_instagram` | url |
| `testimonial` | `_uk_mosque_testimonial_role` | text |
| `testimonial` | `_uk_mosque_testimonial_rating` | number 1–5 |

Notes:

- Team **role** is a taxonomy (`team_role`), not a meta field — the old spec said meta.
- `_donation_hover_image` from the old spec was never built. Decide in Step 6 whether you want it.
- Testimonial keys use the `_uk_mosque_` prefix; everything else does not. **Leave them alone** —
  renaming now orphans existing post meta. Just be aware of the inconsistency.

### A.3 What is NOT done

| # | Gap | Severity |
| --- | --- | --- |
| 1 | `index.php` is a stub — and 5 CPT archives + 5 CPT singles fall through to it | Blocker |
| 2 | `single.php` is a stub | Blocker |
| 3 | `taxonomy-donation_category.php` is a **0-byte file** → blank white page | Blocker |
| 4 | `front-page.php` — 1498 lines, 100% static, 0 queries | Core |
| 5 | `single-donation.php` — 209 lines, 100% static | Core |
| 6 | `home.php` — static blog grid, no Loop | Core |
| 7 | Prayer times have no storage anywhere | Core |
| 8 | Contact form posts to an external vendor URL | Core |
| 9 | `page-about.php`, `page-prayer-times.php`, `contact.php` — static | Important |
| 10 | Newsletter form in footer is inert | Important |
| 11 | `template-parts/donation/*.php` — 3 empty files | Important |
| 12 | `inc/theme-options.php` — empty and never required | Important |
| 13 | No `inc/helpers.php`, `searchform.php`, `sidebar.php`, `comments.php` | Important |
| 14 | No pagination anywhere (`posts_per_page => -1` everywhere) | Important |
| 15 | Assorted broken links / typos (see Step 14) | Polish |

---

## Part B — Decisions to make before you write more code

### B.1 Customizer vs. Settings API — pick the Customizer

The old spec called for a Settings API screen in `inc/theme-options.php`. You instead built
`inc/customizer.php`, and it works. Running both means two places to look for one value.

**Recommendation: keep the Customizer, delete the empty `inc/theme-options.php`.** It gives
live preview for free, it is already wired, and every value this theme needs is a simple
scalar. Everything below assumes this.

If you would rather have the Settings API (better for 40+ fields on tabbed screens), do it now
and migrate the 7 existing `get_theme_mod()` calls — not after you have added 40 more.

### B.2 Read every option through one helper

Direct `get_theme_mod()` calls are already scattered across `header.php` and `footer.php`.
Add a wrapper in Step 1 so defaults live in one place and you can swap the storage layer later
without touching templates.

### B.3 Donation payments are out of scope for v1

`single-donation.php` will get a working display and a donate **button**. Actually taking
money needs a gateway decision (Stripe / GoCardless / a plugin like GiveWP). Flag this to the
client; do not build a half-gateway.

---

## Part C — Step-by-step build order

Work top to bottom. Each step is independently shippable.

---

### Step 1 — Foundation cleanup (Blocker)

**Goal:** no route on the site returns a stub or a blank page.

#### 1a. Create `inc/helpers.php`

```php
<?php
if (!defined('ABSPATH')) { exit; }

/**
 * Single read point for all theme options.
 */
function uk_mosque_get_option($key, $default = '')
{
    $value = get_theme_mod($key, $default);
    return ($value === '' || $value === false) ? $default : $value;
}

/**
 * Format a money value in one place.
 */
function uk_mosque_money($amount)
{
    return '£' . number_format((float) $amount, 0);
}

/**
 * Standard page-title / breadcrumb banner used by every inner page.
 *
 * @param string $title  Heading text.
 * @param array  $crumbs [ label => url ]  An empty url renders the label as plain text.
 */
function uk_mosque_page_banner($title, $crumbs = array())
{
    get_template_part('template-parts/global/page-banner', null, array(
        'title'  => $title,
        'crumbs' => $crumbs,
    ));
}
```

Then in `functions.php`, add **above** the other requires:

```php
require_once get_template_directory() . '/inc/helpers.php';
```

#### 1b. Delete `inc/theme-options.php`

It is empty and unreferenced — see B.1.

#### 1c. Build `template-parts/global/page-banner.php`

Lift the `<section class="page-title">` markup that is currently copy-pasted into
`archive-event.php`, `archive-donation.php`, `single-donation.php`, `home.php`,
`page-about.php` and `page-prayer-times.php`. One partial, six call sites deleted.

```php
<?php
$title  = $args['title'] ?? get_the_title();
$crumbs = $args['crumbs'] ?? array();
?>
<section class="page-title">
    <div class="ripple-image ripples z-0">
        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/bg/page-title.jpg'); ?>" alt="">
    </div>
    <div class="auto-container">
        <div class="title-outer text-center">
            <div class="h1 title"><?php echo esc_html($title); ?></div>
            <ul class="page-breadcrumb">
                <li><a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Home', 'uk-mosque'); ?></a></li>
                <?php foreach ($crumbs as $label => $url) : ?>
                    <li>
                        <?php if ($url) : ?>
                            <a href="<?php echo esc_url($url); ?>"><?php echo esc_html($label); ?></a>
                        <?php else : ?>
                            <?php echo esc_html($label); ?>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</section>
```

#### 1d. Build a real `index.php`

`index.php` is WordPress's universal fallback. Right now it prints `<h1> index.php page </h1>`,
which is what visitors see on `/team/`, `/services/`, `/faqs/`, `/gallery/`, `/testimonial/`,
and on any search results page. Make it a generic archive:

- `uk_mosque_page_banner()` with a context-aware title (`get_the_archive_title()` /
  `Search results for "…"` / site name)
- standard `if (have_posts()) : while (have_posts()) : the_post();`
- a simple card: featured image, title linked to permalink, date, excerpt
- `the_posts_pagination()` at the bottom
- an `else:` branch with a "nothing found" message and `get_search_form()`

#### 1e. Build a real `single.php`

- banner with the post title
- featured image, `the_content()`, `wp_link_pages()`
- post meta (date, author, categories, tags)
- `the_post_navigation()`
- `comments_template()` guarded by `if (comments_open() || get_comments_number())`

#### 1f. Fill `taxonomy-donation_category.php`

Currently 0 bytes — WordPress loads it and outputs nothing. Either delete the file (so the
`archive.php` → `index.php` fallback runs) **or** fill it. Filling it is better; it reuses the
donation card you build in Step 5:

```php
<?php
if (!defined('ABSPATH')) { exit; }
get_header();

$term = get_queried_object();
uk_mosque_page_banner(
    $term->name,
    array(
        __('Causes', 'uk-mosque') => get_post_type_archive_link('donation'),
        $term->name               => '',
    )
);
?>
<section class="our-causes pt-120 pb-90">
    <div class="container">
        <div class="row">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <?php get_template_part('template-parts/donation/donation-card'); ?>
            <?php endwhile; else : ?>
                <p><?php esc_html_e('No causes in this category yet.', 'uk-mosque'); ?></p>
            <?php endif; ?>
        </div>
        <?php the_posts_pagination(); ?>
    </div>
</section>
<?php get_footer();
```

#### 1g. Add `searchform.php`

`index.php`, `404.php` and the sidebar all need it. Small file, unblocks three others.

**Exit criteria:** visit `/`, `/events/`, `/causes/`, `/team/`, `/services/`, `/faqs/`,
`/gallery/`, `/testimonial/`, `/?s=test`, and any single post — none show a stub heading or a
blank page.

---

### Step 2 — Decide the fate of the 5 orphan CPT archives (Blocker)

`team_member`, `testimonial`, `service`, `faq` and `gallery_item` are all registered
`'public' => true, 'has_archive' => true`. That creates 10 public URLs (5 archives + 5 single
templates) that nothing links to and that you have no designs for.

Two valid answers — pick per CPT, do not leave it ambiguous:

| CPT | Recommendation | Why |
| --- | --- | --- |
| `gallery_item` | **Keep archive** → build `archive-gallery_item.php` | It is the gallery page (Step 9) |
| `service` | **Keep archive + single** | The design has "Service Details" pages (`page-service-details.html` in the static markup) |
| `team_member` | **Keep archive + single** | The design has `page-team-details.html` |
| `testimonial` | **Turn off:** `'public' => false, 'publicly_queryable' => false, 'has_archive' => false, 'show_ui' => true` | Testimonials only ever appear embedded in other pages |
| `faq` | **Turn off** (same flags) | FAQs only appear as accordions inside Home + About |

After changing any `public` / `has_archive` / `rewrite` value, **visit Settings → Permalinks**
once to flush rewrite rules. Nothing works until you do.

For the CPTs you keep public, the `index.php` from Step 1 is an acceptable v1 archive. Build
dedicated templates only where the design calls for it.

---

### Step 3 — Expand the Customizer (Core)

Add these sections to `inc/customizer.php`, following the pattern already there.
Register a `sanitize_callback` on **every** setting — a missing one is a security hole.

#### 3a. Panel restructure

You will be past 40 settings. Group them:

```php
$wp_customize->add_panel('uk_mosque_theme_options', array(
    'title'    => __('Theme Options', 'uk-mosque'),
    'priority' => 25,
));
```

…then add `'panel' => 'uk_mosque_theme_options'` to each `add_section()` call, including the
two existing ones.

#### 3b. New sections and fields

| Section | Setting | Control | Sanitize |
| --- | --- | --- | --- |
| **Prayer Times** | `prayer_fajr_azan`, `prayer_fajr_iqamah` | text | `sanitize_text_field` |
| | …repeat for `dhuhr`, `asr`, `maghrib`, `isha`, `jummah` | text | `sanitize_text_field` |
| | `prayer_sunrise` | text | `sanitize_text_field` |
| | `prayer_note` | textarea | `sanitize_textarea_field` |
| **Home Page** | `home_hero_subtitle`, `home_hero_title`, `home_hero_text` | text/textarea | text/textarea |
| | `home_hero_btn_text`, `home_hero_btn_url` | text / url | text / `esc_url_raw` |
| | `home_about_subtitle`, `home_about_title`, `home_about_text` | text/textarea | |
| | `home_causes_subtitle`, `home_causes_title` | text | |
| | `home_services_subtitle`, `home_services_title` | text | |
| | `home_events_subtitle`, `home_events_title` | text | |
| | `home_team_subtitle`, `home_team_title` | text | |
| | `home_faq_subtitle`, `home_faq_title` | text | |
| | `home_testimonial_subtitle`, `home_testimonial_title` | text | |
| | `home_blog_subtitle`, `home_blog_title` | text | |
| | `home_counter_1_number` … `_4_number` / `_label` | number / text | `absint` / text |
| **About Page** | `about_intro_title`, `about_intro_text` | text/textarea | |
| | `about_mission_title`, `about_mission_text` | text/textarea | |
| | `about_vision_title`, `about_vision_text` | text/textarea | |
| **Contact Page** | `contact_form_recipient` | email | `sanitize_email` |
| | `contact_map_embed` | textarea | see note below |
| | `contact_opening_hours` | textarea | `sanitize_textarea_field` |
| **Footer** | `footer_copyright` | text | `sanitize_text_field` |
| | `footer_newsletter_title`, `footer_newsletter_text` | text/textarea | |
| **Social** (existing) | add `mosque_whatsapp`, `mosque_tiktok` | url | `esc_url_raw` |

> **Map embed note:** `wp_kses_post` strips `<iframe>`. Either store just the place name or
> lat/long and build the iframe yourself in the template (safest, recommended), or write a
> custom sanitizer that whitelists a Google-Maps-only iframe. Do not use a raw passthrough.

#### 3c. Register nav menu locations

In `inc/setup.php`, extend `register_nav_menus()`:

```php
register_nav_menus(array(
    'primary_menu' => __('Primary Menu', 'uk-mosque'),
    'footer_menu'  => __('Footer Quick Links', 'uk-mosque'),
));
```

The mobile and sticky menus are cloned from the primary menu by
[script.js:113-117](assets/js/script.js#L113-L117) — they need no separate location.

---

### Step 4 — Prayer times partial (Core)

Three templates render the same prayer table: `front-page.php` (Time Section, around line 342),
`page-about.php`, and `page-prayer-times.php`. Build it once.

1. Create `template-parts/global/prayer-times.php`.
2. Copy the markup from `front-page.php` lines ~342–495.
3. Replace every hardcoded time with `uk_mosque_get_option('prayer_fajr_azan')` and friends.
4. Loop over a `$prayers` array rather than repeating the block six times:

```php
$prayers = array(
    'fajr'    => __('Fajr', 'uk-mosque'),
    'dhuhr'   => __('Dhuhr', 'uk-mosque'),
    'asr'     => __('Asr', 'uk-mosque'),
    'maghrib' => __('Maghrib', 'uk-mosque'),
    'isha'    => __('Isha', 'uk-mosque'),
    'jummah'  => __('Jummah', 'uk-mosque'),
);

foreach ($prayers as $key => $label) {
    $azan   = uk_mosque_get_option("prayer_{$key}_azan");
    $iqamah = uk_mosque_get_option("prayer_{$key}_iqamah");
    // render one row
}
```

5. Replace the block in all three templates with
   `get_template_part('template-parts/global/prayer-times');`

---

### Step 5 — Donation front-end, finished (Core)

#### 5a. Fill the three empty partials

`template-parts/donation/donation-progress.php` — expects `$args['goal']` and `$args['raised']`:

```php
<?php
$goal   = (float) ($args['goal'] ?? 0);
$raised = (float) ($args['raised'] ?? 0);
$pct    = $goal > 0 ? min(100, round(($raised / $goal) * 100)) : 0;
?>
<div class="progress-box">
    <div class="bar"><div class="bar-inner" style="width: <?php echo esc_attr($pct); ?>%"></div></div>
    <div class="progress-meta">
        <span class="raised"><?php echo esc_html(uk_mosque_money($raised)); ?></span>
        <span class="goal"><?php echo esc_html(uk_mosque_money($goal)); ?></span>
    </div>
</div>
```

`donation-meta.php` — renders the category term, start/end dates, and days remaining.

`donation-card.php` — the grid card. Move the markup currently inlined in
`archive-donation.php` lines ~90–140 into here, then have the archive call
`get_template_part('template-parts/donation/donation-card')` inside its loop.

#### 5b. Rewrite `single-donation.php`

It is currently static markup with a fake sidebar of `page-service-details.html` links.
Replace with:

- `while (have_posts()) : the_post();`
- banner: `the_title()`, crumbs Home → Causes → title
- featured image, `the_content()`
- progress partial + meta partial using the real `_donation_goal_amount` /
  `_donation_raised_amount`
- sidebar: a real `wp_list_categories(array('taxonomy' => 'donation_category'))`, plus an
  "Other causes" `WP_Query` (3 posts, `post__not_in` the current one)
- a **Donate** button pointing at a `#` placeholder with a clear TODO comment referencing
  decision B.3

#### 5c. Add pagination to the archives

In `archive-donation.php`, change `'posts_per_page' => -1` to `9`, add
`'paged' => max(1, get_query_var('paged'))`, and call `paginate_links()` after the loop.
Better still: drop the custom `WP_Query` entirely and use the main loop, since it is an
archive template. Same for `archive-event.php`.

---

### Step 6 — Donation metabox gaps (Important)

- Add a **hover image** field (`_donation_hover_image`) if the design's card hover swap is
  wanted. Needs `wp_enqueue_media()` on the donation edit screen plus a small uploader script.
  If you would rather not, delete the requirement from the old spec so it stops resurfacing.
- Consider making `_donation_raised_amount` read-only / automatic once a gateway exists (B.3).

---

### Step 7 — Home page (Core)

This is the biggest single job: `front-page.php` is **1498 lines of static markup with zero
queries**. Do it section by section, testing after each — do not attempt it in one pass.

| Order | Section | Line (approx) | Wire to |
| --- | --- | --- | --- |
| 1 | Banner | 21–72 | Customizer `home_hero_*` |
| 2 | About | 76–189 | Customizer `home_about_*` + counters |
| 3 | Causes | 193–339 | `WP_Query` on `donation`, 3 posts → `donation-card.php` |
| 4 | Time | 342–495 | `template-parts/global/prayer-times.php` (Step 4) |
| 5 | Service | 500–643 | `WP_Query` on `service`, 4 posts |
| 6 | Event | 646–756 | `WP_Query` on `event`, 3 upcoming (see below) |
| 7 | Team | 798–911 | `WP_Query` on `team_member`, 4 posts + `team_role` term + socials |
| 8 | Donation CTA | 912–986 | Customizer text + link to `/causes/` |
| 9 | FAQ | 989–1095 | `WP_Query` on `faq` → accordion, title = question, content = answer |
| 10 | Testimonial | 1096–1278 | `WP_Query` on `testimonial` + role + rating stars |
| 11 | Blog | 1279–1396 | `WP_Query` on `post`, 3 latest |
| 12 | Contact | 1399–1495 | Customizer contact fields + the Step 11 form |

**Upcoming-events query** — reuse it in the events archive too, so put it in `inc/helpers.php`:

```php
function uk_mosque_upcoming_events($limit = 3)
{
    return new WP_Query(array(
        'post_type'      => 'event',
        'posts_per_page' => $limit,
        'meta_key'       => '_event_date',
        'orderby'        => 'meta_value',
        'order'          => 'ASC',
        'meta_query'     => array(
            array(
                'key'     => '_event_date',
                'value'   => current_time('Y-m-d'),
                'compare' => '>=',
                'type'    => 'DATE',
            ),
        ),
    ));
}
```

**Also fix while you are in there:**

- Lines 194, 616, 617, 628 — `src="images/…"` with no `get_template_directory_uri()`. Broken
  on every page load.
- 31 `*.html` links (`page-about.html`, `page-service-details.html`, `page-team-details.html`,
  `page-event-details.html`, `page-contact.html`) → `get_permalink()` / `home_url()`.
- The `__cf_email__` Cloudflare-obfuscated email span — replace with a real `mailto:`.

**Build one card partial per CPT** as you go, so Home and the archives share markup:
`template-parts/event/event-card.php`, `service/service-card.php`, `team/team-card.php`,
`testimonial/testimonial-card.php`, `faq/faq-item.php`, `post/post-card.php`.

---

### Step 8 — Blog index (`home.php`) (Core)

Currently six hardcoded cards. Replace with:

- `uk_mosque_page_banner()` — this also fixes the broken `src="images/bg/page-title.jpg"` on
  [home.php:19](home.php#L19) and the `esc_html(home_url())` inside an `href` on
  [home.php:25](home.php#L25), which should be `esc_url()`
- the main Loop → `template-parts/post/post-card.php` (built in Step 7)
- a real category tag (`get_the_category()`), real date (`get_the_date()`) and real permalink —
  the 12 `news-details.html` links all go
- `the_posts_pagination()`
- an empty state

---

### Step 9 — Gallery (Important)

1. Rename the template header: `Template Name: Gallary` → `Gallery` in
   [gallery.php:4](gallery.php#L4).
2. Build the grid: `WP_Query` on `gallery_item`, featured image, Fancybox lightbox
   (`data-fancybox="gallery"` plus an `href` to the full-size image URL — the library is
   already enqueued).
3. Consider `archive-gallery_item.php` as a thin wrapper that reuses the same partial, so
   `/gallery/` and the page template both work.
4. Optional: add a `gallery_category` taxonomy plus MixItUp filter buttons (`mixitup.js` is
   already enqueued). Skip for v1 unless the client asks.

---

### Step 10 — About, Prayer Times and Contact pages (Important)

**`page-about.php`** — wire intro / mission / vision / counters to the Customizer; swap the
static services and FAQ blocks for the Step 7 partials; fix the `page-about.html` link at
[page-about.php:100](page-about.php#L100) and the four `page-service-details.html` links.

**`page-prayer-times.php`** — three fixes plus one swap:

- The heading says **"About"** — it should say "Prayer Times"
- The breadcrumb says **"About"** and links `href="#"` — it should be the page title and `home_url()`
- Replace the static table with `get_template_part('template-parts/global/prayer-times')`
- Easiest fix for the first two: just call `uk_mosque_page_banner(get_the_title())`

**`contact.php`**

- Typo: **"Conatct"** → "Contact" at [contact.php:25](contact.php#L25) and
  [contact.php:28](contact.php#L28)
- The form `action` points at `https://html.kodesolution.com/.../sendmail.php` — the theme
  vendor's demo server. Every submission currently goes to a third party. **Fix in Step 11.**
- Replace the `__cf_email__` span with a real `mailto:` from
  `uk_mosque_get_option('mosque_email')`
- Wire the map to `contact_map_embed`

---

### Step 11 — Forms (Core)

#### 11a. Contact form handler

New file `inc/form-handlers.php`, required from `functions.php`.

```php
add_action('admin_post_nopriv_uk_mosque_contact', 'uk_mosque_handle_contact');
add_action('admin_post_uk_mosque_contact', 'uk_mosque_handle_contact');

function uk_mosque_handle_contact()
{
    check_admin_referer('uk_mosque_contact', 'uk_mosque_contact_nonce');

    // Honeypot — bots fill hidden fields, humans do not.
    if (!empty($_POST['form_botcheck'])) {
        wp_safe_redirect(add_query_arg('contact', 'sent', wp_get_referer()));
        exit;
    }

    $name    = sanitize_text_field($_POST['form_name'] ?? '');
    $email   = sanitize_email($_POST['form_email'] ?? '');
    $subject = sanitize_text_field($_POST['form_subject'] ?? '');
    $message = sanitize_textarea_field($_POST['form_message'] ?? '');

    if (!$name || !is_email($email) || !$message) {
        wp_safe_redirect(add_query_arg('contact', 'invalid', wp_get_referer()));
        exit;
    }

    $to = uk_mosque_get_option('contact_form_recipient', get_option('admin_email'));

    $ok = wp_mail(
        $to,
        sprintf('[%s] %s', get_bloginfo('name'), $subject ?: __('Website enquiry', 'uk-mosque')),
        $message,
        array(
            'Content-Type: text/plain; charset=UTF-8',
            'Reply-To: ' . $name . ' <' . $email . '>',
        )
    );

    wp_safe_redirect(add_query_arg('contact', $ok ? 'sent' : 'error', wp_get_referer()));
    exit;
}
```

In `contact.php`, change the form to:

```php
<form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
    <input type="hidden" name="action" value="uk_mosque_contact">
    <?php wp_nonce_field('uk_mosque_contact', 'uk_mosque_contact_nonce'); ?>
    <!-- existing fields -->
</form>
```

…and render a success/error notice from `$_GET['contact']` above the form.

> **Deliverability:** `wp_mail()` on a Laragon or shared host usually lands in spam or fails
> silently. Before launch, install an SMTP plugin (WP Mail SMTP, Post SMTP) or the client's
> transactional provider. Test with a real inbox, not just "no PHP error".

#### 11b. Newsletter form

[footer.php:44-62](footer.php#L44-L62) — the input has no `name`, no `<form>`, no action.
Three options; pick one and do it properly:

1. Route it through the same handler with a `type=newsletter` flag and email the admin.
2. Point it at Mailchimp's or Brevo's hosted form endpoint.
3. Remove the block until the client picks an ESP.

Leaving a form that silently does nothing is the one option that is not acceptable.

#### 11c. Donation form

See B.3. Out of scope for v1.

---

### Step 12 — Comments and sidebar (Important)

- `comments.php` — needed by `single.php`. Alternatively disable comments theme-wide if the
  mosque does not want them (drop `comments` from `supports`, plus a `comments_open` filter).
- `sidebar.php` plus `register_sidebar()` in `inc/setup.php` — only if the blog design has one.
  Check the static HTML before building it.

---

### Step 13 — Performance and housekeeping (Polish)

- **`three.js` is 1.8 MB and loads on every page.** It is only used by `distortion-img.js`.
  Conditionally enqueue it, or drop the effect. This is the single biggest win on the site.
- Same for `jquery-ui.js` (520 KB) and `jquery.fancybox.js` (154 KB) — load Fancybox only on
  the gallery, jQuery UI only where a datepicker actually runs.
- Use WordPress's bundled jQuery (`wp_enqueue_script('jquery')`) instead of shipping your own,
  or at minimum register yours under the `jquery` handle so dependencies resolve. Note that
  `theme-script` declares `array('jquery')` as a dependency while the theme enqueues its copy
  under the handle `enq-jquery` — so core jQuery loads **as well**. Two jQueries on every page.
- Delete `assets/css/style.css.backup-20260825-133007` (it is untracked; git is the backup).
- `style.css` says `Tested up to: 5.4` — bump it.
- Add `load_theme_textdomain('uk-mosque', get_template_directory() . '/languages')` to
  `inc/setup.php`; the `__()` calls currently do nothing.
- Add `add_theme_support('automatic-feed-links')` and `add_theme_support('responsive-embeds')`.

---

### Step 14 — Final bug sweep (Polish)

Run through these once the steps above are done — most will already be fixed.

| File | Issue |
| --- | --- |
| [404.php:32](404.php#L32) | Search input missing `name="s"` — the form can never work |
| [404.php:36](404.php#L36) | "Back to Home" points at `index.html`, should be `home_url('/')` |
| [header.php:82](header.php#L82) | Address widget links to `page-contact.html` |
| [header.php:135](header.php#L135) | `__cf_email__` obfuscation span with an empty `data-cfemail` |
| [footer.php:76-80](footer.php#L76-L80) | 5 Quick Links all `href="#"` → use `wp_nav_menu('footer_menu')` |
| [footer.php:61](footer.php#L61) | Privacy policy `href="#"` → `get_privacy_policy_url()` |
| [footer.php:144](footer.php#L144) | Hardcoded "© 2026 Islamus" → `footer_copyright` + `date('Y')` + `bloginfo('name')` |
| [footer.php:10](footer.php#L10) | `esc_html(home_url('/'))` inside an `href` → `esc_url()` |
| [home.php:25](home.php#L25) | Same `esc_html`-in-`href` bug |
| `front-page.php` | 4 `src="images/…"` paths missing the theme URI |
| all | Audit remaining `esc_html` on URLs: `grep -n 'href="<?php echo esc_html' *.php` |

Also run once at the end:

- Settings → Permalinks (flush rewrites after all the CPT changes)
- Set `WP_DEBUG = true` in `wp-config.php` and walk every page, looking for notices
- Theme Check plugin
- Test with **zero content** in every CPT — every loop needs a working `else:` branch

---

## Part D — Suggested milestones

| Milestone | Steps | Outcome |
| --- | --- | --- |
| **M1 — No broken routes** | 1, 2 | Every URL renders something real. Safe to show the client. |
| **M2 — Content model live** | 3, 4, 5, 6 | Admin can edit prayer times and causes; donations fully working |
| **M3 — Home page** | 7 | The marketing page is real. Biggest visible jump. |
| **M4 — Remaining pages** | 8, 9, 10 | Blog, gallery, about, prayer times and contact all dynamic |
| **M5 — Forms** | 11, 12 | The site can receive enquiries |
| **M6 — Launch prep** | 13, 14 | Performance, i18n, bug sweep |

---

## Part E — Conventions to keep

Carried over from the existing code — stay consistent with them.

- **Escaping:** `esc_html()` for text, `esc_attr()` for attributes, `esc_url()` for URLs,
  `wp_kses_post()` for rich text. Never `esc_html()` on an `href`.
- **Text domain:** `uk-mosque` on every user-facing string.
- **Meta prefix:** `_` + `{cpt}_` + `{field}`, e.g. `_event_location`. The leading `_` keeps the
  field out of the default custom-fields box.
- **Nonces:** on every metabox save and every form submission. Check
  `defined('DOING_AUTOSAVE')` and `current_user_can()` in save handlers — the existing handlers
  in `inc/custom-metabox.php` are the pattern to copy.
- **File guard:** `if (!defined('ABSPATH')) { exit; }` at the top of every PHP file.
- **Loops:** always `wp_reset_postdata()` after a custom `WP_Query`.
- **Partials:** if markup appears twice, it becomes a `template-parts/` file.
