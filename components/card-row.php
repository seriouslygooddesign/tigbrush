<?php
$args = wp_parse_args(
    $args,
    [
        'title' => get_the_title(),
        'image_id' => get_field('featured_image_landscape') ?? get_post_thumbnail_id(),
        'content' => apply_filters('the_content', get_the_excerpt()),
        'link_url' => get_permalink(),
    ]
);
extract($args);

?>

<div class="col-12 card-row">
    <div class="row align-items-center gy-4">
        <div class="col offset-md-1 order-md-1">
            <?= get_core_image($image_id, IMG_SIZE_XL) ?>
        </div>
        <div class="col-md-4">
            <?= get_core_tag($title, 'html', '<h3 class="h2 card-row__title">', '</h3>') ?>
            <?= get_core_tag($content, 'content', '<div class="h6 text-muted">', '</div>') ?>
            <a href="<?= $link_url ?>" class="button card-row__button">Learn More</a>
        </div>
    </div>
</div>