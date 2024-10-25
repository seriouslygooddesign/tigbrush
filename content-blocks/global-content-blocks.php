<?php
$global_content_blocks = get_sub_field('global_content_blocks');
if (!$global_content_blocks) return;
$block_args = [
    'modifier' => basename(__FILE__, '.php')
];
get_template_part('components/block', 'start', $block_args);
foreach ($global_content_blocks as $object_id) {
    get_template_part('components/content-blocks', null, ['object_id' => $object_id, 'is_first_content_block_check' => false]);
}
get_template_part('components/block', 'end');
