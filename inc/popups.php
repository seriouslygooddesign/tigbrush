<?php
$popups = false;
$popup_cpt_name = 'main-popup';

//Check if current page/post has popups
function get_core_popups()
{
    global $popups, $popup_cpt_name;
    $object_id = get_the_ID();
    $object_id_serialized = serialize((string)$object_id);
    $popups = get_posts([
        'post_type' => $popup_cpt_name,
        'meta_query' => [
            'relation' => 'OR',
            [
                //Find popups for current page/post
                'key'   => 'popup_location',
                'value' => $object_id_serialized,
                'compare' => 'LIKE'
            ],
            [
                //Find global popups
                'key'   => 'popup_location',
                'value' => '',
                'compare' => '='
            ],
        ],
        'fields' => 'ids'
    ]);
}
add_action('template_redirect', 'get_core_popups');

//If current page/post has popups enqueue JS and CSS 
function get_core_popups_enqueue()
{
    global $popups;
    if ($popups) {
        wp_enqueue_style('popup', get_core_enqueue_path('popup.css'), [], null);
        wp_enqueue_script('popup-async', get_core_enqueue_path('popup.js'), [], null, true);
    }
}
add_action('wp_enqueue_scripts', 'get_core_popups_enqueue');

//If current page/post has popups display them in footer
function display_core_popups()
{
    global $popups;
    if ($popups) {
        global $popup_cpt_name;
        foreach ($popups as $id) {
            $args = [
                'id' => "$popup_cpt_name-$id",
                'selector' => get_field('popup_trigger_selector', $id),
                'content' => apply_filters('the_content', get_the_content(false, false, $id)),
                'title' => get_field('popup_title', $id)
            ];
            get_template_part('components/popup', null, $args);
        }
    }
}
add_action('wp_footer', 'display_core_popups');
