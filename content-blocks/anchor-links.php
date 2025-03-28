<?php
global $content_block_settings;
$block_args = [
    'modifier' => basename(__FILE__, '.php'),
];
get_template_part('components/block', 'start', $block_args);
?>
<div class="container">
    <div class='category-menu'>
        <?php
        foreach ($content_block_settings as $content_block_id):
            $anchor = $content_block_id['id'];
            $title = $content_block_id['title'];
            echo $title ? "<div class='category-menu__item'><a href='#$anchor' class='category-menu__link'>$title</a></div>" : null;
        ?>
        <?php endforeach; ?>
    </div>
</div>
<?php
get_template_part('components/block', 'end');
