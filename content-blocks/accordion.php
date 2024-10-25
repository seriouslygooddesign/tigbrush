<?php
$block_args = [
    'modifier' => basename(__FILE__, '.php'),
    'container' => 'container-fluid'
];
get_template_part('components/block', 'start', $block_args);

$total = count(get_sub_field('accordion'));
get_template_part('components/block', 'header');

$faq_schema = get_sub_field('faq_schema');

if (have_rows('accordion')) :
    while (have_rows('accordion')) {
        the_row();
        $accordion_args = [
            'total' => $total,
            'current' => get_row_index(),
            'faq_schema' => $faq_schema
        ];
        get_template_part('components/accordion', null, $accordion_args);
    }
endif;

get_template_part('components/block', 'footer');
get_template_part('components/block', 'end');
