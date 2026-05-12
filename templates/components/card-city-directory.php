<?php

/**
 * Карточка города в каталоге (page-gorod.php).
 * Аргументы: get_template_part(..., ['city_post' => WP_Post]) — в шаблоне доступны как $args (WP 5.5+).
 */

$city_post = isset($args['city_post']) ? $args['city_post'] : null;
if (!$city_post instanceof WP_Post) {
    return;
}

$cid = (int) $city_post->ID;
$distance = get_post_meta($cid, 'gorod_distance', true);
$price_num = function_exists('theme_gorod_display_min_price') ? theme_gorod_display_min_price($cid) : 0;
$link = get_permalink($city_post);
if (!$link) {
    return;
}
?>

<a href="<?php echo esc_url($link); ?>" class="city-dir-card">
    <span class="city-dir-card__name"><?php echo esc_html(get_the_title($city_post)); ?></span>
    <?php if ($distance) : ?>
        <span class="city-dir-card__distance"><?php echo esc_html($distance); ?></span>
    <?php endif; ?>
    <?php if ($price_num > 0) : ?>
        <span class="city-dir-card__price">от&nbsp;<?php echo esc_html(format_service_price($price_num)); ?>&nbsp;₽</span>
    <?php endif; ?>
</a>