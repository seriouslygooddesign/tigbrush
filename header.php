<?php
$cta_link_shortcode = do_shortcode('[cta-link]');
$social_icons_shortcode = do_shortcode('[social-icons]');
$phone_shortcode = do_shortcode('[phone wrap="false"]');
$logo = get_custom_logo();

$main_menu_slug = 'main-menu-1';
$has_main_menu = has_nav_menu($main_menu_slug);
$portal_menu_slug = 'portal-menu';
$has_portal_menu_slug = has_nav_menu($portal_menu_slug);
$has_overlay_menu = $has_main_menu;

$portal_page_url = get_permalink(get_field('portal_page', 'options'));
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php wp_head(); ?>
</head>

<body <?php body_class('has-sticky-footer preload'); ?>>
	<?php wp_body_open(); ?>

	<a class="skip-link" href="#main-content">Skip to main content</a>
	<?php get_template_part('components/announcement'); ?>
	<?php get_template_part('components/header-top') ?>
	<header class="main-header main-header--sticky underline-reverse bg-primary text-white">
		<div class="container-fluid">
			<div class="row align-items-center gx-2 gx-sm-3 main-header-space">
				<?php if ($logo) : ?>
					<div class="col d-flex"><?= $logo; ?></div>
				<?php endif; ?>

				<?php if ($has_portal_menu_slug) : ?>
					<div class="col-auto">
						<div class="dropdown portal" data-dropdown>
							<a href="<?= esc_url($portal_page_url) ?>" data-dropdown-toggler class="button">Portal <?= CAN_SHOW_ELEMENT ? get_core_icon('plus-sm', 'main-menu__icon main-menu__icon--dropdown') : null ?></a>
							<?php
							if (CAN_SHOW_ELEMENT) {
								wp_nav_menu(
									[
										'main_menu' => false,
										'theme_location' => $portal_menu_slug,
										'container' => false,
										'menu_class' => 'dropdown__menu'
									]
								);
							}
							?>
						</div>
					</div>
				<?php endif; ?>

				<div class="col-auto d-none d-md-block">
					<?= do_shortcode('[ivory-search id="2072" title="Custom Search Form"]') ?>
				</div>

				<div class="col-auto">
					<?= do_shortcode('[weglot_switcher]') ?>
				</div>

				<?php if ($has_overlay_menu) : ?>
					<div class="col-auto show-on-overlay-menu">
						<button type="button" class="toggler-button" aria-label="Show Menu" data-overlay-menu-toggler>
							<span class="toggler-button__label d-none d-sm-block">Menu</span>
							<?= get_core_icon('menu', 'toggler-button__icon'); ?>
						</button>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</header>
	<?php if ($has_overlay_menu) : ?>
		<div class="bg-primary-dark text-white main-header-bottom underline-reverse">
			<div class="container-fluid">
				<?php get_template_part('components/overlay-menu') ?>
			</div>
		</div>
	<?php endif; ?>

	<main id="main-content">
		<?php if (is_singular() && post_password_required()) : ?>
			<div class="container-md section-py" data-animate>
				<h1 class="h3"><?php the_title(); ?></h1>
				<?= get_the_password_form(); ?>
			</div>
			<?php
			get_footer();
			exit();
			?>
		<?php endif;
