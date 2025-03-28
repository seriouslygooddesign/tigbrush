<?php
// Remove wordpress css variables
remove_action('wp_enqueue_scripts', 'wp_enqueue_global_styles');
remove_action('wp_body_open', 'wp_global_styles_render_svg_filters');

// Remove Emoji
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

// Remove rss feed links
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'feed_links', 2);

// Disable wlwmanifest link
remove_action('wp_head', 'wlwmanifest_link');

// Remove Really Simple Discovery Link
remove_action('wp_head', 'rsd_link');


function custom_redirects()
{
    if (IS_CURRENT_USER_ROLE_ADMINISTRATOR) return;

    $portal_page_id = get_field('portal_page', 'options');
    $portal_login_page_id = get_field('portal_login_page', 'options');
    $ancestors = get_post_ancestors(get_the_ID());

    if (!is_user_logged_in() && (in_array($portal_page_id, $ancestors) || is_page($portal_page_id))) {
        wp_redirect(get_permalink($portal_login_page_id));
        exit;
    }
}
add_action('template_redirect', 'custom_redirects');
