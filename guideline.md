# UK Mosque Theme — Step-by-Step Build Guideline

This is the **actionable checklist** version of [development.md](development.md). That
document explains *what* each field/CPT/screen needs; this one tells you *in what order*
and *how urgently* to build it, so you can work top-to-bottom and always know what's next.

Check items off as you go (`[x]`). Section numbers in brackets, e.g. `[§3.1]`, point back
to the matching section in development.md for full field tables and code snippets.

---

## Priority legend

| Tag                  | Meaning                                                                                  |
| --------------------- | ----------------------------------------------------------------------------------------- |
| 🔴 **P0 – Blocker**   | Nothing else works until this exists. Build first, no exceptions.                        |
| 🟠 **P1 – Core**      | Main visitor-facing content (Events, Donations, Home). Site isn't usable without these.  |
| 🟡 **P2 – Important** | Rounds out the content model (Team, Testimonials, Services, FAQ, other page settings).   |
| 🟢 **P3 – Polish**    | Bug fixes, typos, secondary pages, nice-to-haves. Do last or in parallel with QA.         |

---

## Phase 0 — Foundation 🔴 P0

Nothing below this line will work until Phase 0 is done. Build in this exact order.

- [ ] `inc/custom-post-type.php` — register all 7 CPTs (empty is fine for now, no meta yet) `[§3]`
- [ ] `inc/custom-texanomy.php` — register `donation_category` taxonomy `[§3]`
- [ ] `inc/setup.php` — add `register_nav_menus()` for `primary` / `mobile` / `footer` `[§2]`
- [ ] `inc/theme-options.php` — create Settings API skeleton (menu + submenu registration) `[§5]`
- [ ] `functions.php` — add missing `require_once inc/theme-options.php;`
- [ ] `inc/helpers.php` — create file, add `uk_mosque_get_option()` wrapper `[§1.3]`
- [ ] Decide + apply the `Template Name` conflict fix on `archive-event.php` /
      `archive-donation.php` (remove the header, rely on `has_archive`) `[§3]`

**Exit criteria:** wp-admin shows all 7 CPT menus + the Theme Options top-level menu, no
fatal errors, nav menu locations appear under Appearance → Menus.

---

## Phase 1 — CPTs, by priority

Build each CPT **end-to-end** (meta box → save handler → template loop → single template)
before moving to the next — don't register all 7 meta boxes then loop back for templates.

| # | CPT               | Priority       | Why this order                                             | Detail ref |
| - | ------------------ | -------------- | ------------------------------------------------------------ | ---------- |
| 1 | `event`             | 🟠 **P1**      | Homepage + own archive/single, high visitor value           | `[§3.1, §4.8, §4.9]` |
| 2 | `donation`          | 🟠 **P1**      | Homepage + archive/single + taxonomy + progress bar logic    | `[§3.2, §4.10, §4.11, §4.12]` |
| 3 | `service`           | 🟡 **P2**      | No meta fields, quick win, feeds Home + About                | `[§3.5]` |
| 4 | `faq`               | 🟡 **P2**      | No meta fields, quick win, feeds Home + About                | `[§3.6]` |
| 5 | `team_member`       | 🟡 **P2**      | Simple meta (role + 3 socials), feeds Home only              | `[§3.3]` |
| 6 | `testimonial`       | 🟡 **P2**      | Simple meta (role + rating), feeds Home only                 | `[§3.4]` |
| 7 | `gallery_item`      | 🟢 **P3**      | Own near-empty page, not linked from Home, lowest traffic    | `[§3.7, §4.5]` |

Per-CPT checklist (repeat for each row above):

- [ ] Meta box registered (`add_meta_box` + render callback), only if the CPT has custom fields
- [ ] Save handler (`save_post_{cpt}`) with nonce check + sanitized `update_post_meta()` calls `[§5]`
- [ ] Card/loop template part built (e.g. `template-parts/event/event-card.php`)
- [ ] Archive template wired to real `WP_Query`/`have_posts()` loop (if it has one)
- [ ] Single template wired to real fields (if it has one)
- [ ] Homepage section that uses this CPT converted from static markup to a real loop

### Metabox reference — which CPT needs one, and what fields

Only 4 of the 7 CPTs need a custom meta box. `service`, `faq`, and `gallery_item` use
built-in fields only (title/content/excerpt/featured image) — **do not** register an empty
meta box for them. Full field notes: `[§3.1–§3.7]`.

| CPT           | Needs metabox? | Metabox title        | Fields (meta key → type)                                                                                                                                                              |
| ------------- | -------------- | --------------------- | ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| `event`       | ✅ Yes         | "Event Details"       | `_uk_mosque_event_date` (date), `_uk_mosque_event_time_start` (time), `_uk_mosque_event_time_end` (time), `_uk_mosque_event_location` (text), `_uk_mosque_event_topic` (text), `_uk_mosque_event_website` (url) |
| `donation`    | ✅ Yes         | "Donation Details"    | `_uk_mosque_donation_goal` (number), `_uk_mosque_donation_raised` (number), `_uk_mosque_donation_hover_image` (image)                                                                |
| `team_member` | ✅ Yes         | "Team Member Details" | `_uk_mosque_team_role` (text), `_uk_mosque_team_facebook` (url), `_uk_mosque_team_twitter` (url), `_uk_mosque_team_pinterest` (url)                                                  |
| `testimonial` | ✅ Yes         | "Testimonial Details" | `_uk_mosque_testimonial_role` (text), `_uk_mosque_testimonial_rating` (number 1–5)                                                                                                    |
| `service`     | ❌ No          | —                      | Built-in only: title, excerpt, featured image, content                                                                                                                                |
| `faq`         | ❌ No          | —                      | Built-in only: title = question, content = answer (disable featured image/excerpt UI in `supports`)                                                                                  |
| `gallery_item`| ❌ No          | —                      | Built-in only: title (optional caption), featured image; optional `gallery_category` taxonomy (skip for v1)                                                                          |

- [ ] `event` metabox — 6 fields, image type is featured image (built-in, not in metabox)
- [ ] `donation` metabox — 2 number fields + 1 image field (image upload button, use `wp_enqueue_media()`)
- [ ] `team_member` metabox — 1 text field + 3 url fields
- [ ] `testimonial` metabox — 1 text field + 1 number field (1–5, use `<input type="number" min="1" max="5">`)
- [ ] Confirm `service` / `faq` / `gallery_item` register **no** meta box — only `supports` array adjustments

---

## Phase 2 — Theme Options screens, by priority

| Screen                | Priority  | Blocks / feeds                                                | Detail ref |
| ---------------------- | --------- | ---------------------------------------------------------------- | ---------- |
| Global Settings        | 🔴 **P0** | header.php, footer.php, contact.php — build right after Phase 0 | `[§2]`     |
| Prayer Times           | 🟠 **P1** | 3 templates (home, about, prayer-times page) share one partial  | `[§4.3]`   |
| Home Page              | 🟠 **P1** | front-page.php section intros (hero, about, section headings)   | `[§4.1]`   |
| Contact Page           | 🟡 **P2** | contact.php intro copy + form recipient email                   | `[§4.4]`   |
| About Page             | 🟡 **P2** | page-about.php intro/mission/vision/counter text                | `[§4.2]`   |
| 404 Page               | 🟢 **P3** | optional — static copy is acceptable for v1                     | `[§4.13]`  |

- [ ] Global Settings — build the screen, then immediately rewire header.php + footer.php to it
      (this single pass fixes ~6 bugs from §7 at once: logo paths, nav, social links, copyright)
- [ ] Prayer Times — build screen + `template-parts/prayer-times.php`, wire into all 3 templates
- [ ] Home Page — build screen, wire each section intro (hero/about/causes/services/etc.)
- [ ] Contact Page — build screen, wire intro copy + `form_recipient_email`
- [ ] About Page — build screen, wire mission/vision/counter fields
- [ ] 404 Page — optional screen, or leave static copy

---

## Phase 3 — Remaining templates, by priority

| Template                              | Priority  | Notes                                                             |
| --------------------------------------- | --------- | -------------------------------------------------------------------- |
| `front-page.php` (Home)                | 🟠 **P1** | Highest-traffic page; depends on every CPT + Home Page screen above |
| `header.php` / `footer.php`            | 🔴 **P0** | Rendered everywhere — fix as part of Global Settings phase           |
| `page-prayer-times.php`                | 🟠 **P1** | Depends on Prayer Times screen                                       |
| `archive-donation.php` / `single-donation.php` | 🟠 **P1** | Depends on `donation` CPT phase                                |
| `archive-event.php` / `single-event.php`       | 🟠 **P1** | Depends on `event` CPT phase                                   |
| `taxonomy-donation_category.php`       | 🟠 **P1** | Build alongside donation archive, reuses same card partial           |
| `page-about.php`                       | 🟡 **P2** | Depends on About Page screen + shared prayer-times/services/faq partials |
| `contact.php`                          | 🟡 **P2** | Depends on Contact Page screen + Global Settings + contact handler   |
| `home.php` (Blog index)                | 🟡 **P2** | Fix `eschtml()` fatal-error typo first, then add real Loop           |
| `single.php`                           | 🟡 **P2** | Currently a stub — build standard single-post template               |
| `gallery.php`                          | 🟢 **P3** | Currently near-empty — build `WP_Query` grid + Fancybox lightbox      |
| `404.php`                              | 🟢 **P3** | Two small fixes: search form `name="s"`, "Back to Home" link          |

---

## Phase 4 — Forms & handlers, by priority

| Form                | Priority  | Action                                                                 |
| -------------------- | --------- | ------------------------------------------------------------------------- |
| Contact form         | 🟠 **P1** | Build `admin-post.php` handler + `wp_mail()`, replace vendor demo URL `[§6]` |
| Newsletter form      | 🟡 **P2** | Reuse contact handler with a "newsletter" type flag, or defer to real ESP `[§6]` |
| Donation form        | 🟢 **P3** | Out of scope for v1 beyond wiring amount buttons — needs a payment gateway decision `[§6]` |

- [ ] Contact form handler (`uk_mosque_contact_submit` action, nonce, sanitize, `wp_mail`, redirect)
- [ ] Newsletter form wired or explicitly deferred (don't leave silently broken)
- [ ] Donation form scoped as a separate phase — flag to client that a payment gateway is required

---

## Phase 5 — Bug sweep, by priority

Full list lives in development.md §7. Grouped here by urgency:

**🔴 P0 — fixes a fatal error / broken core mechanism**
- [ ] `home.php`: `eschtml()` → `esc_url()` typo (fatal-error risk)
- [ ] `inc/theme-options.php` never `require_once`'d (already covered in Phase 0)

**🟠 P1 — visibly broken to every visitor**
- [ ] header.php: logo `<img>` paths missing `get_template_directory_uri()`
- [ ] header.php: no nav menu registered despite hardcoded markup
- [ ] footer.php: hardcoded `© 2026`, `href="index.html"`, dead social/quick-link `href="#"`
- [ ] contact.php: form posts to external demo vendor URL
- [ ] contact.php / footer.php: broken Cloudflare-obfuscated email links

**🟡 P2 — visible but lower traffic / cosmetic-functional**
- [ ] `page-prayer-times.php`: banner heading/breadcrumb wrongly say "About"
- [ ] contact.php: heading typo "Conatct" → "Contact"
- [ ] header.php: "Prayer Time" button links to `page-contact.html` instead of the real page
- [ ] Breadcrumbs using `href="#"` / `href="index.html"` instead of `home_url()`
      (page-about.php, page-prayer-times.php, archive-donation.php)
- [ ] `404.php`: search input missing `name="s"`

**🟢 P3 — cosmetic / low traffic**
- [ ] `gallery.php`: `Template Name: Gallary` typo → "Gallery"
- [ ] `single.php`: stub only, no title/content output
- [ ] `taxonomy-donation_category.php`: empty file
- [ ] `template-parts/donation/*.php`: all 3 files empty

---

## How to use this day-to-day

1. Work top-to-bottom: Phase 0 → Phase 1 (in CPT priority order) → Phase 2 → Phase 3 → Phase 4 → Phase 5.
2. Within Phase 1, finish one CPT completely (meta → loop → templates) before starting the next.
3. P0 items are never optional or deferrable — everything else assumes they're done.
4. P3 items can be batched into a single "polish pass" once P0–P2 are live, or fixed
   opportunistically whenever you're already editing that file.
5. When a checklist item references `[§x.x]`, open development.md at that section for the
   exact field list, meta keys, or code pattern before building it.
