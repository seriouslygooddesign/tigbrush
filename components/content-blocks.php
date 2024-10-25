<?php
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
		$is_first_content_block = $is_first_content_block_check && get_row_index() === 1 ? true : false;
		if (get_core_hide_block()) {
			get_template_part('content-blocks/' . get_row_layout());
		}
	}
}
