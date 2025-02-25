<?php
get_header();
while (have_posts()) :
    $content = get_core_tag(get_the_excerpt(), 'html', '<p class="h6">', '</p>');
    $image = !get_field('hide_featured_image') ? get_core_image(get_field('featured_image_landscape'), IMG_SIZE_2XL) ?? null : null;
    $extra_content = '';
    if (IS_PRIVATE_MODE_ENABLED) {
        $form = get_field('single_product_form', 'merchandise-options');

        if ($form) {
            $prices = ($field = get_field_object('prices')['sub_fields']) ? $field : null;
            $prices_list = '';
            if ($prices) {
                foreach ($prices as $i => $price) {
                    $price_name = $price['name'];
                    $price_field = get_field('prices')[$price_name];
                    if ($price_field) {
                        $active_class = $i === 0 ? " active" : null;
                        $prices_list .= "<li class='currency-list__item$active_class' data-price='$price_name'>";
                        $prices_list .= "<span class='fs-lg'>$price[prepend]" . get_field('prices')[$price_name] . "</span> <sup>INC. GST</sup>";
                        $prices_list .= "</li>";
                    }
                }
                $prices_list = $prices_list ? "<ul class='currency-list'>$prices_list</ul>" : null;
            }
            $extra_content .= "<div class='col-12'><div class='card card--card card--white'>";
            $extra_content .= "<div class='card__content'>";
            $extra_content .= $prices_list;
            $extra_content .= do_shortcode($form);
            $extra_content .= "</div>";
            $extra_content .= "</div></div>";
        }
    } else if (!$image) {
        $extra_content = get_core_tag(get_core_image(get_post_thumbnail_id(), IMG_SIZE_SM), null, "<div class='col-lg-6'>", "</div>");
    }

    $page_header_args = [
        'img_id' => false,
        'content' => $content,
        'extra_content' => $extra_content,
    ];
    the_post();

    get_template_part('components/page-header', null, $page_header_args);
    echo get_core_tag($image, null, "<div class='container'>", "</div>");
    get_template_part('components/content-blocks');
endwhile;
get_footer();
