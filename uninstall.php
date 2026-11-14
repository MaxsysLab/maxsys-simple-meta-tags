<?php
/**
 * Runs when the plugin is deleted from the Plugins screen.
 *
 * Removes the plugin's global settings. The titles, descriptions and images
 * saved on individual pages and posts are left in place, so that deleting and
 * reinstalling the plugin does not lose that work.
 *
 * @package MaxsysSimpleMetaTags
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

delete_option( 'maxsys_meta_tags_options' );
