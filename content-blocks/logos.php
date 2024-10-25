<?php
$gallery = get_sub_field('gallery');
if (!$gallery) return;

$gallery_ids = implode(',', $gallery);
$count = count($gallery);
$columns = $count >= 6 ? 6 : $count;
$img_size = get_core_img_size($count);
$container = $count > 4 ? "-xl" : "";

$block_args = [
    'modifier' => basename(__FILE__, '.php'),
    'container' => null,
    'class' => 'overflow-hidden'
];
get_template_part('components/block', 'start', $block_args); ?>
<?php get_template_part('components/block', 'header', ['class' => 'container']); ?>
<div class="<?= get_core_container_width(); ?>" data-animate>
    <?php echo do_shortcode("[gallery ids='$gallery_ids' link='none' size='$img_size' columns='$columns']"); ?>
</div>
<?php get_template_part('components/block', 'footer', ['class' => 'container']); ?>
<?php get_template_part('components/block', 'end');
