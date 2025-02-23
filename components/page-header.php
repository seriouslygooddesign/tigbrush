<?php
$term_id = is_tax() ? get_queried_object()->term_id : 0;
$term_featured_img = null;
if ($term_id) {
    $hide_featured_image = get_field('hide_featured_image', 'term_' . $term_id);
    $featured_image_id = get_field('featured_image', 'term_' . $term_id) ?: get_post_thumbnail_id();
    if (!$hide_featured_image) {
        $image_html = get_core_image($featured_image_id, IMG_SIZE_SM);
        $term_featured_img = get_core_tag($image_html, null, "<div class='col-lg-6'>", "</div>");
    }
}

$args = wp_parse_args(
    $args,
    [
        'title' => get_sub_field('title_type') === 'custom_title' ? get_sub_field('title') : (!is_archive() ? get_the_title() : get_the_archive_title()),
        'content' => get_sub_field('custom_content'),
        'description' => get_sub_field('description'),
        'height' => 'min-height-xs',
        'img_id' => !is_archive() ? (get_field('featured_image_landscape') ?? get_post_thumbnail_id()) : null,
        'img_lazy' => false,
        'extra_content' => is_tax() ? $term_featured_img : null,
    ]
);
extract($args);
$block_name = CONTENT_BLOCK_CLASS . ' ' . CONTENT_BLOCK_MODIFIER . basename(__FILE__, '.php');
$block_class = get_core_filter_implode([
    $block_name,
    'bg-primary-light',
    $height,
]);
$title_class = is_singular() ? "class='h2'" : '';
?>
<div class="<?= $block_class;  ?>">
    <div class="<?= CONTENT_BLOCK_CONTENT; ?> container section-py-half" data-animate>
        <div class="row align-items-center">
            <div class="col text-white">
                <?php get_template_part('components/breadcrumbs'); ?>
                <h1 <?= $title_class; ?>><?= esc_html(strip_tags($title)); ?></h1>
                <?php if ($description !== 'none') {
                    echo $description === 'excerpt' ? get_the_excerpt() : $content;
                } ?>
            </div>
            <?php if ((is_singular('merchandise') || is_tax()) && $extra_content): ?>
                <div class="col-md-5 offset-md-1 d-flex justify-content-center">
                    <?= $extra_content; ?>
                </div>
            <?php endif; ?>
        </div>
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