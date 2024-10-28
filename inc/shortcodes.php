<?php
$contacts = array(
    'phone' => 'phone',
    'fax' => 'fax',
    'email' => 'email',
    'address' => 'pin',
    'hours' => 'clock',
);

foreach ($contacts as $key => $icon) {
    add_shortcode($key, function ($atts, $content) use ($key, $icon) {

        $default_office_id = get_field('main_office', 'office-options')[0]
            ?? (get_posts(['post_type' => 'office', 'numberposts' => 1])[0]->ID ?? null);

        $office_args = shortcode_atts(['office' => ''], $atts);
        $office_id = $office_args['office'] ? get_page_by_path($office_args['office'], OBJECT, 'office')->ID : $default_office_id;

        $field = get_field($key, $office_id);

        $shortcode_args = shortcode_atts(array(
            'wrap' => 'true',
            'link' => $field['link'] ?? '',
            'label' => $field['label'] ?? '',
            'icon' => $icon
        ), $atts);

        extract($shortcode_args);

        if (!$link && $key !== 'hours') return;

        $wrap = $wrap === 'true' ? true : false;
        $label = $content ?: $label;

        $link = match ($key) {
            'phone' => "tel:$link",
            'fax' => "tel:$link",
            'email' => "mailto:" . antispambot($link, 1),
            default => $link
        };
        $args = [
            'icon' => $icon,
            'label' => $label,
            'url' => $link,
            'wrap' => $wrap,
            'icon_holder' => false,
            'target_blank' => in_array($key, ['email', 'address']),
            'noopener_noreferrer' => $key === "address",
        ];
        ob_start();
        get_template_part('components/icon-label', null, $args);
        return ob_get_clean();
    });
}

add_shortcode('map', 'map');
function map()
{
    return "<div class='site-map'>" . get_field('address')['map'] . "</div>";
}

add_shortcode('social-icons', 'social_icons');
function social_icons()
{
    ob_start();
    get_template_part('components/social-icons');
    return ob_get_clean();
}

add_shortcode('cta-link', 'cta_link');
function cta_link()
{
    $link = get_field('cta_link', 'option');
    if ($link) {
        $link_url = esc_url($link['url']);
        $link_title = esc_html($link['title']);
        $link_target = $link['target'] ? esc_attr($link['target']) : '_self';
        return "<a class='button' href='$link_url' target='$link_target'>$link_title</a>";
    }
}

add_shortcode('contact-info', 'contact_info');
function contact_info($atts)
{
    $atts = shortcode_atts(['office' => ''], $atts);

    $default_office_id = get_field('main_office', 'office-options')[0]
        ?? (get_posts(['post_type' => 'office', 'numberposts' => 1])[0]->ID ?? null);

    $office_id = $atts['office']
        ? get_page_by_path($atts['office'], OBJECT, 'office')->ID
        : $default_office_id;

    $icon = get_core_image(get_field('icon', $office_id), IMG_SIZE_XS, 'icon');
    $title = get_core_tag(get_the_title($office_id), 'html', '<strong class="uppercase">', '</strong>');

    $email = do_shortcode("[email icon='' office='$atts[office]']");
    $phone = do_shortcode("[phone icon='' office='$atts[office]']");
    $fax = do_shortcode("[fax icon='' office='$atts[office]']");
    $hours = do_shortcode("[hours icon='' office='$atts[office]']");
    $address = do_shortcode("[address icon='' office='$atts[office]']");

    $header = "<div class='hstack align-items-center gap-3'>$icon$title</div>";
    $body = "$email$phone$fax$hours$address";

    return "<div class='vstack gap-3 element-my'>$header$body</div>";
}


add_shortcode('year', 'year_shortcode');
function year_shortcode()
{
    return date('Y');
}

function widget_shortcode()
{
    ob_start();
    if (is_active_sidebar('widget-login')) {
        dynamic_sidebar('widget-login');
    }
    return ob_get_clean();
}
add_shortcode('widget', 'widget_shortcode');

add_shortcode('site-login', 'site_login');
function site_login()
{
    $output = '';
    if (!is_user_logged_in()) {
        $output .= "<div class='element-my text-center'>" . get_custom_logo() . "</div>";
        $output .= '<div class="text-white text-center"><br>';
        $output .= '<h1 class="h3">Distributor Portal</h1>';
        $output .= '<p>Login to your account</p>';
        $output .= '</div>';
    }
    return $output . "<div class='content-box'>" . do_shortcode("[wppb-login]") . "</div>";
}
