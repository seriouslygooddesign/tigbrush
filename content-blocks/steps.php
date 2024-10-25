<?php
$block_args = [
	'modifier' => basename(__FILE__, '.php'),
];
get_template_part('components/block', 'start', $block_args);
$content = wp_kses_post(get_sub_field('content'));
if (have_rows('steps')) : ?>
	<div class="row">
		<div class="col-md-6" data-animate>
			<?= $content ?>
		</div>
		<div class="col offset-md-1">
			<div class="row g-3 text-white">
				<?php while (have_rows('steps')) : the_row();
					$i = get_row_index();
					$icon = get_core_icon('arrow-down', 'fs-xs');
					$card_args = [
						'title' => "$i step",
						'title_icon' => $icon,
						'content' => get_sub_field('content'),
						'link_url' => null
					];
					echo "<div class='col-12' data-animate='down' data-animate-delay='{$i}00'>";
					get_template_part('components/card', null, $card_args);
					echo "</div>";
				endwhile; ?>
			</div>
		</div>
	</div>
<?php
endif;
get_template_part('components/block', 'end');
