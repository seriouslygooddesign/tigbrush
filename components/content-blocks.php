<?php
global $content_block_settings;
$content_block_settings = [];
$args = wp_parse_args($args, [
	'field_name' => 'content_blocks',
	'object_id' => get_the_ID(),
	'is_first_content_block_check' => true,
]);
extract($args);

global $is_first_content_block;

if (have_rows($field_name, $object_id)) {
	while (have_rows($field_name, $object_id)) {
		the_row();
		if (get_core_hide_block()) {
			$block_settings = get_core_settings('block_settings');
			if ($block_settings && $block_settings['enable'] === true) {
				$content_block_settings[] = get_core_block_settings();
			}
		}
	}
	while (have_rows($field_name, $object_id)) {
		the_row();
		$is_first_content_block = $is_first_content_block_check && get_row_index() === 1 ? true : false;
		if (get_core_hide_block()) {
			get_template_part('content-blocks/' . get_row_layout());
		}
	}
}
