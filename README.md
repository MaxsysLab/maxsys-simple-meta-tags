# Maxsys Hub - Simple Meta Tags

A small WordPress plugin. It lets you set the description and the social sharing title,
text and image for each page and post, with site-wide fallbacks.

It prints the meta description, Open Graph tags and Twitter card tags. It does one job,
contacts no outside service, and stores nothing about visitors.

Everything a site owner needs to know is in [`readme.txt`](readme.txt), the file the
WordPress plugin directory reads: what it does, how values are chosen, installation,
and two things to know before using it.

## Requirements

WordPress 6.0 or newer, PHP 7.4 or newer. Tested on WordPress 7.1 with PHP 8.3.

## Development

There is no build step. The plugin is three files: `maxsys-simple-meta-tags.php`,
`admin.js` and `uninstall.php`.

To try a change, mount the folder into any WordPress as
`wp-content/plugins/maxsys-simple-meta-tags` and activate it. Every pull request is
checked for PHP syntax on the supported versions and with the WordPress
[Plugin Check](https://wordpress.org/plugins/plugin-check/) tool.

See [CONTRIBUTING.md](CONTRIBUTING.md). Report security problems privately, as
[SECURITY.md](SECURITY.md) describes.

## Who stands behind it

Published as open source by Maxsys International Incorporated, a nonprofit
(maxsys.org), through [MaxsysLab](https://github.com/MaxsysLab). Built by CSEAM
Technology Corporation for Maxsys's own sites, and released for anyone to use.

## License

GPL-2.0-or-later. See [`LICENSE`](LICENSE).

Copyright 2025-2026 Maxsys International Incorporated.
