<?php
$secondary_menu_slug = 'main-menu-2';
$has_secondary_menu = has_nav_menu($secondary_menu_slug);
$offices = get_field('offices', 'options');
?>
<div class="main-header-top text-white underline-reverse">
    <div class="main-header-top__content">
        <div class="row align-items-center">
            <div class="col fs-sm">
                <div class="row fs-sm gx-md-5">
                    <?php foreach ($offices as $post):
                        $slug = get_post($post)->post_name;
                    ?>
                        <div class="col-auto">
                            <div class="row gx-2 align-items-center">
                                <div class="col-auto d-flex">
                                    <?php echo get_core_image(get_field('icon'), IMG_SIZE_XS, 'icon icon--lg'); ?>
                                </div>
                                <div class="col-auto vstack">
                                    <?= do_shortcode("[phone icon='' wrap='' office='$slug']") ?>
                                    <div class="text-muted">
                                        <?= do_shortcode("[hours icon='' wrap='' office='$slug']") ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <?php wp_reset_postdata(); ?>
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