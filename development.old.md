# UK Mosque Theme — Development Guide

Custom WordPress theme, **no ACF, no page builder**. Every editable piece of content is
managed through native WordPress APIs only:

- **Custom Post Types (CPT)** for repeatable content (Events, Causes/Donations, Team, Testimonials, Services, FAQs, Gallery items).
- **Custom Meta Boxes** (`add_meta_box()` + `save_post`, hand-rolled, no ACF) for per-post fields on those CPTs.
- **Settings API** (`register_setting()` / `add_settings_section()` / `add_settings_field()`) for page-wide content that isn't a repeatable post (hero text, prayer times, contact info, social links, etc.), each exposed as its own admin menu screen.
- **Nav Menus** (`register_nav_menus()` + `wp_nav_menu()`) for the header/mobile/footer menus, which today are hardcoded `<ul>` markup.

This document is organized **page-wise**: for every front-end template it lists the admin
screen that edits it, the exact fields required, and the current bugs found in that
template. It also has cross-cutting sections for CPTs, taxonomies, and file structure.

> Audit note: every template file was inspected. **None of them currently read any dynamic
> data** — no `get_post_meta()`, `WP_Query`, `get_theme_mod()`, or `get_option()` calls exist
> anywhere in the theme, and `inc/custom-post-type.php`, `inc/custom-metabox.php`,
> `inc/custom-texanomy.php`, `inc/theme-options.php` are all empty (0 bytes). Everything
> below is a from-scratch build.

---

## 1. Architecture summary

### 1.1 Admin menu map (what the mosque admin sees in wp-admin)

```
Events (CPT)                         → wp-admin native CPT list/edit screens
Causes (CPT, labelled "Donations")   → wp-admin native CPT list/edit screens
  └ Cause Category (taxonomy)
Team Members (CPT)                   → wp-admin native CPT list/edit screens
Testimonials (CPT)                   → wp-admin native CPT list/edit screens
Services (CPT)                       → wp-admin native CPT list/edit screens
FAQs (CPT)                           → wp-admin native CPT list/edit screens
Gallery Images (CPT)                 → wp-admin native CPT list/edit screens
Posts (built-in)                     → used as-is for the Blog/News section

Theme Options (top-level menu, dashicons-admin-customizer)
 ├─ Global Settings        → logo, contact info, social links, footer text
 ├─ Home Page              → every section of front-page.php
 ├─ About Page             → page-about.php content
 ├─ Prayer Times           → the 6 daily prayer rows (shared by 3 templates)
 ├─ Contact Page           → contact.php right-column + map
 └─ 404 Page               → error page copy
```

Each "Theme Options" submenu = one Settings API page = one editable front-end template
section. This satisfies "admin can edit page-wise."

### 1.2 File plan

```
inc/
  setup.php              (existing – add register_nav_menus() here)
  enqueue.php            (existing – no changes needed)
  custom-post-type.php   (existing, empty – register all 7 CPTs here)
  custom-texanomy.php    (existing, empty – register cause_category taxonomy here)
  custom-metabox.php     (existing, empty – all add_meta_box() + save handlers)
  theme-options.php      (existing, empty, NOT required in functions.php yet
                           – must add `require_once` line + build Settings API pages)
  helpers.php            (new – small getter functions, see 1.3)

template-parts/
  donation/
    donation-card.php     (existing, empty – single cause card markup)
    donation-meta.php     (existing, empty – raised/goal amounts block)
    donation-progress.php (existing, empty – progress bar, % from meta)
  event/
    event-card.php        (new – single event card markup, used on home + archive)
  prayer-times.php         (new – shared prayer-times table, used on 3 templates)
  faq.php                  (new – shared FAQ accordion, used on 2 templates)
  services.php             (new – shared services grid, used on 2 templates)
```

### 1.3 Naming conventions

- Function prefix: `uk_mosque_`
- CPT keys: `event`, `cause`, `team_member`, `testimonial`, `service`, `faq`, `gallery_item`
  (using `cause` instead of `donation` avoids the WooCommerce-style ambiguity, but keep
  `donation` as the taxonomy/query-var if you prefer — pick one and use consistently;
  templates already named `archive-donation.php`/`single-donation.php`/
  `taxonomy-donation_category.php` imply the CPT slug should actually be `donation` to
  match WordPress's automatic template routing — **use `donation`, not `cause`**, see §3).
- Taxonomy key: `donation_category`
- Option keys (Settings API): `uk_mosque_{screen}_options`, e.g. `uk_mosque_home_options`,
  `uk_mosque_global_options`, `uk_mosque_prayer_times_options`.
- Meta keys: `_uk_mosque_{field}` (underscore prefix hides them from the default Custom
  Fields metabox).
- Add small getter wrappers in `inc/helpers.php`, e.g. `uk_mosque_get_option('global', 'phone')`,
  so templates never call `get_option()` raw. Keeps templates readable and gives one place
  to add default fallbacks.

---

## 2. Global site-wide settings (used on nearly every template)

**Admin screen:** Theme Options → Global Settings
**Option name:** `uk_mosque_global_options` (array)

Currently duplicated, hardcoded, and inconsistent across `header.php`, `footer.php`,
`contact.php`, and `front-page.php`. Consolidate into one source of truth.

| Field                                                      | Type                                                               | Used in                                                                                                                                                                        |
| ---------------------------------------------------------- | ------------------------------------------------------------------ | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ |
| `logo` (header, light bg)                                  | image upload                                                       | header.php sticky/main logo                                                                                                                                                    |
| `logo_alt` (footer/dark bg)                                | image upload                                                       | footer.php, mobile menu logo (currently `logo-2.png`)                                                                                                                          |
| `phone_primary`                                            | text                                                               | header action-box, footer, contact.php                                                                                                                                         |
| `phone_secondary`                                          | text                                                               | contact.php (currently shows 2 numbers)                                                                                                                                        |
| `email`                                                    | email                                                              | footer, contact.php (replaces broken Cloudflare-obfuscated email links)                                                                                                        |
| `address`                                                  | textarea                                                           | header action-box, footer, contact.php                                                                                                                                         |
| `map_embed_url`                                            | url/textarea (iframe src)                                          | contact.php map iframe, home contact section                                                                                                                                   |
| `facebook_url` / `x_url` / `pinterest_url` / `youtube_url` | url                                                                | footer + mobile-menu social lists (today: header uses Twitter/Facebook/Pinterest/**Vimeo**, footer uses Facebook/X/Pinterest/**YouTube** — reconcile to one set of 4 networks) |
| `footer_newsletter_heading` / `footer_newsletter_text`     | text/textarea                                                      | footer.php newsletter box                                                                                                                                                      |
| `footer_quick_links`                                       | repeatable (label+url) OR switch to a registered `footer` nav menu | footer.php "Quick Links" column                                                                                                                                                |
| `copyright_text`                                           | text, supports `{year}` and `{site}` tokens                        | footer.php bottom bar (also fix hardcoded `© 2026`)                                                                                                                            |

**Nav menus** (not part of Settings API — use core Appearance → Menus):
Register locations in `inc/setup.php`:

```php
register_nav_menus([
  'primary' => 'Primary Menu',   // header.php desktop nav
  'mobile'  => 'Mobile Menu',    // header.php mobile nav
  'footer'  => 'Footer Quick Links',
]);
```

Replace the hardcoded `<ul class="navigation">` blocks in header.php and the Quick Links
list in footer.php with `wp_nav_menu()` calls.

---

## 3. Custom Post Types & Taxonomies

| CPT slug       | Labels             | Archive template                                            | Single template     | has_archive           | Taxonomy                    |
| -------------- | ------------------ | ----------------------------------------------------------- | ------------------- | --------------------- | --------------------------- |
| `event`        | Events             | archive-event.php                                           | single-event.php    | `true`, slug `events` | `event_category` (optional) |
| `donation`     | Causes / Donations | archive-donation.php                                        | single-donation.php | `true`, slug `causes` | `donation_category`         |
| `team_member`  | Team Members       | — (no archive template exists; query manually where needed) | optional            | `false`               | —                           |
| `testimonial`  | Testimonials       | —                                                           | —                   | `false`               | —                           |
| `service`      | Services           | —                                                           | —                   | `false`               | —                           |
| `faq`          | FAQs               | —                                                           | —                   | `false`               | —                           |
| `gallery_item` | Gallery Images     | — (gallery.php builds its own grid via WP_Query)            | —                   | `false`               | optional `gallery_category` |

Register all in `inc/custom-post-type.php`, all with `'public' => true, 'show_in_menu' =>
true, 'menu_icon' => 'dashicons-...', 'supports' => [...]`. Important: `archive-event.php`
and `archive-donation.php` currently have a `Template Name:` header, which makes WordPress
treat them as **Page Templates**, not automatic CPT archive templates. Decide one approach
(see §9, Phase 1) — recommended: **remove the `Template Name` header** and let WordPress
auto-route `/events/` and `/causes/` to these files via `has_archive`, since that's simpler
and matches the file naming convention (`archive-{posttype}.php`) WordPress expects.

### 3.1 `event` — meta fields

| Meta key                      | Field                    | Notes                                                     |
| ----------------------------- | ------------------------ | --------------------------------------------------------- |
| `_uk_mosque_event_date`       | date picker              | drives the "Nov 25" month/day badge on cards              |
| `_uk_mosque_event_time_start` | time                     | e.g. "09:00 PM"                                           |
| `_uk_mosque_event_time_end`   | time                     | e.g. "10:00 PM"                                           |
| `_uk_mosque_event_location`   | text                     | venue name/address                                        |
| `_uk_mosque_event_topic`      | text                     | short subtitle shown on cards (e.g. "Iftar Mahfil")       |
| `_uk_mosque_event_website`    | url                      | optional external link, shown in single-event details box |
| Featured image                | built-in                 | card + single hero image                                  |
| Content                       | built-in `the_content()` | replaces the hardcoded "About The Event" paragraph        |

Meta box: "Event Details" with the 5 custom fields above.

### 3.2 `donation` — meta fields

| Meta key                          | Field    | Notes                                                                                                                                     |
| --------------------------------- | -------- | ----------------------------------------------------------------------------------------------------------------------------------------- |
| `_uk_mosque_donation_goal`        | number   | "Goal: $6,599"                                                                                                                            |
| `_uk_mosque_donation_raised`      | number   | "Raised: $4,599" — progress % = `raised / goal * 100`, compute in `template-parts/donation/donation-progress.php`, don't store separately |
| `_uk_mosque_donation_hover_image` | image    | second image shown on card hover (archive-donation.php currently reuses the same image twice)                                             |
| `donation_category` (taxonomy)    | terms    | replaces the hardcoded "Food"/"Mosque" tags                                                                                               |
| Featured image                    | built-in | primary card image                                                                                                                        |
| Content                           | built-in | replaces "Donation Causes Overview" paragraphs                                                                                            |
| Excerpt                           | built-in | replaces card excerpt text                                                                                                                |

Meta box: "Donation Details" (goal, raised, hover image).

Note: `raised` being a manually-typed number is the pragmatic MVP. If real online
donations are added later, this becomes a computed total from a transactions table/gateway
— flag that as a future phase, don't build it now.

### 3.3 `team_member` — meta fields

| Meta key                    | Field                              |
| --------------------------- | ---------------------------------- |
| `_uk_mosque_team_role`      | text (e.g. "Imam", "Head Teacher") |
| `_uk_mosque_team_facebook`  | url                                |
| `_uk_mosque_team_twitter`   | url                                |
| `_uk_mosque_team_pinterest` | url                                |
| Featured image              | built-in — photo                   |
| Title                       | built-in — name                    |

Meta box: "Team Member Details".

### 3.4 `testimonial` — meta fields

| Meta key                        | Field                                      |
| ------------------------------- | ------------------------------------------ |
| `_uk_mosque_testimonial_role`   | text — designation shown under author name |
| `_uk_mosque_testimonial_rating` | number 1–5                                 |
| Featured image                  | built-in — author photo                    |
| Content                         | built-in — the quote                       |

Meta box: "Testimonial Details" (role, rating).

### 3.5 `service` — fields

No custom meta needed:

- Title, Excerpt (short 2-line description), Featured image, Content (optional detail
  page — currently links to a non-existent "page-service-details.html").

### 3.6 `faq` — fields

No custom meta needed:

- Title = question, Content = answer. `supports => ['title', 'editor']` only, disable
  featured image/excerpt UI to keep the edit screen minimal.

### 3.7 `gallery_item` — fields

No custom meta needed:

- Title (optional caption), Featured image = the gallery photo. Optional
  `gallery_category` taxonomy if the admin wants filterable galleries later — skip for v1
  unless requested.

---

## 4. Page-by-page breakdown

For each template: **Admin edit location**, **Fields**, **Bugs to fix while building**.

### 4.1 Home — `front-page.php`

**Admin edit location:** Theme Options → Home Page (Settings API) for section text/hero;
Events/Donations/Team/Testimonials pull live from their CPTs; Prayer Times pulls from the
shared Theme Options → Prayer Times screen.

**Settings API fields (`uk_mosque_home_options`):**

| Section            | Fields                                                                                                                      |
| ------------------ | --------------------------------------------------------------------------------------------------------------------------- |
| Hero/Banner        | sub_title, heading, button_1_label, button_1_url, button_2_label, button_2_url, hero_image                                  |
| About/Welcome      | sub_title, heading, body_text, image_1, image_2, mission_title, mission_text, vision_title, vision_text, cta_label, cta_url |
| Causes intro       | sub*title, heading, description *(cards themselves = 3 latest/featured `donation` posts via `WP_Query`, not stored here)\_  |
| Prayer Times intro | sub*title, heading, description *(rows come from Prayer Times screen, §4.3)\_                                               |
| Services intro     | sub*title, heading, description *(cards = `service` CPT loop, limit 4)\_                                                    |
| Events intro       | sub*title, heading, description *(cards = latest 3 `event` posts)\_                                                         |
| Marquee ticker     | repeatable list of short strings (currently: "New to Islam", "Donate Now", "Arabic School", "Ask the Imam")                 |
| Team intro         | sub*title, heading *(cards = `team_member` CPT loop)\_                                                                      |
| Donation form      | sub_title, heading, description, image, preset_amounts (repeatable number list, currently 50/60/70/80/90/100)               |
| FAQ intro          | heading _(items = `faq` CPT loop, limit 5)_                                                                                 |
| Testimonial intro  | heading _(slides = `testimonial` CPT loop)_                                                                                 |
| Blog intro         | sub*title, heading *(cards = latest 4 standard Posts via real `WP_Query`)\_                                                 |
| Contact section    | sub*title, heading, map_image *(phone/email/address pulled from Global Settings, not duplicated here)\_                     |

**Bugs found:**

- Donation form (`#donationForm`) and blog "cards" have no live data — needs real loops.
- Contact form here (and in contact.php) has **no `action`/`method`** — build a handler (see §6).
- Causes/Events/Team/Testimonial/Blog sections are each 1 hardcoded block copy-pasted 3–6×
  — must become real loops once the CPTs exist.

### 4.2 About — `page-about.php` (Template Name: "About Page")

**Admin edit location:** Theme Options → About Page.

**Fields (`uk_mosque_about_options`):**
sub_title, heading, image_1, image_2, mission_icon, mission_heading, mission_text,
vision_icon, vision_heading, vision_text, counter_number (e.g. 98), counter_suffix (e.g.
"%"), counter_caption, cta_label, cta_url.

Prayer Times, Services, FAQ sections on this page reuse the **same shared partials**
(`template-parts/prayer-times.php`, `services.php`, `faq.php`) as the homepage — do not
duplicate the markup/content again, that's the bug currently in the static HTML (identical
content copy-pasted into 3 files).

**Bugs found:**

- Breadcrumb "Home" link is `href="#"` — fix to `home_url()`.

### 4.3 Prayer Times — `page-prayer-times.php` (Template Name: "Prayer Times Page")

**Admin edit location:** Theme Options → Prayer Times.
This is the single source of truth also rendered on Home and About via
`template-parts/prayer-times.php`.

**Fields (`uk_mosque_prayer_times_options`):**

| Field                            | Notes                         |
| -------------------------------- | ----------------------------- |
| sub_title, heading, description  | section intro text            |
| Fajr: adhan_time, iqamah_time    |                               |
| Zuhr: adhan_time, iqamah_time    |                               |
| Asr: adhan_time, iqamah_time     |                               |
| Maghrib: adhan_time, iqamah_time |                               |
| Isha: adhan_time, iqamah_time    |                               |
| Jummah: adhan_time, iqamah_time  | single wide row in the design |

12 time fields total + 3 text fields. Render with a small loop over an array of
`['key' => 'fajr', 'label' => 'Fajr', 'icon' => '...svg']` etc. inside
`template-parts/prayer-times.php` so it's one code path for all 3 templates.

**Bugs found:**

- Page banner heading and breadcrumb both say **"About"** (copy-paste leftover) instead of
  "Prayer Times" — fix when rebuilding.
- Breadcrumb "Home" link is `href="#"`, not `home_url()`.

### 4.4 Contact — `contact.php` (Template Name: "Contact")

**Admin edit location:** Theme Options → Contact Page (page-specific copy) + Theme Options
→ Global Settings (phone/email/address/map — shared, don't duplicate).

**Fields (`uk_mosque_contact_options`):**
intro_heading, intro_text, form_recipient_email (where the contact form emails go).

Phone/email/address blocks in the right column and the map iframe should pull from
**Global Settings**, not a separate copy.

**Bugs found:**

- Page heading says "**Conatct**" (typo) — fix to "Contact".
- Breadcrumb "Home" link is `href="index.html"` — fix to `home_url()`.
- Form `action="https://html.kodesolution.com/.../sendmail.php"` — this is the original
  HTML-template vendor's demo endpoint. Must be replaced with a real WP handler (§6).
- Email link points to a broken Cloudflare email-obfuscation snippet copied from the demo
  — replace with a plain `mailto:` built from the Global Settings email field.

### 4.5 Gallery — `gallery.php` (Template Name: "Gallary")

Currently a near-empty stub (`<h1>Gallary</h1>`, no content). Full build needed.

**Admin edit location:** Gallery Images (CPT list) — admin just uploads photos as
`gallery_item` posts; no Settings API screen needed beyond maybe an optional intro
heading/text if desired.

**Front end:** simple `WP_Query` grid of all `gallery_item` posts, featured images in a
lightbox (Fancybox is already enqueued in `inc/enqueue.php`, reuse it).

**Bugs found:** page title typo "**Gallary**" → "Gallery" (fix the `Template Name` header text).

### 4.6 Blog / News listing — `home.php`

This is the automatic posts-index template (no `Template Name` header) — assign it as the
site's "Posts page" in Settings → Reading.

**Admin edit location:** none needed beyond writing normal Posts — this page is fully
driven by standard WP Posts + Categories, no custom settings screen required.

**Bugs found:**

- `eschtml(home_url('/'))` — **`eschtml()` is not a real function**, this will throw a
  fatal error. Fix to `esc_url(home_url('/'))`.
- No `WP_Query`/`have_posts()` loop exists — the 6 "blog-post" cards are static demo
  content; replace with a real Loop + `paginate_links()`.

### 4.7 Single Post — `single.php`

Currently a bare stub (`<h1>single post</h1>`). Build a standard single-post template:
`the_title()`, post thumbnail, `the_content()`, categories/tags, `comments_template()` if
comments are wanted. No custom admin screen needed — standard post editor is sufficient.

### 4.8 Events archive — `archive-event.php`

**Admin edit location:** Events (CPT list) to manage entries; page intro text
(heading/breadcrumb) can stay static or move to a small "Events Page" Settings API screen
if the admin wants to edit the intro copy — low priority, static is fine for v1.

**Front end:** replace the 3 hardcoded `.event-block` cards with a `WP_Query( ['post_type'
=> 'event', 'orderby' => 'meta_value', 'meta_key' => '_uk_mosque_event_date', 'order' =>
'ASC'] )` loop, rendered via `template-parts/event/event-card.php` (shared with the
homepage teaser).

**Bugs found:** has a `Template Name` header conflicting with native archive routing — see
§3 decision.

### 4.9 Single Event — `single-event.php`

**Admin edit location:** edit the individual Event post (Events → [event name]) — title,
content, featured image, and the "Event Details" meta box fields from §3.1.

**Front end changes needed:**

- Replace hardcoded "About The Event" heading/paragraph with `the_title()` / `the_content()`.
- Replace the 4-row details box (mislabeled "Events"/"Event Type"/"Date"/"Website") with
  real values: Location, Event Type (or drop if not using taxonomy), Date (formatted from
  `_uk_mosque_event_date`), Website.
- "Donate Now" CTA is miscoped for an event — relabel to "Register"/"RSVP" or drop.
- Prev/Next links → wire to `get_previous_post_link()` / `get_next_post_link()`.

### 4.10 Donations/Causes archive — `archive-donation.php`

**Admin edit location:** Causes (CPT list, `donation` post type) + Donation Category
taxonomy terms (Causes → Categories).

**Front end:** replace the 6 hardcoded `.causes-block` cards with a `WP_Query(['post_type'
=> 'donation'])` loop through `template-parts/donation/donation-card.php`, which itself
calls `donation-meta.php` (goal/raised numbers) and `donation-progress.php` (bar %). Same
`Template Name` conflict as events — see §3.

### 4.11 Single Donation/Cause — `single-donation.php`

**Admin edit location:** edit the individual Cause post — title, content, excerpt,
featured image, "Donation Details" meta box (§3.2), category terms.

**Front end changes needed:**

- Sidebar's 6 static "service" links should become a real loop over `donation_category`
  terms (or sibling `donation` posts) via `get_terms()`.
- "Donation Causes Overview" paragraphs → `the_content()`.
- Donation form here is identical to the homepage one — extract to a shared
  `template-parts/donation-form.php` partial once wired to a real handler (§6).

### 4.12 Donation Category archive — `taxonomy-donation_category.php`

Currently empty (0 bytes). Build using the same `donation-card.php` partial as
`archive-donation.php`, filtered automatically by WordPress's taxonomy query — just loop
`have_posts()` as normal within the taxonomy template.

### 4.13 404 — `404.php`

Mostly built already (message, image). Two fixes:

- Search form isn't wired to WP search (no `name="s"` on the input) — replace with
  `get_search_form()` or add `name="s"` and `action="<?php echo esc_url(home_url('/')); ?>"`.
- "Back to Home" button `href="index.html"` → `home_url('/')`.

**Admin edit location:** optional Theme Options → 404 Page screen for the heading/message
text if the admin wants to customize the copy; otherwise leave static.

### 4.14 Header & Footer — `header.php` / `footer.php`

Not standalone pages, but rendered everywhere — pull entirely from **Global Settings**
(§2) plus registered nav menus. Key fixes while rebuilding:

- Logo: use `the_custom_logo()` (theme already declares `add_theme_support('custom-logo')`
  in `inc/setup.php` but never calls it) or the Global Settings logo fields, not hardcoded
  `<img src=".../logo.png">`.
- Both header logos (`images/logo.png` in the sticky header, `images/logo-2.png` in the
  mobile menu) are missing `get_template_directory_uri()` — currently broken paths.
- Desktop/mobile nav: replace hardcoded `<ul>` with `wp_nav_menu()` against the registered
  `primary`/`mobile` locations.
- Header "Prayer Time" button currently links to `page-contact.html` — should link to the
  real Prayer Times page via `get_permalink( get_page_by_path('prayer-times') )` or a
  Theme Options field storing that page's ID.
- Footer copyright: hardcode year → `date('Y')`; link → `home_url()`; site name → from
  Global Settings or `get_bloginfo('name')`.
- Footer newsletter form has no `action` — either wrap it into the same contact-handler
  pattern (§6) with a "type: newsletter" flag, or integrate a real mailing-list API later;
  don't leave it silently broken.

---

## 5. Custom Fields UI approach (no ACF)

For post meta boxes, use the plain pattern:

```php
add_action('add_meta_boxes', function () {
    add_meta_box('uk_mosque_event_details', 'Event Details', 'uk_mosque_render_event_meta_box', 'event', 'normal', 'high');
});

function uk_mosque_render_event_meta_box($post) {
    wp_nonce_field('uk_mosque_save_event_meta', 'uk_mosque_event_meta_nonce');
    $date = get_post_meta($post->ID, '_uk_mosque_event_date', true);
    // ... render <input> fields, one per field in §3.1
}

add_action('save_post_event', function ($post_id) {
    if (!isset($_POST['uk_mosque_event_meta_nonce']) ||
        !wp_verify_nonce($_POST['uk_mosque_event_meta_nonce'], 'uk_mosque_save_event_meta')) return;
    if (!current_user_can('edit_post', $post_id)) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

    update_post_meta($post_id, '_uk_mosque_event_date', sanitize_text_field($_POST['event_date'] ?? ''));
    // ... one update_post_meta() per field, each sanitized appropriately
    // (sanitize_text_field for text, esc_url_raw for URLs, absint for numbers)
});
```

For Theme Options screens, use the Settings API with **one array option per screen**
(`uk_mosque_home_options`, etc.) so a single `register_setting()` + one sanitize callback
covers the whole page:

```php
add_action('admin_menu', function () {
    add_menu_page('Theme Options', 'Theme Options', 'manage_options', 'uk_mosque_options', 'uk_mosque_render_global_page', 'dashicons-admin-customizer');
    add_submenu_page('uk_mosque_options', 'Global Settings', 'Global Settings', 'manage_options', 'uk_mosque_options', 'uk_mosque_render_global_page');
    add_submenu_page('uk_mosque_options', 'Home Page', 'Home Page', 'manage_options', 'uk_mosque_home_options', 'uk_mosque_render_home_page');
    add_submenu_page('uk_mosque_options', 'About Page', 'About Page', 'manage_options', 'uk_mosque_about_options', 'uk_mosque_render_about_page');
    add_submenu_page('uk_mosque_options', 'Prayer Times', 'Prayer Times', 'manage_options', 'uk_mosque_prayer_times_options', 'uk_mosque_render_prayer_times_page');
    add_submenu_page('uk_mosque_options', 'Contact Page', 'Contact Page', 'manage_options', 'uk_mosque_contact_options', 'uk_mosque_render_contact_page');
});
```

Each `uk_mosque_render_*_page()` outputs a form posting to `options.php` with
`settings_fields('uk_mosque_{screen}_group')` + `do_settings_sections(...)`, standard
Settings API boilerplate — no ACF, no third-party field builder.

---

## 6. Forms that need real handlers

Three forms exist across templates and none of them currently submit anywhere real:

1. **Contact form** (contact.php + front-page.php contact section) — currently posts to
   the original HTML template vendor's demo URL. Build a single handler: `admin-post.php`
   action `uk_mosque_contact_submit`, verify a nonce, sanitize fields, `wp_mail()` to the
   `form_recipient_email` set in Theme Options → Contact Page, redirect back with a
   success/error query var.
2. **Donation form** (front-page.php + single-donation.php) — no `action` at all. This
   needs a real payment gateway (Stripe/PayPal/etc.) to actually take money — that's a
   larger scope decision than plain form handling. For v1, treat as out of scope beyond
   wiring the amount buttons in JS (already present) and stub the submit to email an
   intent/lead, OR flag explicitly to the client that payment processing is a separate
   phase requiring a gateway account and PCI-relevant decisions.
3. **Footer newsletter form** — no `action`. Either point it at the same
   `admin-post.php` contact handler (tagged as "newsletter" type) storing signups as a
   simple custom table/CPT, or integrate a real ESP (Mailchimp etc.) later.

Don't build fake/silent success states — every form must either really work or visibly
say "coming soon" until wired up.

---

## 7. Known bugs to fix while building (collected from §4, for a quick checklist)

- [ ] `home.php`: `eschtml()` typo → fatal-error risk, fix to `esc_url()`.
- [ ] `page-prayer-times.php`: banner heading/breadcrumb say "About" instead of "Prayer Times".
- [ ] `contact.php`: page heading typo "Conatct" → "Contact".
- [ ] `contact.php`: form posts to the demo vendor's external URL.
- [ ] `contact.php` / footer.php: broken Cloudflare-obfuscated email links.
- [ ] `gallery.php`: `Template Name: Gallary` typo → "Gallery".
- [ ] header.php: both logo `<img>` paths missing `get_template_directory_uri()`.
- [ ] header.php: no nav menu registered despite hardcoded nav markup.
- [ ] header.php: "Prayer Time" button links to `page-contact.html`.
- [ ] footer.php: hardcoded `© 2026`, `href="index.html"`, and all social/quick links `href="#"`.
- [ ] Several breadcrumbs use `href="#"` or `href="index.html"` instead of `home_url()`
      (page-about.php, page-prayer-times.php, archive-donation.php).
- [ ] `archive-event.php` / `archive-donation.php`: `Template Name` header conflicts with
      native CPT archive routing — pick one approach (§3).
- [ ] `404.php`: search input has no `name="s"`, doesn't actually search.
- [ ] `single.php`: stub only, no title/content output.
- [ ] `taxonomy-donation_category.php`: empty file.
- [ ] `template-parts/donation/*.php`: all 3 files empty.
- [ ] `inc/theme-options.php`: never `require_once`'d in `functions.php`.

---

## 8. Suggested build order

1. **Foundations:** `inc/custom-post-type.php` (all 7 CPTs), `inc/custom-texanomy.php`
   (`donation_category`), nav menu registration in `inc/setup.php`, `inc/theme-options.php`
   skeleton + `require_once` in `functions.php`, `inc/helpers.php` getters.
2. **Global Settings screen** + rewire header.php/footer.php to it (fixes the logo/nav/social/copyright bugs in one pass).
3. **Prayer Times screen** + `template-parts/prayer-times.php`, used by
   page-prayer-times.php, page-about.php, front-page.php.
4. **Event CPT end-to-end:** meta box → `template-parts/event/event-card.php` →
   archive-event.php loop → single-event.php real fields.
5. **Donation CPT + taxonomy end-to-end:** meta box → the 3 `template-parts/donation/*`
   partials → archive-donation.php loop → single-donation.php → taxonomy-donation_category.php.
6. **Team / Testimonial / Service / FAQ CPTs** + their loops on front-page.php and
   page-about.php (services/FAQ).
7. **Home Page / About Page / Contact Page Settings screens** for the remaining static text sections.
8. **Gallery** (CPT + gallery.php grid), **Blog loop** (home.php), **single.php**, **404.php** fixes.
9. **Forms:** contact handler via `admin-post.php` + `wp_mail()`; decide donation-form/payment scope; newsletter handler or defer.
10. Bug checklist in §7 — sweep for anything missed.
