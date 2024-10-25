<?php
$args = wp_parse_args($args, [
    'icon' => '',
    'icon_holder' => true,
    'label' => '',
    'url' => '',
    'target_blank' => false,
    'aria_label' => '',
    'wrap' => false,
    'wrap_tag' => 'p',
    'noopener_noreferrer' => false
]);
extract($args);

$attributes = '';

//icon
if ($icon) {
    $icon = get_core_icon($icon, null, $icon_holder);
}

//url
if (str_contains($url, 'mailto:') || str_contains($url, 'tel:')) {
    $url = esc_attr($url);
} else {
    $url = esc_url($url);
}
$attributes .= "href='$url'";

//target blank
if ($target_blank) $attributes .= " target='_blank'";

//aria label
if ($aria_label) $attributes .= " aria-label='" . esc_html($aria_label) . "'";

//wrap
$before = $wrap ? "<$wrap_tag>" : null;
$after = $wrap ? "</$wrap_tag>" : null;

//rel
if ($noopener_noreferrer) $attributes .= " rel='noopener noreferrer'";
$label_start = $url ? "<a class='icon-label' $attributes>" : "<span class='icon-label'>";
$label_end = $url ? "</a>" : "</span>";
echo  "{$before}{$label_start}{$icon}" . esc_html($label) . "{$label_end}{$after}";
