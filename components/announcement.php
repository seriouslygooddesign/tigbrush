<?php
$announcement = get_field('announcement', 'option');
if (!$announcement) return;

$enable = $announcement['enable'];
if (!$enable) return;

$content = $announcement['content'];
if (!$content) return;
?>
<div class="announcement">
    <div class="container fs-sm"><?= wp_kses_post($content); ?></div>
</div>