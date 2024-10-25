<?php
get_header();
if (is_singular('industry')) {
	get_template_part('components/content-blocks');
} else {
	while (have_posts()) :
		the_post();
		$page_header_args = [
			'content' => get_post_type() === 'post' ? "<p>" . get_the_date() . "</p>" : null
		];
		get_template_part('components/page-header', null, $page_header_args);
?>
		<div class="container-md section-py fs-one-column" data-animate>
			<?php the_content(); ?>
		</div>
<?php
	endwhile;
	$post_args = [
		'class' => 'section-py bg-primary text-white',
		'post_type' => get_post_type(),
		'before_title' => "Related "
	];
	get_template_part('content-blocks/posts', null, $post_args);
}
get_footer();
