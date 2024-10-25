<?php

$block_args = [
    'modifier' => basename(__FILE__, '.php'),
    'class' => 'container',
];
get_template_part('components/block', 'start', $block_args);
$posts = get_sub_field('offices');
?>
<div class="row gy-6">
    <?php foreach ($posts as $post):
        $slug = get_post($post)->post_name;
    ?>
        <div class="col-md">
            <?= do_shortcode('[map]'); ?>
            <div class="hstack align-items-center gap-4 element-my">
                <?= get_core_image(get_field('icon'), IMG_SIZE_XS, 'icon icon--lg'); ?>
                <?php the_title('<h3 class="h4 ">', '</h3>') ?>
            </div>
            <div class="row gy-2">
                <div class="col-xl-5 vstack gap-2">
                    <?= do_shortcode("[email office='$slug' wrap='']"); ?>
                    <?= do_shortcode("[phone office='$slug' wrap='']"); ?>
                </div>
                <div class="col-xl-5 offset-xl-1 vstack gap-2">
                    <?= do_shortcode("[hours office='$slug' wrap='']"); ?>
                    <?= do_shortcode("[address office='$slug' wrap='']"); ?>
                </div>
            </div>
        </div>
    <?php
    endforeach;
    ?>
</div>
<?php
get_template_part('components/block', 'end'); ?>