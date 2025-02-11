<?php
$args = wp_parse_args($args, [
    'images' => null,
]);
extract($args);
if (!$images) return;

$slider_id = wp_unique_id();

$swiper_parameters = [
    "slidesPerView" => 1,
    "spaceBetween" => 20,
    "loop" => true,
    "autoHeight" => true,
    "thumbs" => ".swiper-$slider_id",
];

$thumbs_parameters = [
    "spaceBetween" => 10,
    "slidesPerView" => 8,
    "watchSlidesProgress" => true,
    "loop" => true,
];
?>
<div class='swiper swiper--center swiper--display' data-swiper='<?= json_encode($swiper_parameters) ?>'>
    <div class='swiper-wrapper'>
        <?php foreach ($images as $image) : ?>
            <div class='swiper-slide text-center'>
                <?php
                if ($image['type'] === 'video') :
                    echo wp_video_shortcode(['src' => $image['url']]);
                else :
                    echo get_core_image($image['ID'], IMG_SIZE_LG);
                endif; ?>
                <div class="swiper__controls">
                    <a class="button button--square button--outline element-my-sm" href="<?php echo esc_url($image['url']); ?>" aria-label="Download" download="">
                        <?= get_core_icon('download') ?>
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php get_template_part('components/slider-controls'); ?>
</div>

<div thumbsSlider="" class="element-my swiper swiper-<?= $slider_id ?>" data-swiper='<?= json_encode($thumbs_parameters) ?>'>
    <div class="swiper-wrapper">
        <?php foreach ($images as $image) :
            $image_id = $image['type'] === 'video' ? get_field('video_poster', $image["ID"]) : $image["ID"]
        ?>
            <div class='swiper-slide text-center'>
                <div class="ratio-1-1">
                    <div class="curtain stretch"></div>
                    <?= get_core_image($image_id, IMG_SIZE_XS, 'stretch') ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>