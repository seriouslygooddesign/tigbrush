<?php
if (!CAN_SHOW_ELEMENT) return;

$feed_type = get_sub_field('feed_type');
$feed_type_price_list = $feed_type === 'price';

if ($feed_type_price_list) {
    $post_args = [
        'post_type' => 'price-list',
        'posts_per_page' => -1
    ];

    if (IS_CURRENT_USER_ROLE_INTERMEDIARY) {
        global $current_user;
        $current_user_id = $current_user->ID;
        $roles = get_field('roles', 'user_' . $current_user_id);
        $locations = get_field('locations', 'user_' . $current_user_id);
        $post_args['tax_query'] = [
            'relation' => 'AND',
            [
                'taxonomy' => 'role',
                'field' => 'term_id',
                'terms' => $roles,
                'operator' => 'IN'
            ],
            [
                'taxonomy' => 'location',
                'field' => 'term_id',
                'terms' => $locations,
                'operator' => 'IN'
            ]
        ];
    }
} else {
    $post_args = [
        'post_type' => 'marketing-asset',
        'posts_per_page' => -1
    ];
}
$posts = get_posts($post_args);

if (!$posts) return;

$block_args = [
    'modifier' => basename(__FILE__, '.php'),
];
get_template_part('components/block', 'start', $block_args);
get_template_part('components/block', 'header', ['class' => 'container']);
?>
<div class="container">
    <div class="row g-4">
        <?php foreach ($posts as $post): setup_postdata($post);
            $card_args = [
                'card_scheme' => 'white',
                'img_ratio' => 'ratio-1-1'
            ];
        ?>
            <div class='col-sm-6 col-lg-3' data-animate>
                <?php get_template_part('components/card', null, $card_args); ?>
            </div>
        <?php endforeach;
        wp_reset_postdata(); ?>
    </div>
</div>
<?php
get_template_part('components/block', 'end');
