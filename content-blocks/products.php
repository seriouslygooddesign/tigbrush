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
                $image = $layout_row
                    ? get_field('featured_image_landscape', "term_$post->term_id") ?? get_field('featured_image', "term_$post->term_id")
                    : get_field('featured_image', "term_$post->term_id") ?? get_field('featured_image_landscape', "term_$post->term_id");

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
                    'content' => "<div class='vstack'>" . get_core_tag($post->name, 'html', '<h3 class="h5">', '</h3>') . get_core_tag($post->description, 'html', '<p>', '</p>') . "</div>",
                ];
            } else {
                setup_postdata($post);
                $prices = (CAN_SHOW_PRIVATE_ELEMENT && ($field = get_field_object('prices')['sub_fields'])) ? $field : null;

                $prices_list = '';
                if ($prices) {
                    $prices_list .= "<ul class='currency-list'>";
                    $i = 0;
                    foreach ($prices as $price) {
                        $price_name = $price['name'];
                        $price_field = get_field('prices')[$price_name];
                        if ($price_field) {
                            $active_class = $i === 0 ? " active" : null;
                            $prices_list .= "<li class='currency-list__item$active_class' data-price='$price_name'>";
                            $prices_list .= "<span class='fs-lg'>$price[prepend]" . get_field('prices')[$price_name] . "</span> <sup>INC. GST</sup>";
                            $prices_list .= "</li>";
                        }
                        $i++;
                    }
                    $prices_list .= "</ul>";
                }

                $content = "<div class='vstack gap-2'>" . get_core_tag(get_the_title(), 'html', '<h3 class="h5">', '</h3>');
                $content .= $prices_list;
                $content .= get_core_tag(strip_tags(apply_filters('the_content', get_the_excerpt($post))), 'html', "<span class='text-muted'>", "</span>");
                $content .= "</div>";

                $card_args = $layout_row ? [] : [
                    'link_title' => null,
                    'title' => null,
                    'img_ratio' => 'ratio-1-1',
                    'content' => $content,
                ];
            }
            $card_col = $count > 3 ? 'col-md-3' : 'col-md-4';
            if (!$layout_row) echo "<div class='$card_col$card_scheme_white' data-animate>";
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
