<?php
$post_type = "merchandise";
$feed_type = get_sub_field('type');
$feed_type_select_posts = $feed_type === 'select';
$feed_type_latest_by_category = !$feed_type_select_posts && get_sub_field('products_by_category');
$post__in = $feed_type_select_posts ? get_sub_field('products') : [];
$taxonomy = $feed_type_latest_by_category ? 'merchandise-category' : null;
$terms = $feed_type_latest_by_category ? get_sub_field('categories') : null;

$posts_args = [
    'post_type' => $post_type,
    'posts_per_page' => $posts_per_page,
    'order' => 'ASC',
    'tax_query' => ($taxonomy && $terms) ? [
        [
            'taxonomy' => $taxonomy,
            'terms' => $terms,
            'field' => 'term_id',
        ],
    ] : null,
];

if ($post__in) {
    $posts_args['posts_per_page'] = count($post__in);
    $posts_args['post__in'] = $post__in;
    $posts_args['orderby'] = 'post__in';
}

$posts = get_posts($posts_args);

if (empty($posts)) return;

$tabs = null;
$tab_panels = null;
$i = 1;
foreach ($posts as $post) : setup_postdata($post);
    $images = get_field('gallery');
    $content = null;
    if ($images):
?>
        <?php
        $unique_id = wp_unique_id();

        ob_start();
        get_template_part('components/tab', null, ['unique_id' => $unique_id, 'i' => $i, 'title' => get_the_title()]);
        $tabs .= ob_get_clean();

        ob_start();
        get_template_part('components/slider-thumbs', null, ['images' => $images]);
        $content .= ob_get_clean();

        ob_start();
        get_template_part('components/tab-panel', null, ['unique_id' => $unique_id, 'i' => $i, 'content' => $content]);
        $tab_panels .= ob_get_clean();
        ?>
    <?php
        $i++;
    endif;
    ?>
<?php endforeach;
wp_reset_postdata();

if (!$tabs || !$tab_panels) return;

$block_args = [
    'modifier' => basename(__FILE__, '.php'),
];
get_template_part('components/block', 'start', $block_args); ?>
<?php get_template_part('components/block', 'header'); ?>

<div class="tabs row gx-md-4 gx-xl-6" data-tabs>
    <div class="col-md-4" data-animate>
        <div class="tabs__tablist" role="tablist" data-tablist>
            <?= $tabs; ?>
        </div>
    </div>
    <div class="col-md" data-animate>
        <?= $tab_panels; ?>
    </div>
</div>
<?php get_template_part('components/block', 'end');
