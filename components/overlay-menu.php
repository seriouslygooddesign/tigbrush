<?php
$main_menu_slug = 'main-menu-1';
$cta_link_shortcode = do_shortcode('[cta-link]');
$social_icons_shortcode = do_shortcode('[social-icons]');
$phone_shortcode = do_shortcode('[phone wrap="false"]');
$secondary_menu_slug = 'main-menu-2';
$has_secondary_menu = has_nav_menu($secondary_menu_slug);
?>
<div class="overlay-menu" data-overlay-menu>
    <div class="overlay-menu__curtain" data-overlay-menu-toggler></div>
    <div class="overlay-menu__main">
        <div class="overlay-menu__container show-on-overlay-menu bg-primary-dark">
            <div class="row align-items-center">
                <div class="col ">
                    <div class="d-md-none">
                        <?= do_shortcode('[ivory-search id="2072" title="Custom Search Form"]') ?>
                    </div>
                </div>
                <div class="col-auto">
                    <button class="toggler-button" type="button" aria-label="Close Menu" data-overlay-menu-toggler>
                        <span class="toggler-button__label d-none d-sm-block">Close</span>
                        <?= get_core_icon('close', 'toggler-button__icon'); ?>
                    </button>
                </div>
            </div>
        </div>
        <div class="overlay-menu__body" data-overlay-menu-body>

            <?php
            wp_nav_menu(
                [
                    'main_menu' => true, //Custom parameter for inc/main-menu.php
                    'theme_location' => $main_menu_slug,
                    'container' => false,
                    'menu_class' => 'main-menu--primary'
                ]
            );
            ?>
            <?php if ($has_secondary_menu) : ?>
                <div class="d-lg-none">
                    <?php
                    wp_nav_menu(
                        [
                            'main_menu' => true, //Custom parameter for inc/main-menu.php
                            'theme_location' => $secondary_menu_slug,
                            'container' => false,
                        ]
                    ); ?>
                </div>
            <?php endif; ?>
            <div class="overlay-menu__container show-on-overlay-menu">
                <?= $social_icons_shortcode; ?>
            </div>
        </div>
    </div>
</div>