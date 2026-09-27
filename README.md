# Kadence Child — La Grange Fleurie

Child theme with the MotoPress search-results experience (add-to-selection cart, mini cart,
direct-booking guard) + GitHub auto-updater.

## Quick files

- `assets/css/lgf-search-results.css` — all search-results/cart CSS (enqueued on the page, versioned = auto cache-bust).
- `assets/css/cycling-admin.css` — layout for wp-admin → Cycling → EN/FR/NL; mirrors the live page sections in columns (admin screens only).
- `assets/css/cycling-admin-menu.css` — bicycle icon for the Cycling admin menu; loaded on every admin screen, since the menu is.
- `assets/css/cycling-itineraries.css` + `assets/css/cycling-palette.css` — front-end design for the cycling pages.
- `inc/cycling-admin.php` — the Cycling EN/FR/NL editor form, one panel per live-page section.
- `page-cycling-itineraries.php` — page template assigned to published cycling pages; delegates to the dynamic renderer so EN/FR/NL editor changes reach the front end.

## Cycling GPX downloads

Three places, all in `assets/routes/`:

- Per riding day — set `details[r][file]` on a plan card in wp-admin. Days with a file get a small
  "Download GPX" link under the itinerary entry; days without one (arrival, rest) show nothing.
  `.gpx` only.
- Per package — set `archive` on a plan card. The button under the plan downloads this ZIP.
  `.zip` only.
- Fallback — `file` on the pace card is only used for the package button when no ZIP is set.

Filenames are sanitised to a bare name with an expected extension, so paths and other file types are
rejected on save. The editor flags a name that is not present in `assets/routes/` as a 404 risk.
Per-day links are per-language content; the file names themselves are not, so all three languages
carry the same `details` files.
- `assets/js/lgf-search-results.js` — cart + toggle logic.
- `hotel-booking/shortcodes/search-results/errors.php` — custom empty/error states.
- `functions-updater-top.php` — prepend at the very top of `functions.php` (GitHub updater, loads PUC from `lib/`).
- `functions-append.php` — replace the old appended block at the bottom of `functions.php` (button label, price-label removal, cart title, enqueues CSS+JS v1.0.3).

## One-time GitHub setup

1. Create a repo named `kadence-child` (public is simplest; no secrets live in this theme).
2. (Already done — repo is `https://github.com/angusuwatson/kadence-child`.)
3. Push the whole theme folder to branch `main`.
4. On the live site: after this batch is deployed, go to **Appearance → Themes**. Dev pushes to `main` appear as an update — click **Update** instead of uploading files manually.

- Private repo? Add `$lgfThemeUpdater->setAuthentication( '<TOKEN>' );` inside the updater block — keep the token in `wp-config.php`, NOT in this theme.
- Every push to `main` = an available update. Always deploy after the page is verified on dev.

## Notes for the live update (this batch)

- In the live theme `style.css`: DELETE the old appended MotoPress block (from the `/* MotoPress Hotel Booking` banner to EOF) — it is now a separate versioned file. Keep any personal CSS you added yourself. Set `Version:` to `1.0.1` if it isn't.
- Upload `lib/plugin-update-checker/`, `assets/css/`, and replace `functions.php` per the two snippets above.
- The web server must be able to write into `wp-content/themes/kadence-child` for the in-place updater (normal on Hostinger).
- PUC library: [plugin-update-checker](https://github.com/YahnisElsts/plugin-update-checker) (MIT), by Janis Elsts.
