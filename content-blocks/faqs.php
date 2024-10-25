<?php
$posts = get_sub_field('faqs');

if (!$posts) return;

$block_args = [
    'modifier' => basename(__FILE__, '.php'),
];

$total = count($posts);
$faq_schema = get_sub_field('faq_schema');

get_template_part('components/block', 'start', $block_args);
get_template_part('components/block', 'header', ['class' => 'container']);
echo '<div class="container-fluid">';
foreach ($posts as $post) : setup_postdata($post);
    $accordion_args = [
        'title' => get_the_title(),
        'text' => wpautop(get_the_content()),
        'total' => $total,
        'current' => get_row_index(),
        'faq_schema' => $faq_schema
    ];
    get_template_part('components/accordion', null, $accordion_args);
endforeach;
wp_reset_postdata();
echo '</div>';

get_template_part('components/block', 'footer', ['class' => 'container']);
get_template_part('components/block', 'end');
