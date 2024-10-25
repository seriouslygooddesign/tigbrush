<?php
$block_args = [
	'modifier' => basename(__FILE__, '.php'),
];
get_template_part('components/block', 'start', $block_args);
$swiper_parameters = json_encode([
	"spaceBetween" => 0,
	"slidesPerView" => 1,
	"autoHeight" => false,
	"effect" => "fade",
	"loop" => true,
	"autoplay" => [
		"delay" => 3500,
	],
]);
$aligh = get_core_vertical_align();

if (have_rows('slides')) : ?>
	<div class="swiper swiper--hero-slider h-100" data-swiper='<?= $swiper_parameters; ?>'>
		<div class="swiper-wrapper">
			<?php while (have_rows('slides')) : the_row(); ?>
				<div class="swiper-slide h-100">
					<div class="row gx-0 h-100" data-animate>
						<div class="col-md pos-rel order-md-1">
							<?= get_core_image(get_sub_field('image'), IMG_SIZE_XL, '', true, false) ?>
						</div>
						<div class="col-md d-flex <?= get_core_filter_implode([$aligh]) ?>">
							<div class="container-md section-py">
								<?= get_sub_field('content') ?>
							</div>
						</div>
					</div>
				</div>
			<?php endwhile; ?>
		</div>
		<?php get_template_part('components/slider-pagination', null, ['class' => 'swiper-pagination--inside']) ?>
	</div>
<?php
endif;
get_template_part('components/block', 'end');
