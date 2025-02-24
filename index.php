<?php
get_header();
$post_type = get_post_type();
if (in_array($post_type, ['industry', 'merchandise']) && is_post_type_archive($post_type)) {
	get_template_part('components/content-blocks', null, ['object_id' => "$post_type-options"]);
} else {
	if (is_author()) {
		get_template_part('components/author-details');
	} else {
		$page_header_args = [
			'title' => is_archive() ? get_the_archive_title() : get_the_title(get_option('page_for_posts', true)),
			'img_id' => is_home() || is_category() || is_tax() ? get_post_thumbnail_id(get_option('page_for_posts', true)) : null,
		];
		get_template_part('components/page-header', null, $page_header_args);
	}
?>
	<div class="bg-primary text-white">

		<div class="section-py">
			<?php
			if (is_home() || is_category()):
				$blog_page_link = get_permalink(get_option('page_for_posts'));
				$categories = get_categories();
			?>

				<div class="container-fluid">
					<ul class="menu-row">
						<li class="menu-row__item">
							<a href="<?php echo esc_url($blog_page_link); ?>" class="menu-row__link<?= !is_category() ? ' active' : null; ?>">
								All
							</a>
						</li>

						<?php foreach ($categories as $category):
							$category_link = get_category_link($category->term_id);
						?>
							<li class="menu-row__item">
								<a href="<?php echo esc_url($category_link); ?>" class="menu-row__link<?= is_category($category->term_id) ? ' active' : null ?>">
									<?php echo esc_html($category->name); ?>
								</a>
							</li>
							<li class="menu-row__item">
								<a href="<?php echo esc_url($category_link); ?>" class="menu-row__link<?= is_category($category->term_id) ? ' active' : null ?>">
									<?php echo esc_html($category->name); ?>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endif ?>

			<?php if (have_posts()) : ?>
				<div class="container">
					<div class="row gx-3 gy-4 row-cols-1 row-cols-sm-2 row-cols-lg-3">
						<?php while (have_posts()) : the_post(); ?>
							<div class="col" data-animate>
								<?php get_template_part('components/card-post'); ?>
							</div>
						<?php endwhile; ?>
					</div>
				</div>
				<?php get_template_part('components/pagination'); ?>
			<?php else : ?>
				<div class="container">
					<h2>Nothing Found</h2>
				</div>
			<?php endif; ?>
		</div>
	</div>
<?php
}
get_footer();
