<?php
//Automatically convert all filenames on upload to lowercase
add_filter('sanitize_file_name', 'mb_strtolower');

//Remove WordPress Version Number
add_filter('the_generator', '__return_empty_string');

//Getting rid of archive "prefix"
function my_theme_archive_title($title)
{
    if (is_category()) {
        $title = single_cat_title('', false);
    } elseif (is_tag()) {
        $title = single_tag_title('', false);
    } elseif (is_author()) {
        $title = get_the_author();
    } elseif (is_post_type_archive()) {
        $title = post_type_archive_title('', false);
    } elseif (is_tax()) {
        $title = single_term_title('', false);
    }
    return $title;
}
add_filter('get_the_archive_title', 'my_theme_archive_title');


//Read More
function new_excerpt_more($more)
{
    return '...';
}
add_filter('excerpt_more', 'new_excerpt_more');


//Excerpt Length
add_filter('excerpt_length', function () {
    return 20;
});


//Add attributes to the script tags
function add_attributes_to_script_tag($html)
{
    if (!is_admin()) {
        if (strpos($html, '-defer-')) {
            $html = str_replace('></script>', ' defer></script>', $html);
        }
        if (strpos($html, '-async-')) {
            $html = str_replace('></script>', ' async></script>', $html);
        }
    }
    return $html;
}
add_filter('script_loader_tag', 'add_attributes_to_script_tag', 10);

//Disable wpo-plugins-tables-list.json file
add_filter('wpo_update_plugin_json', '__return_false');

//Rename "Default template" to "Content Blocks"
add_filter('default_page_template_title', function () {
    return 'Content Blocks';
});

//Custom gallery
add_filter('post_gallery', 'custom_gallery', 10, 2);
function custom_gallery($output, $attr)
{
    $images = get_posts([
        'post_type' => 'attachment',
        'include' => $attr['ids'],
        'orderby' => $attr['orderby'] ?? 'post__in'
    ]);
    if ($images) {

        $slides_per_view = isset($attr['columns']) ? intval($attr['columns']) : 3;
        $size = $attr['size'] ?? IMG_SIZE_XS;
        $link = $attr['link'] ?? 'attachment';
        $link_none = $link === 'none';
        $swiper_parameters = [
            "slidesPerView" => 1,
            "spaceBetween" => 20,
            "loop" => true,
            "autoHeight" => true,
        ];
        if ($slides_per_view >= 4) {
            $swiper_parameters["slidesPerView"] = 2;
            $swiper_parameters["breakpoints"][640]["slidesPerView"] = round($slides_per_view / 2);
            $swiper_parameters["breakpoints"][1024]["slidesPerView"] = $slides_per_view;
        } elseif ($slides_per_view === 3) {
            $swiper_parameters["breakpoints"][640]["slidesPerView"] = 2;
            $swiper_parameters["breakpoints"][1024]["slidesPerView"] = 3;
        } elseif ($slides_per_view === 2) {
            $swiper_parameters["breakpoints"][640]["slidesPerView"] = $slides_per_view;
        }

        $swiper_parameters = json_encode($swiper_parameters);
        $output = "<div class='swiper swiper--center' data-swiper='$swiper_parameters'><div class='swiper-wrapper'>";

        foreach ($images as $image) {
            $image_id = $image->ID;
            $output .= "<div class='swiper-slide text-center'>";
            if (!$link_none) {
                $href = get_attachment_link($image_id);
                $target = '_self';
                if ($link === 'file') {
                    $href = wp_get_attachment_image_src($image->ID, $size)[0];
                    $target = '_blank';
                }
                $output .= "<a href='$href' target='$target'>";
            }
            $output .= wp_get_attachment_image($image_id, $size);
            if (!$link_none) {
                $output .= "</a>";
            }
            $output .= "</div>";
        }

        $output .= "</div><br>"; //swiper-wrapper
        ob_start();
        get_template_part('components/slider-controls');
        $slider_controls = ob_get_clean();
        $output .= $slider_controls;
        $output .= "</div>"; //swiper
    }

    return $output;
}

//Exclude post type from WordPress link builder
function exclude_post_type_from_link_builder($query)
{
    $cpts_to_remove = [
        'main-popup',
        'global-content-block',
    ];
    foreach ($cpts_to_remove as $cpt) {
        $key = array_search($cpt, $query['post_type']);
        if ($key) {
            unset($query['post_type'][$key]);
        }
    }
    return $query;
}
add_filter('wp_link_query_args', 'exclude_post_type_from_link_builder');


//Removes or edits the 'Protected:' part from titles
add_filter('protected_title_format', 'remove_protected_text');
function remove_protected_text()
{
    return __('%s');
}

//Add class 'menu-link' to all <a> in wp_nav_menu()
function add_extra_class_to_menu_link($atts, $item, $args, $depth)
{
    $class = 'menu-link';
    $atts['class'] = isset($atts['class']) ? $atts['class'] . " " . $class : $class;
    return $atts;
}
add_filter('nav_menu_link_attributes', 'add_extra_class_to_menu_link', 10, 4);

//Add "loading" to wp_get_attachment_image, get_the_post_thumbnail and the_post_thumbnail 
function add_lazy_loading_to_images($attr, $attachment, $size)
{
    if (!isset($attr['loading'])) {
        $attr['loading'] = 'lazy';
    }
    return $attr;
}
add_filter('wp_get_attachment_image_attributes', 'add_lazy_loading_to_images', 10, 3);

//Admin panel menu order
function core_custom_menu_order($menu_ord)
{
    if (!$menu_ord) return true;
    return array(
        'index.php',
        'edit.php?post_type=page',
        'edit.php',
        'upload.php',
        'separator1',
    );
}
add_filter('custom_menu_order', 'core_custom_menu_order', 10, 1);
add_filter('menu_order', 'core_custom_menu_order', 10, 1);
