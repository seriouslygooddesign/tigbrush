<?php
global $is_first_content_block;
$args = wp_parse_args($args, [
    'img_id' => get_post_thumbnail_id(),
    'img_size' => IMG_SIZE_3XL,
    'img_lazy' => $is_first_content_block ? false : true,
    'curtain' => false,
]);
extract($args);
if (!$img_id) return;
echo get_core_image($img_id, $img_size, null, true, $img_lazy);
if ($curtain) get_template_part('components/curtain');
