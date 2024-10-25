<?php
$args = wp_parse_args($args, [
    'img_size' => IMG_SIZE_SM
]);
extract($args);
?>

<a href="<?php the_permalink(); ?>" class="card-post">
    <div class="card-post__img-holder bg-surface ratio-4-3">
        <?= get_core_image(get_post_thumbnail_id(), $img_size, 'card-post__img', true); ?>
    </div>
    <div class="card-post__content">
        <?= get_core_categories('name'); ?>
        <h3 class="card-post__title h6"><?php the_title(); ?></h3>
        <?php if (get_post_type() === 'post') : ?>
            <strong class="fs-sm text-muted uppercase"><?= get_the_date(); ?></strong>
        <?php else: ?>
            <div class="fs-sm"><?= apply_filters('the_content', get_the_excerpt()) ?></div>
        <?php endif; ?>
    </div>
</a>