<?php
//Dropdown Structure
class Main_Menu_Dropdown extends Walker_Nav_Menu
{
    function start_lvl(&$output, $depth = 0, $args = array())
    {
        $parent_data = $args->parent_item;
        $parent_url = $parent_data->url;
        $parent_title = $parent_data->title;

        $menu_item_primary = null;
        if (wp_http_validate_url($parent_url)) {
            $target = $parent_data->target ?  " target='" . esc_attr($parent_data->target) . "'" : null;
            $url = $parent_data->url;
            $title = $parent_title;

            $rewrite_submenu_navigation_label = get_field('rewrite_submenu_navigation_label', $parent_data->id);
            if ($rewrite_submenu_navigation_label) {
                $enable = $rewrite_submenu_navigation_label['enable'];
                $label = $rewrite_submenu_navigation_label['label'];
                if ($enable && $label) {
                    $title = $label;
                }
            }

            $menu_item_primary = "<li class='main-menu__item main-menu__item--primary'><a class='main-menu__link' $target href='" . esc_url($url) . "'>" . strip_tags($title) . "</a></li>";
        }

        $icon = get_core_icon('chevron', 'main-menu__icon rotate-90');
        $menu_item_back = "<li class='main-menu__item main-menu__item--back'><button type='button' class='main-menu__dropdown-back' data-dropdown-toggler-back>" . $icon . "Back</button></li>";

        $output .= "<ul class='main-menu__dropdown-menu' data-dropdown-menu>\n$menu_item_back\n$menu_item_primary\n";
    }
    function end_lvl(&$output, $depth = 0, $args = array())
    {
        $output .= "</ul>\n";
    }

    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
    {
        $args->parent_item = (object) ['title' => $item->title, 'url' => $item->url, 'target' => $item->target, 'id' => $item->ID];
        $classes = isset($item->classes) ? $item->classes : false;
        if (is_array($classes) && in_array('menu-item-has-children',  $classes)) {
            $icon = get_core_icon('plus-sm', 'main-menu__icon main-menu__icon--dropdown');
            $item->title .= $icon;
        }
        parent::start_el($output, $item, $depth, $args, $id);
    }
}

function is_menu_item_has_children($item)
{
    $classes = isset($item->classes) ? $item->classes : false;
    if (is_array($classes) && in_array('menu-item-has-children', $classes)) {
        return true;
    }
    return false;
}

function is_main_menu($args)
{
    if (gettype($args) === 'object') {
        $args = (array) $args;
    }
    return isset($args['main_menu']) && $args['main_menu'] === true ? true : false;
}

function main_menu_parameters($args)
{
    if (is_main_menu($args)) {
        $main_menu_class = 'main-menu';
        $extra_menu_class = $args['menu_class'];
        $args['menu_class'] = $extra_menu_class ? "$main_menu_class $extra_menu_class" : $main_menu_class;
        $args['items_wrap'] =  '<ul id="%1$s" class="%2$s" data-main-menu>%3$s</ul>';
        $args['walker'] = new Main_Menu_Dropdown;
    }
    return $args;
}
add_filter('wp_nav_menu_args', 'main_menu_parameters');

add_filter('nav_menu_item_attributes', 'custom_nav_menu_item_attributes', 10, 4);
function custom_nav_menu_item_attributes($atts, $item, $args, $depth)
{
    if (is_main_menu($args)) {
        $atts['class'] .= ' main-menu__item';
        if (is_menu_item_has_children($item)) {
            $atts['class'] .= ' main-menu__dropdown';
            $atts['data-dropdown'] = true;
            $atts['data-dropdown-location'] = 'overlay-menu';
        }
    }
    return $atts;
}

add_filter('nav_menu_link_attributes', 'custom_nav_menu_link_attributes', 10, 4);
function custom_nav_menu_link_attributes($atts, $item, $args, $depth)
{
    if (is_main_menu($args)) {
        $class = 'main-menu__link';
        $atts['class'] = isset($atts['class']) ? $atts['class'] . " " . $class : $class;
        if (is_menu_item_has_children($item)) {
            $atts['data-dropdown-toggler'] = true;
        }
    }
    return $atts;
}

add_filter('wp_nav_menu_objects', 'custom_wp_nav_menu_objects', 10, 2);

function custom_wp_nav_menu_objects($items, $args)
{
    foreach ($items as &$item) {
        $icon = get_field('icon', $item);
        if ($icon) {
            $item->title = get_core_image($icon, IMG_SIZE_XS, 'icon fs-sm', false, false) . $item->title;
        }
    }
    return $items;
}

function generate_portal_dropdown($sorted_menu_items, $args)
{
    // We affect only the menu with location 'portal-menu'
    if ($args->theme_location !== 'portal-menu') {
        return $sorted_menu_items;
    }

    // If user is not logged in, remove child items
    if (!is_user_logged_in()) {
        $filtered_menu_items = array();
        foreach ($sorted_menu_items as $item) {
            // Keep only top-level items
            if ($item->menu_item_parent == 0) {
                // Remove 'menu-item-has-children' class if present
                $item->classes = array_diff($item->classes, array('menu-item-has-children'));
                $filtered_menu_items[] = $item;
            }
        }
        return $filtered_menu_items;
    }

    // If user is logged in, find the last top-level item
    $parent_id = 0;
    foreach ($sorted_menu_items as $item) {
        // If this is a top-level item, remember its ID
        if ($item->menu_item_parent == 0) {
            $parent_id = $item->ID;
        }
    }

    if ($parent_id) {
        // Create a new menu item object for the "Logout" link
        $logout_item = new stdClass();
        $logout_item->ID = 999999;
        $logout_item->db_id = 999999;
        $logout_item->menu_item_parent = $parent_id; // Make it a child of the last top-level item
        $logout_item->type = 'custom';
        $logout_item->object = 'custom';
        $logout_item->object_id = 999999;
        $logout_item->title = 'Logout';
        $logout_item->url = wp_logout_url(home_url());
        $logout_item->classes = array('menu-item--footer');
        $logout_item->xfn = '';
        $logout_item->target = '';
        $logout_item->attr_title = '';
        $logout_item->description = '';
        $logout_item->type_label = 'Custom Link';
        $logout_item->menu_order = 999999; // Large number so it appears last

        // These properties help avoid "Undefined property" notices
        $logout_item->current = false;
        $logout_item->current_item_ancestor = false;
        $logout_item->current_item_parent = false;
        $logout_item->post_type = 'nav_menu_item';

        $sorted_menu_items[] = $logout_item;
    }

    return $sorted_menu_items;
}
add_filter('wp_nav_menu_objects', 'generate_portal_dropdown', 10, 2);

function portal_menu_restrict_parents($menu_id, $menu_item_db_id, $args)
{
    // Get the menu object
    $menu_object = wp_get_nav_menu_object($menu_id);

    // Check if it's the 'portal-menu' menu
    if ($menu_object && $menu_object->slug === 'portal-menu') {
        // Get parent ID from the POST data
        $parent_id = isset($_POST['menu-item-parent-id'][$menu_item_db_id])
            ? (int) $_POST['menu-item-parent-id'][$menu_item_db_id]
            : 0;

        // If this item is top-level
        if ($parent_id === 0) {
            // Get all existing items in the menu
            $items = wp_get_nav_menu_items($menu_id);

            if ($items) {
                $top_level_count = 0;

                foreach ($items as $item) {
                    if ($item->menu_item_parent == 0 && $item->ID != $menu_item_db_id) {
                        $top_level_count++;
                    }
                }

                if ($top_level_count >= 1) {
                    remove_action('wp_update_nav_menu_item', 'portal_menu_restrict_parents', 10);

                    // Delete the menu item
                    wp_delete_post($menu_item_db_id, true);

                    add_action('admin_notices', function () {
                        echo '<div class="error"><p>You cannot add more than one top-level menu item to Portal Menu!</p></div>';
                    });
                }
            }
        }
    }
}
add_action('wp_update_nav_menu_item', 'portal_menu_restrict_parents', 10, 3);
