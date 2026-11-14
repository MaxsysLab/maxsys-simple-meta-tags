# Maxsys Hub - Simple Meta Tags

When someone shares a page of your site, the title, the few lines of text and the
picture that appear beside the link all come from a handful of tags in that page. This
small WordPress plugin lets you set them, page by page, with site-wide values to fall
back on.

We built it for our own sites. It does one job, it contacts no outside service, and it
stores nothing about your visitors.

## Start in a few minutes

1. Copy this folder to `wp-content/plugins/maxsys-simple-meta-tags` and activate the
   plugin.
2. Open Settings, then Simple Meta Tags, and set the site-wide title, description and
   image.
3. Edit any page or post and fill in the "Custom Meta & Social Tags" box: a title, a
   description and a sharing image for that page.
4. Open the page and look at its source. The meta description, the Open Graph tags and
   the Twitter card tags are there, ready for search engines and social networks.

A page with no values of its own uses its title, the first words of its content and its
featured image, with the site-wide image as the last resort. The exact order is in
[`readme.txt`](readme.txt), the file the WordPress plugin directory reads.

## Good to know

The "Meta Title" is the title used when the page is shared. It does not change the
page's own `<title>` tag.

So that social networks read these tags and not WordPress's own embed data, the plugin
leaves out two links WordPress normally prints in every page's head (the oEmbed
discovery links and the REST API link). The REST API itself keeps working. If you
already use an SEO plugin that prints the same tags, use one or the other, not both.

## Where it stands

Version 1.4.0. It needs WordPress 6.0 or newer and PHP 7.4 or newer, and we tested it
on WordPress 7.1 with PHP 8.3.

## Development

There is no build step. The plugin is three files: `maxsys-simple-meta-tags.php`,
`admin.js` and `uninstall.php`. To try a change, copy or mount the folder into any
WordPress as `wp-content/plugins/maxsys-simple-meta-tags` and activate it.

Pull requests are welcome, small ones especially. Each is checked for PHP syntax on the
supported versions and with the WordPress
[Plugin Check](https://wordpress.org/plugins/plugin-check/) tool.
[CONTRIBUTING.md](CONTRIBUTING.md) has the rest. If you find a security problem, please
tell us privately first, as [SECURITY.md](SECURITY.md) describes.

## Who stands behind it

Published as open source by Maxsys International Incorporated, a nonprofit
(maxsys.org), through [MaxsysLab](https://github.com/MaxsysLab). Built by CSEAM
Technology Corporation for our own sites, and released for anyone to use.

## License

GPL-2.0-or-later. See [`LICENSE`](LICENSE).

Copyright 2025-2026 Maxsys International Incorporated.
