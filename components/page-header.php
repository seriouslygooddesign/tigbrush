<?php
$post_thumbnail_id = get_post_thumbnail_id();
$show_featured_image = get_sub_field('show_featured_image');
$extra_content_featured_image_condition = is_tax() || is_singular('merchandise');

$extra_content_featured_img = $featured_image_id = null;
if ($extra_content_featured_image_condition && $show_featured_image) {

    $term_id = is_tax() ? get_queried_object()->term_id : null;
    if ($term_id) {
        $tax_image_id = get_field('featured_image', 'term_' . $term_id);
    }
    $featured_image_id = $tax_image_id ?? $post_thumbnail_id;

    $extra_content_featured_img = get_core_tag(get_core_image($featured_image_id, IMG_SIZE_SM), null, "<div class='col-lg-6'>", "</div>");
}

$args = wp_parse_args(
    $args,
    [
        'title' => get_sub_field('title_type') === 'custom_title' ? get_sub_field('title') : (!is_archive() ? get_the_title() : get_the_archive_title()),
        'content' => get_sub_field('custom_content'),
        'description' => get_sub_field('description'),
        'height' => 'min-height-xs',
        'img_id' => !$extra_content_featured_image_condition && $show_featured_image ? (get_field('featured_image_landscape') ?? get_post_thumbnail_id()) : null,
        'img_lazy' => false,
        'extra_content' => $extra_content_featured_img,
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
            <div class="col text-white trim-margin">
                <?php get_template_part('components/breadcrumbs'); ?>
                <h1 <?= $title_class; ?>><?= esc_html(strip_tags($title)); ?></h1>
                <?php if ($description !== 'none') {
                    echo $description === 'excerpt' ? "<p class='h6'>" . get_the_excerpt() . "</p>" : $content;
                } ?>
            </div>
            <?php if ($extra_content) : ?>
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