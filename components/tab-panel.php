<?php
$args = wp_parse_args($args, [
    'unique_id' => 1,
    'i' => 1,
    'content' => get_sub_field('text')
]);

extract($args);

$class = $i === 1 ? ' element-visible' : null;
?>

<div id="tabpanel-<?= $unique_id; ?>" role="tabpanel" class="tab__content element-hidden<?= $class; ?>" aria-labelledby="tab-<?= $unique_id; ?>">
    <div class="tabs__content"><?= $content ?></div>
</div>