<?php
$args = wp_parse_args($args, [
    'id' => null
]);
extract($args);
$id = $id ? "='$id'" : '';
?>
<div class="d-flex align-items-center justify-content-center gap-3 swiper__controls">
    <button type="button" aria-label="Previous slide" class="button button--square button--outline element-my-sm" data-swiper-button-prev<?= $id; ?>>
        <?= get_core_icon('chevron', 'rotate-90') ?>
    </button>
    <button type="button" aria-label="Next slide" class="button button--square button--outline element-my-sm" data-swiper-button-next<?= $id; ?>>
        <?= get_core_icon('chevron', 'rotate-270') ?>
    </button>
</div>