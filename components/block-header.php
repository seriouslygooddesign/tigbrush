<?php
$args = wp_parse_args(
	$args,
	[
		'show' => get_sub_field('block_header_show'),
		'content' => get_sub_field('block_header'),
		'link' => get_sub_field('block_header_link'),
		'class' => false,
	]
);
extract($args);
if (!$show) return;
$class_result = $class ? " class='$class'" : '';
$content = get_core_tag($content, 'content');
$link = get_core_link($link, 'button', '<div class="col-auto offset-md-2"><p>', '</p></div>');
echo "<div$class_result data-animate><div class='row'><div class='col'>$content</div>$link</div></div><br>";
