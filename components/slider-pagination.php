<?php
$args = wp_parse_args($args, [
    'class' => null,
]);
extract($args);
?>

<div class="swiper-pagination <?= $class ?>" data-swiper-pagination></div>