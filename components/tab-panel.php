<?php
// Get the field
$group = get_sub_field('group');
$type = $text = '';
$gallery = [];

if (!empty($group) && is_array($group)) {
    ['type' => $type, 'text' => $text, 'gallery' => $gallery] = $group;
}

ob_start();
get_template_part('components/slider-thumbs', null, ['images' => $gallery]);
$slider = ob_get_clean();

$args = wp_parse_args($args, [
    'unique_id' => 1,
    'i' => 1,
    'content' => $type === 'content' ? $text : $slider,
]);

extract($args);

$class = $i === 1 ? ' element-visible' : null;
?>

<div id="tabpanel-<?= $unique_id; ?>" role="tabpanel" class="tab__content element-hidden<?= $class; ?>" aria-labelledby="tab-<?= $unique_id; ?>">
    <div class="tabs__content"><?= $content ?></div>
</div>