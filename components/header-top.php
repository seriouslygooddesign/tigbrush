<?php
$secondary_menu_slug = 'main-menu-2';
$has_secondary_menu = has_nav_menu($secondary_menu_slug);
?>
<div class="main-header-top text-white underline-reverse">
    <div class="main-header-top__content">
        <div class="row align-items-center">
            <div class="col">
                <div class="row">
                    <div class="col-auto">
                        <?= do_shortcode('[phone icon="" wrap=""]') ?>
                    </div>
                    <div class="col-auto">
                        <?= do_shortcode('[hours icon="" wrap=""]') ?>
                    </div>
                </div>
            </div>
            <?php if ($has_secondary_menu) : ?>
                <div class="col-auto d-none d-lg-block">
                    <?php
                    wp_nav_menu(
                        [
                            'main_menu' => true, //Custom parameter for inc/main-menu.php
                            'theme_location' => $secondary_menu_slug,
                            'container' => false,
                            'menu_class' => 'main-menu--secondary',
                        ]
                    ); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>