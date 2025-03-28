<?php
$args = wp_parse_args(
    $args,
    array(
        'modifier' => null,
        'class' => null,
        'height' => get_core_height(),
        'container' => get_core_container_width(),
    )
);
extract($args);

//Modifier
if ($modifier) {
    $modifier = CONTENT_BLOCK_MODIFIER . $modifier;
}

$outer_class = get_core_filter_implode([
    CONTENT_BLOCK_CLASS,
    $modifier,
    $height,
    get_core_spacer(),
    get_core_color_text_white(),
    $class
]);

$content_class = get_core_filter_implode([
    CONTENT_BLOCK_CONTENT,
    $container
]);

$block_id = get_core_block_settings()['id'] ?? null;
$id = $block_id ? " id='$block_id'" : null;
?>
<div<?= $id; ?> class="<?= $outer_class ?>">
    <?php get_template_part('components/background'); ?>
    <div class="<?= wp_kses_post($content_class); ?>">