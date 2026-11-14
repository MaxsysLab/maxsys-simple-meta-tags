=== Maxsys Hub - Simple Meta Tags ===
Tags: meta tags, open graph, social sharing, twitter cards, seo
Requires at least: 6.0
Tested up to: 7.1
Requires PHP: 7.4
Stable tag: 1.4.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Set the description and the social sharing title, text and image for each page and post, with site-wide fallbacks.

== Description ==

Simple Meta Tags adds a small box to the edit screen of every page and post. In it you set the title, the description and the image that search engines and social networks show when the page is shared. A settings page holds the site-wide values that are used when a page has none of its own.

For each page the plugin prints:

* the meta description;
* Open Graph tags: title, description, image, type and address;
* Twitter card tags: title, description and image.

How the values are chosen:

* On the home page, the site-wide values are used. If the home page is a static page with its own values, those win.
* On a single page or post, its own values are used. Where one is missing, the plugin falls back to the page's title, the first 55 words of its content, and its featured image, then to the site-wide image.

The plugin does one job and has no other settings. It does not contact any outside service, and it stores nothing about your visitors.

= Two things to know =

* The "Meta Title" is used for the social sharing title (`og:title` and `twitter:title`). It does not change the page's `<title>` tag.
* So that social networks read these tags and not WordPress's own embed data, the plugin removes two links WordPress normally prints in every page's head: the oEmbed discovery links and the REST API link. The REST API itself keeps working. If another plugin or service relies on those links in the page head, do not use this plugin.

== Installation ==

1. Upload the plugin folder to `/wp-content/plugins/`, or install it from the Plugins screen.
2. Activate it on the Plugins screen.
3. Go to Settings, then Simple Meta Tags, and set the site-wide title, description and image.
4. Edit any page or post and fill in the "Custom Meta & Social Tags" box.

== Frequently Asked Questions ==

= Which image size should I use? =

1200 by 630 pixels, JPG or PNG. The plugin tells social networks the image is that size.

= Does it work with another SEO plugin? =

It prints its own description and social tags. If another plugin prints the same tags, the page will carry both sets. Use one or the other.

= What happens to my data if I delete the plugin? =

The site-wide settings are removed. The values saved on individual pages and posts are kept, so reinstalling the plugin brings them back.

== Changelog ==

= 1.4.0 =
* First public release.
* Added the licence, this readme and an uninstall routine.
* The site-wide settings are now cleaned before they are saved.
* All text can be translated, under the text domain `maxsys-simple-meta-tags`.
* The address in `og:url` is now the page's canonical address.
* Output escaping and input handling brought in line with the WordPress coding standards.

= 1.3 =
* The version used on Maxsys's own sites before public release.
