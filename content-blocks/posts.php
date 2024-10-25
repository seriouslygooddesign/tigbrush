<?php
$post_type = get_sub_field('post_type');
$feed_type = get_sub_field('feed_type');
$feed_type_latest_post = $feed_type === 'latest';
$feed_type_select_posts = $feed_type === 'select_posts';
$feed_type_latest_by_category = $post_type === 'post' && get_sub_field('posts_by_category');

$args = wp_parse_args($args, [
    'post_type' => $post_type,
    'posts_per_page' => $feed_type_latest_post && get_sub_field('posts_per_page') ? get_sub_field('posts_per_page') : -1,
    'post__in' => $feed_type_select_posts ? get_sub_field('posts') : [],
    'taxonomy' => $feed_type_latest_by_category ? 'category' : null,
    'terms' => $feed_type_latest_by_category ? get_sub_field('categories') : null,
    'title' => null,
    'items_per_row' => get_core_settings('items_per_row') ?? 3,
    'layout' => get_sub_field('layout'),
    'before_title' => 'Latest ',
    'component_name' => $post_type == 'industry' ? 'card' : 'card-post',
    'class' => null,
]);
extract($args);

if (!isset($title)) {
    $title =  $before_title . get_post_type_object($post_type)->label;
}

$posts_args = [
    'post_type' => $post_type,
    'posts_per_page' => $posts_per_page,
];

if ($post__in) {
    $posts_args['posts_per_page'] = count($post__in);
    $posts_args['post__in'] = $post__in;
    $posts_args['orderby'] = 'post__in';
}

if (is_singular($post_type)) {
    $posts_args['post__not_in'] = [get_the_ID()];
}

if ($taxonomy && $terms) {
    $posts_args['tax_query'] = [
        [
            'taxonomy' => $taxonomy,
            'terms'    => $terms,
            'field'    => 'term_id',
        ]
    ];
}

$posts = get_posts($posts_args);
if (empty($posts)) return;

$overflow_hidden_class = 'overflow-hidden';
$class = $class ? "$class $overflow_hidden_class" : $overflow_hidden_class;

$block_args = [
    'modifier' => basename(__FILE__, '.php'),
    'class' => $class
];
get_template_part('components/block', 'start', $block_args);
?>
<div class="container">
    <div class="row gx-3 align-items-end">
        <?php if (get_sub_field('block_header_show')) : ?>
            <?php get_template_part('components/block', 'header', ['class' => 'col']); ?>
        <?php else : ?>
            <div class="col" data-animate>
                <h2><?= esc_html($title); ?></h2>
            </div>
        <?php endif; ?>
        <?php
        $post_type_archive_link = get_post_type_archive_link($post_type);
        if (!is_post_type_archive($post_type) && $post_type_archive_link) : ?>
            <div class="col-auto" data-animate>
                <p><a href="<?= esc_url($post_type_archive_link); ?>" class="button">View All</a></p>
            </div>
        <?php endif; ?>
    </div>

    <div data-animate>
        <?php if ($layout === 'columns'): ?>

            <div class="row g-4 <?= get_core_items_per_row(); ?>">
                <?php foreach ($posts as $post) : setup_postdata($post);
                    $components_args['img_size'] = get_core_img_size($items_per_row);
                    $components_args['card_scheme'] = 'white';
                ?>
                    <div class="col-12">
                        <?php get_template_part("components/$component_name", null, $components_args); ?>
                    </div>
                <?php
                endforeach;
                wp_reset_postdata();
                ?>
            </div>

        <?php else:
            $tabletSlidesPerView = 2;
            $desktopSlidesPerView = $items_per_row;
            $swiper_parameters = json_encode([
                "spaceBetween" => 10,
                "slidesPerView" => 1,
                "breakpoints" => [
                    640 => [
                        "slidesPerView" => $tabletSlidesPerView,
                        "slidesPerGroup" => $tabletSlidesPerView,
                    ],
                    1024 => [
                        "slidesPerView" => $desktopSlidesPerView,
                        "slidesPerGroup" => $desktopSlidesPerView,
                        "spaceBetween" => 20,
                    ]
                ]
            ]);
        ?>
            <div class="swiper swiper--off-canvas" data-swiper='<?= $swiper_parameters; ?>'>
                <div class="swiper-wrapper">
                    <?php foreach ($posts as $post) : setup_postdata($post);
                        $components_args['img_size'] = get_core_img_size($items_per_row);
                        $components_args['card_scheme'] = 'white';
                    ?>
                        <div class="swiper-slide h-auto">
                            <?php get_template_part("components/$component_name", null, $components_args); ?>
                        </div>
                    <?php
                    endforeach;
                    wp_reset_postdata();
                    ?>
                </div>
                <br>
                <?php get_template_part('components/slider-controls'); ?>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php
get_template_part('components/block', 'end'); ?>