<?php
$post_type = "merchandise";
$feed_type = get_sub_field('type');
$feed_type_select_posts = $feed_type === 'select';
$feed_type_latest_by_category = $feed_type === 'posts_by_category';
$feed_type_categories = $feed_type === 'categories';
$taxonomy = "$post_type-category";
$layout_row = get_sub_field('layout') === 'row' ? 'row' : null;

$args = wp_parse_args($args, [
    'post_type' => $post_type,
    'posts_per_page' => get_sub_field('posts_per_page') ?: 8,
    'post__in' => $feed_type_select_posts ? get_sub_field('merchandise') : [],
    'taxonomy' => $feed_type_latest_by_category ? $taxonomy : null,
    'terms' => $feed_type_latest_by_category ? get_sub_field('categories') : null,
    'card_scheme' => get_sub_field('card_scheme'),
    'card_scheme_white' => get_sub_field('card_scheme') === 'dark' ? ' text-white' : null,
]);
extract($args);

if ($feed_type_categories) {
    $posts = get_terms([
        'taxonomy' => $taxonomy,
        'include' => get_sub_field('categories'),
    ]);
} else {

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
}

if (empty($posts)) return;
$count = count($posts);

$block_args = [
    'modifier' => basename(__FILE__, '.php'),
];
get_template_part('components/block', 'start', $block_args); ?>
<div class="container">
    <?php get_template_part('components/block', 'header'); ?>
    <div class="row <?= $layout_row ? 'g-0' : 'g-3' ?>">
        <?php
        foreach ($posts as $post) {
            if ($feed_type_categories) {

                $landscape = get_field('featured_image_landscape', "term_$post->term_id");
                $portrait  = get_field('featured_image', "term_$post->term_id");

                $primary   = $layout_row ? $landscape : $portrait;
                $secondary = $layout_row ? $portrait : $landscape;

                $image = $primary ?: $secondary;

                if (!$image) {
                    $first_post = get_posts([
                        'post_type'      => 'merchandise',
                        'posts_per_page' => 1,
                        'tax_query'      => [
                            [
                                'taxonomy' => 'merchandise-category',
                                'terms'    => $post->term_id,
                                'field'    => 'term_id',
                            ]
                        ],
                    ]);

                    if (!empty($first_post)) {
                        $first_post_id = $first_post[0]->ID;
                        $image = get_post_thumbnail_id($first_post_id);
                    }
                }

                $card_args = $layout_row ? [
                    'title' => $post->name,
                    'image_id' => $image,
                    'link_url' => get_term_link($post),
                    'content' => get_core_tag($post->description, 'html', '<p>', '</p>'),
                ] : [
                    'link_title' => null,
                    'image_id' => $image,
                    'link_url' => get_term_link($post),
                    'img_ratio' => 'ratio-1-1',
                    'title' => null,
                    'card_scheme' => $card_scheme,
                    'content' => "<div class='vstack'>" . get_core_tag($post->name, 'html', '<h3 class="h5">', '</h3>') . get_core_tag($post->description, 'html', '<p>', '</p>') . "</div>",
                ];
            } else {
                setup_postdata($post);

                $content = "<div class='vstack gap-2'>" . get_core_tag(get_the_title(), 'html', '<h3 class="h5">', '</h3>');
                $content .= get_core_tag(strip_tags(apply_filters('the_content', get_the_excerpt($post))), 'html', "<span class='text-muted '>", "</span>");
                $content .= "</div>";

                $card_args = $layout_row ? [] : [
                    'link_title' => null,
                    'title' => null,
                    'img_ratio' => 'ratio-1-1',
                    'content' => $content,
                    'card_scheme' => $card_scheme,
                ];
            }
            if (!$layout_row) echo "<div class='col-sm-6 col-lg-3$card_scheme_white' data-animate>";
            get_template_part('components/card', $layout_row, $card_args);
            if (!$layout_row) echo '</div>';
        }

        if (!$feed_type_categories) {
            wp_reset_postdata();
        }
        ?>
    </div>
    <?php get_template_part('components/block', 'footer'); ?>
</div>
<?php get_template_part('components/block', 'end');
