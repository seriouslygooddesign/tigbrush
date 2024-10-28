<?php
$id = wp_unique_id();
$args = wp_parse_args(
    $args,
    [
        'layout' => 'card',
        'title' => get_the_title(),
        'image_id' => get_post_thumbnail_id(),
        'content' => apply_filters('the_content', get_the_excerpt()),
        'collapsed_content' => $collapsed_content = ($collapsed_content = get_sub_field('collapsed_content')) && $collapsed_content['enable'] ? $collapsed_content['content'] : null,
        'link_title' => 'Read More',
        'link_url' => get_permalink(),
        'link_target' => null,
        'icon' => get_sub_field('icon'),
        'filtered_icon' => false,
        'title_icon' => null,
        'img_size' => IMG_SIZE_SM,
        'img_ratio' => 'ratio-4-3',
        'download' => false,
        'card_scheme' => 'dark'
    ]
);
extract($args);
$filtered_icon = $filtered_icon ? 'card__icon' : null;
$download = $download && !$collapsed_content ? 'download' : null;
$content_has_link  = str_contains($content, '</a>') || str_contains($collapsed_content, '</a>');

$card_tag = 'div';
$card_scheme_class = $card_scheme ? " card--$card_scheme" : null;
$card_attributes = "class='card card--$layout$card_scheme_class' $download";

$link_attributes = null;

if ($link_url) {
    $link_attributes = sprintf(' href="%1$s"%2$s', esc_url($link_url), $link_target === '_blank' ? " target='_blank'" : null);
}

if (!$content_has_link && $link_url && !$collapsed_content) {
    $card_tag = 'a';
    $card_attributes .= $link_attributes;
};

echo "<$card_tag $card_attributes>";
?>
<?php if ($image_id) : ?>
    <div class="card__img <?= $img_ratio; ?>">
        <?= get_core_image($image_id, $img_size, null, true); ?>
    </div>
<?php endif; ?>
<?php if ($title || $icon) : ?>
    <div class="card__header">
        <?= get_core_image($icon, IMG_SIZE_XS, "icon icon--lg $filtered_icon") ?>
        <?= get_core_tag($title, 'html', '<h3 class="h5 card__title">', '</h3>') ?>
        <?= $title_icon ?>
    </div>
<?php endif; ?>
<?php if ($content || $collapsed_content) : ?>
    <div class="card__content-holder">
        <div class="card__content">
            <?php echo $content; ?>
        </div>
        <?php if ($collapsed_content): ?>
            <div class="card__collapsed" data-accordion-item>
                <button type="button"
                    id="card-collapsed-content-<?= $id ?>"
                    class="card__collapsed-button"
                    aria-expanded="false"
                    aria-label="Toggle content"
                    aria-controls="extra-content-<?= $id ?>"
                    data-accordion-toggler>
                    <?= get_core_icon('arrow-down', 'fs-sm card__collapsed-icon') ?>
                </button>
                <div id="extra-content-<?= $id ?>" class="element-hidden" role="region" aria-labelledby="card-collapsed-content-<?= $id ?>">
                    <div class="card__collapsed-content">
                        <?php echo wp_kses_post($collapsed_content); ?>
                    </div>
                </div>
            </div>
        <?php endif ?>
        <?php if ($link_title && $link_url && !$collapsed_content) :
            $card_link_tag = "div";
            $card_link_class = $layout === 'box' ? " button" : " text-muted";
            $card_link_attributes = "class='card__link$card_link_class'";
            if ($content_has_link) {
                $card_link_tag = "a";
                $card_link_attributes .= $link_attributes;
            };
            echo "<$card_link_tag $card_link_attributes>" . $link_title . "</$card_link_tag>";
        endif; ?>
    </div>
<?php endif; ?>
<?= "</$card_tag>";
