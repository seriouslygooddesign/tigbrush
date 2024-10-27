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
        <div class="col-md fw-600">
            <?= do_shortcode('[map]'); ?>
            <div class="hstack align-items-center gap-4 element-my">
                <?= get_core_image(get_field('icon'), IMG_SIZE_XS, 'icon icon--lg'); ?>
                <?php the_title('<h3 class="h4" style="margin-block: 0.5em">', '</h3>') ?>
            </div>
            <div class="row gy-3">
                <div class="col-xl-5 vstack gap-3">
                    <?= do_shortcode("[email office='$slug' wrap='']"); ?>
                    <?= do_shortcode("[phone office='$slug' wrap='']"); ?>
                    <?= do_shortcode("[fax office='$slug' wrap='']"); ?>
                </div>
                <div class="col-xl-5 offset-xl-1 vstack gap-3">
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