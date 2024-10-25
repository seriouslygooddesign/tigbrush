<?php
$args = wp_parse_args($args, [
    'id' => '',
    'title' => '',
    'selector' => '',
    'content' => '',
]);
extract($args);
$popup_id_attr = $id ? 'id="' . esc_attr($id) . '" ' : '';

$title_id_attr = '';
$aria_labelledby = '';
if ($title && $id) {
    $title_id = "$id-title";
    $title_id_attr = 'id="' . esc_attr($title_id) . '" ';
    $aria_labelledby = 'aria-labelledby="' . esc_attr($title_id) . '" ';
}
?>
<div <?= $popup_id_attr; ?>role="dialog" aria-modal="true" <?= $aria_labelledby; ?>class="main-popup" data-popup data-popup-trigger-selector="<?= esc_attr($selector); ?>">
    <div class="main-popup__dialog">
        <div class="main-popup__main" data-popup-main>
            <div class="row g-0 justify-content-end">
                <?php if ($title) : ?>
                    <div class="main-popup__title-wrap col">
                        <h2 <?= $title_id_attr; ?>class="h5 mt-0"><?= esc_html($title); ?></h2>
                    </div>
                <?php endif; ?>
                <div class="col-auto">
                    <button class="button button--square button--transparent button--transparent-hover" aria-label="Close" type="button" data-popup-toggler-close>
                        <?= get_core_icon('close', 'toggler-button__icon'); ?>
                    </button>
                </div>
            </div>
            <div class="main-popup__body">
                <?= $content; ?>
            </div>
        </div>
    </div>
</div>