<?php

$args = array(
    'post_type' => 'merchandise',
    'posts_per_page' => 1,
);

$query = new WP_Query($args);

if ($query->have_posts()) {
    $query->the_post();
    $prices = get_field('prices');

    if ($prices) {
        $selectedCurrency = isset($_COOKIE['selectedCurrency']) ? strtoupper($_COOKIE['selectedCurrency']) : array_keys($prices)[0];

        echo "<div class='currency dropdown' data-currency>";
        echo "<span class='currency__label' data-currency-label>" . $selectedCurrency . "</span>";
        echo "<ul class='currency__dropdown dropdown__menu'>";

        foreach ($prices as $currency => $price) {
            $active_class = (strtolower($currency) === strtolower($selectedCurrency)) ? " active" : "";
            echo "<li class='currency__item'><button class='currency__button$active_class' data-currency-button='$currency'>" . strtoupper($currency) . "</button></li>";
        }
        echo "</ul>";
        echo "</div>";
    }
}

wp_reset_postdata();
