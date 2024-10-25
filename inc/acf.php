<?php
//Hide ACF menu and show it for specific users only
add_filter('acf/settings/show_admin', function () {
	$current_user_email = wp_get_current_user()->user_email;
	if (str_contains($current_user_email, '@sgd.com.au')) {
		return true;
	} else {
		return false;
	}
});

//Disable ACF shortcodes
function set_acf_settings()
{
	acf_update_setting('enable_shortcode', false);
}
add_action('acf/init', 'set_acf_settings');

//Convert "Block ID" field value to slug 
function sanitize_block_id_field($value, $post_id, $field)
{
	return sanitize_title($value);
}
add_filter('acf/update_value/name=block_id', 'sanitize_block_id_field', 10, 3);
