<?php
$block_args = [
	'modifier' => basename(__FILE__, '.php'),
];
get_template_part('components/block', 'start', $block_args);
get_template_part('components/block', 'header');
$layout = get_sub_field('layout');

$row_class = get_core_filter_implode([
	'row',
	$layout === 'box' ? 'g-0' : 'g-3',
	get_core_items_per_row(),
	get_core_horizontal_align(null)
]);
$count = get_sub_field('items_per_row');
$card_scheme = get_sub_field('card_scheme');
if (have_rows('cards')) : ?>
	<div class="<?= $row_class; ?>">
		<?php while (have_rows('cards')) : the_row(); ?>
			<div class="col-12" data-animate>
				<?php
				$link_type_file = get_sub_field('link_type') === 'file';
				$link_field = $link_type_file ? get_sub_field('file') : get_sub_field('link');

				$link_title = $link_field ? ($link_type_file ? $link_field['subtype'] . ', ' . round($link_field['filesize'] / 1024) . 'kb' : $link_field['title']) : null;
				$link_url = $link_field['url'] ?? null;
				$link_target = $link_field['target'] ?? null;
				$media = get_sub_field('media');
				$card_args = [
					'layout' => $layout,
					'image_id' => $media['image'],
					'icon' => $media['icon'],
					'filtered_icon' => $media['filtered_icon'],
					'title' => get_sub_field('title'),
					'content' => get_sub_field('content'),
					'link_title' => $link_title,
					'link_url' => $link_url,
					'link_target' => $link_target,
					'img_size' => get_core_img_size($count),
					'img_ratio' => $media['aspect_ratio'] ?: 'ratio-4-3',
					'download' => $link_type_file,
					'card_scheme' => $card_scheme,
				];
				get_template_part('components/card', null, $card_args);
				?>
			</div>
		<?php endwhile; ?>
	</div>
<?php
endif;
get_template_part('components/block', 'footer');
get_template_part('components/block', 'end');
