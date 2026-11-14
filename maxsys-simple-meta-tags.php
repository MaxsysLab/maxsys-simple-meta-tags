<?php
/*
Plugin Name: Maxsys Hub - Simple Meta Tags
Description: Adds a user-friendly interface to set custom meta and Open Graph tags on a per-page basis, with global fallbacks.
Version: 1.3
Author: Maxsys Dev Team
*/

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// 1. Main function to output meta tags in the <head>
// ===================================================
add_action('wp_head', 'maxsys_output_custom_meta_tags', 5);
function maxsys_output_custom_meta_tags() {
    
    // --- Define Defaults ---
    $options = get_option('maxsys_meta_tags_options', []);
    $default_title = $options['title'] ?? get_bloginfo('name');
    $default_desc = $options['description'] ?? get_bloginfo('description');
    $default_image = $options['image'] ?? '';

    // --- Initialize Variables ---
    $meta_title = '';
    $meta_desc = '';
    $meta_image = '';

    // --- Logic to get the right tags for the current page ---
    if ( is_front_page() || is_home() ) {
        // We are on the homepage. Prioritize global settings.
        $meta_title = $default_title;
        $meta_desc = $default_desc;
        $meta_image = $default_image;

        // If it's a static front page, check for per-page overrides.
        if ( is_page() ) {
            $post_id = get_the_ID();
            $page_title = get_post_meta($post_id, '_maxsys_meta_title', true);
            $page_desc = get_post_meta($post_id, '_maxsys_meta_description', true);
            $page_image = get_post_meta($post_id, '_maxsys_meta_image', true);
            
            if ($page_title) $meta_title = $page_title;
            if ($page_desc) $meta_desc = $page_desc;
            if ($page_image) $meta_image = $page_image;
        }

    } elseif ( is_singular() ) {
        // We are on a single post or page. Prioritize per-page settings.
        $post_id = get_the_ID();
        $meta_title = get_post_meta($post_id, '_maxsys_meta_title', true) ?: get_the_title($post_id) . ' | ' . get_bloginfo('name');
        $meta_desc = get_post_meta($post_id, '_maxsys_meta_description', true) ?: wp_trim_words(strip_tags(get_the_content()), 55, '...');
        $meta_image = get_post_meta($post_id, '_maxsys_meta_image', true) ?: (has_post_thumbnail($post_id) ? get_the_post_thumbnail_url($post_id, 'full') : $default_image);
    }
    
    // Fallback one last time to ensure no empty values
    if (empty($meta_title)) $meta_title = get_bloginfo('name');
    if (empty($meta_desc)) $meta_desc = get_bloginfo('description');
    if (empty($meta_image)) $meta_image = $default_image;
    
    // --- Output the HTML Tags ---
    if ($meta_title || $meta_desc || $meta_image) {
        echo "\n<!-- Maxsys Hub Simple Meta Tags -->\n";
        if ($meta_desc) {
            echo '<meta name="description" content="' . esc_attr($meta_desc) . '" />' . "\n";
            echo '<meta property="og:description" content="' . esc_attr($meta_desc) . '" />' . "\n";
            echo '<meta name="twitter:description" content="' . esc_attr($meta_desc) . '" />' . "\n";
        }
        if ($meta_title) {
            echo '<meta property="og:title" content="' . esc_attr($meta_title) . '" />' . "\n";
            echo '<meta name="twitter:title" content="' . esc_attr($meta_title) . '" />' . "\n";
        }
        if ($meta_image) {
            echo '<meta property="og:image" content="' . esc_url($meta_image) . '" />' . "\n";
            echo '<meta property="og:image:width" content="1200" />' . "\n";
            echo '<meta property="og:image:height" content="630" />' . "\n";
            echo '<meta name="twitter:card" content="summary_large_image" />' . "\n";
            echo '<meta name="twitter:image" content="' . esc_url($meta_image) . '" />' . "\n";
        }
        echo '<meta property="og:type" content="website" />' . "\n";
        echo '<meta property="og:url" content="' . esc_url(home_url(add_query_arg(array(), $GLOBALS['wp']->request))) . '" />' . "\n";
        echo "<!-- End Maxsys Hub Simple Meta Tags -->\n";
    }
}

// 2. Admin Global Settings Page
// ===================================
add_action('admin_menu', 'maxsys_meta_tags_add_admin_menu');
function maxsys_meta_tags_add_admin_menu() {
    add_options_page('Simple Meta Tags', 'Simple Meta Tags', 'manage_options', 'maxsys_meta_tags', 'maxsys_meta_tags_options_page');
}

add_action('admin_init', 'maxsys_meta_tags_settings_init');
function maxsys_meta_tags_settings_init() {
    register_setting('maxsysMetaTags', 'maxsys_meta_tags_options');
    add_settings_section('maxsys_meta_tags_section', __('Global Meta Tags (Fallback)', 'maxsys-meta-tags'), null, 'maxsysMetaTags');
    add_settings_field('title', __('Custom Title', 'maxsys-meta-tags'), 'maxsys_meta_tags_field_render', 'maxsysMetaTags', 'maxsys_meta_tags_section', ['type' => 'text', 'name' => 'title']);
    add_settings_field('description', __('Description', 'maxsys-meta-tags'), 'maxsys_meta_tags_field_render', 'maxsysMetaTags', 'maxsys_meta_tags_section', ['type' => 'textarea', 'name' => 'description']);
    add_settings_field('image', __('OG Image', 'maxsys-meta-tags'), 'maxsys_meta_tags_field_render', 'maxsysMetaTags', 'maxsys_meta_tags_section', ['type' => 'image', 'name' => 'image']);
}

function maxsys_meta_tags_field_render($args) {
    $options = get_option('maxsys_meta_tags_options', []);
    $value = $options[$args['name']] ?? '';
    $name = "maxsys_meta_tags_options[{$args['name']}]";

    switch ($args['type']) {
        case 'textarea':
            echo "<textarea name='{$name}' rows='3' style='width: 100%; max-width: 500px;'>" . esc_textarea($value) . "</textarea>";
            echo "<p class='description'>Keep under 160 characters for SEO.</p>";
            break;
        case 'image':
            echo "<div><input type='text' name='{$name}' id='image_url' value='" . esc_attr($value) . "' style='width: 100%; max-width: 500px;' readonly></div>";
            echo "<button type='button' class='button maxsys-meta-upload-button' data-target-id='image_url'>Upload/Select Image</button>";
            if ($value) echo "<p><img src='" . esc_url($value) . "' style='max-width: 200px; height: auto; margin-top:10px;'></p>";
            echo "<p class='description'>Recommended: 1200x630px JPG/PNG.</p>";
            break;
        default:
            echo "<input type='text' name='{$name}' value='" . esc_attr($value) . "' style='width: 100%; max-width: 500px;'>";
    }
}

function maxsys_meta_tags_options_page() {
    echo '<form action="options.php" method="post"><h2>Global Meta Tags</h2>';
    settings_fields('maxsysMetaTags');
    do_settings_sections('maxsysMetaTags');
    submit_button();
    echo '</form>';
}

// 3. Per-Page Meta Box
// ===================================
add_action('add_meta_boxes', 'maxsys_meta_tags_add_meta_box');
function maxsys_meta_tags_add_meta_box() {
    add_meta_box('maxsys_meta_tags', __('Custom Meta & Social Tags', 'maxsys-meta-tags'), 'maxsys_meta_tags_meta_box_render', ['page', 'post'], 'normal', 'high');
}

function maxsys_meta_tags_meta_box_render($post) {
    wp_nonce_field('maxsys_meta_tags_nonce', 'maxsys_meta_tags_nonce');
    ?>
    <p>
        <label for="maxsys_meta_title"><strong><?php _e('Meta Title', 'maxsys-meta-tags'); ?></strong></label><br>
        <input type="text" id="maxsys_meta_title" name="_maxsys_meta_title" value="<?php echo esc_attr(get_post_meta($post->ID, '_maxsys_meta_title', true)); ?>" style="width: 100%;">
    </p>
    <p>
        <label for="maxsys_meta_description"><strong><?php _e('Meta Description', 'maxsys-meta-tags'); ?></strong></label><br>
        <textarea id="maxsys_meta_description" name="_maxsys_meta_description" rows="3" style="width: 100%;"><?php echo esc_textarea(get_post_meta($post->ID, '_maxsys_meta_description', true)); ?></textarea>
    </p>
    <p>
        <label for="maxsys_meta_image"><strong><?php _e('Social Sharing Image (OG Image)', 'maxsys-meta-tags'); ?></strong></label><br>
        <input type="text" id="maxsys_meta_image" name="_maxsys_meta_image" value="<?php echo esc_attr(get_post_meta($post->ID, '_maxsys_meta_image', true)); ?>" style="width: 100%;" readonly>
        <button type="button" class="button maxsys-meta-upload-button" data-target-id="maxsys_meta_image">Upload/Select Image</button>
    </p>
    <?php
}

add_action('save_post', 'maxsys_meta_tags_save_meta');
function maxsys_meta_tags_save_meta($post_id) {
    if (!isset($_POST['maxsys_meta_tags_nonce']) || !wp_verify_nonce($_POST['maxsys_meta_tags_nonce'], 'maxsys_meta_tags_nonce')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    update_post_meta($post_id, '_maxsys_meta_title', sanitize_text_field($_POST['_maxsys_meta_title'] ?? ''));
    update_post_meta($post_id, '_maxsys_meta_description', sanitize_textarea_field($_POST['_maxsys_meta_description'] ?? ''));
    update_post_meta($post_id, '_maxsys_meta_image', esc_url_raw($_POST['_maxsys_meta_image'] ?? ''));
}

// 4. Enqueue Admin Scripts for Media Uploader
// ===================================================
add_action('admin_enqueue_scripts', 'maxsys_meta_tags_enqueue_admin_scripts');
function maxsys_meta_tags_enqueue_admin_scripts($hook) {
    // Only load on the relevant admin pages
    if ($hook === 'settings_page_maxsys_meta_tags' || $hook === 'post.php' || $hook === 'post-new.php') {
        wp_enqueue_media();
        wp_enqueue_script('maxsys-meta-tags-admin', plugin_dir_url(__FILE__) . 'admin.js', ['jquery'], '1.0', true);
    }
}
/**
 * 5. Disable WordPress oEmbed Discovery Links in the Header
 *
 * This prevents services like Facebook from prioritizing oEmbed data over our
 * custom Open Graph (OG) meta tags, resolving title conflicts.
 *
 */
function maxsys_hub_disable_oembed_discovery() {
    // Remove the oEmbed discovery links
    remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);
    // Optional: Also remove the REST API link, which is often not needed for the front-end
    remove_action('wp_head', 'rest_output_link_wp_head', 10);
}
add_action('after_setup_theme', 'maxsys_hub_disable_oembed_discovery');