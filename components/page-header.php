<?php
$args = wp_parse_args($args,    [
    'title' => get_sub_field('title_type') === 'custom_title' ? get_sub_field('title') : (!is_archive() ? get_the_title() : get_the_archive_title()),
    'content' => get_sub_field('custom_content'),
    'description' => get_sub_field('description'),
    'height' => 'min-height-sm',
    'img_id' => !is_archive() ? (get_field('featured_image_landscape') ?? get_post_thumbnail_id()) : null,
    'img_lazy' => false,
]);
extract($args);

$block_name = CONTENT_BLOCK_CLASS . ' ' . CONTENT_BLOCK_MODIFIER . basename(__FILE__, '.php');
$block_class = get_core_filter_implode([
    $block_name,
    'text-white',
    'bg-primary-light',
    $height,
]);
?>
<div class="<?= $block_class;  ?>">
    <div class="<?= CONTENT_BLOCK_CONTENT; ?> container section-py" data-animate>
        <?php get_template_part('components/breadcrumbs'); ?>
        <h1><?= esc_html(strip_tags($title)); ?></h1>
        <?php if ($description !== 'none') {
            echo $description === 'excerpt' ? get_the_excerpt() : $content;
        } ?>
    </div>
</div>
<?php
if ($img_id) {
    echo "<div class='page-header-image'>";

    $img_args = [
        'curtain' => false,
        'img_id' => $img_id,
        'img_lazy' => $img_lazy,
    ];
    get_template_part('components/background-image', null, $img_args);
    echo "</div>";
}
?>