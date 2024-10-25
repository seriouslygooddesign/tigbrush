<?php
$block_args = [
	'modifier' => basename(__FILE__, '.php'),
	'container' => 'container',
	'class' => 'overflow-hidden'
];
$color_scheme = get_sub_field('сolor_scheme');
get_template_part('components/block', 'start', $block_args);
?>
<div class="row cta cta--<?= $color_scheme ?>">
	<div class="col-md order-md-1">
		<?= get_core_image(get_sub_field('image'), IMG_SIZE_LG, 'cta__image') ?>
	</div>
	<div class="col">
		<div class="cta__content">
			<?= get_sub_field('content') ?>
		</div>
	</div>
</div>
<?php get_template_part('components/block', 'end');
