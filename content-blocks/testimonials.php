<?php
$posts = get_sub_field('type') === 'select'
    ? get_sub_field('testimonials')
    : get_posts([
        'post_type' => 'testimonial',
    ]);
if (!$posts) return;

$block_args = [
    'modifier' => basename(__FILE__, '.php'),
];
get_template_part('components/block', 'start', $block_args);

$swiper_parameters = json_encode([
    "slidesPerView" => 1,
    "spaceBetween" => 10,
    "autoHeight" => true
]);

?>
<div class="container">
    <div class="swiper" data-swiper='<?= $swiper_parameters; ?>'>
        <div class="row align-items-center">
            <div class="col">
                <?php if (get_sub_field('block_header_show')) {
                    echo wp_kses_post(get_sub_field('block_header'));
                } ?>
            </div>
            <div class="col-auto">
                <?php get_template_part('components/slider-controls'); ?>
            </div>
        </div>
        <br>
        <div class="swiper-wrapper">
            <?php foreach ($posts as $post) : setup_postdata($post);
                $icon = get_core_image(get_post_thumbnail_id(), IMG_SIZE_XS, 'rounded-image icon icon--xl');
            ?>
                <div class="swiper-slide height-auto">
                    <div class="card-testimonial">
                        <div class="card-testimonial__content">
                            <br>
                            <?= get_core_tag(get_the_content(), 'content', "<em class='fs-2xl'>“", "”</em>") ?>
                        </div>
                        <hr class="m-0">
                        <div class="card-testimonial__bottom">
                            <div class="row align-items-center">
                                <?= get_core_tag($icon, null, "<div class='col-auto'>", "</div>") ?>
                                <div class="col vstack gap-2">
                                    <?= get_core_tag(get_field('subtitle'), 'html', "<strong class='fs-sm uppercase'>", "</strong>") ?>
                                    <?php the_title('<h3 class="h6">', '</h3>') ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            endforeach;
            wp_reset_postdata();
            ?>
        </div>
        <?php get_template_part('components/slider-pagination') ?>
    </div>
</div>
<?php
get_template_part('components/block', 'end');
