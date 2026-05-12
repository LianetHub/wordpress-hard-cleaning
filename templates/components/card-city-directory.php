<?php

/**
 * Карточка города в каталоге (page-gorod.php).
 * Аргументы: get_template_part(..., ['city_post' => WP_Post]) — в шаблоне доступны как $args (WP 5.5+).
 *
 * ACF на CPT gorod (имена полей):
 * - gorod_distance_km (Number) → «N км от Санкт-Петербурга»;
 * - gorod_price_from (Number) → блок цены; иначе расчёт theme_gorod_display_min_price().
 */

$city_post = isset($args['city_post']) ? $args['city_post'] : null;
if (!$city_post instanceof WP_Post) {
    return;
}

$cid = (int) $city_post->ID;

$distance_label = function_exists('theme_gorod_distance_label') ? theme_gorod_distance_label($cid) : '';

$price_num = 0;
if (function_exists('get_field')) {
    $price_raw = get_field('gorod_price_from', $cid);
    if ($price_raw !== null && $price_raw !== '') {
        $price_num = (int) preg_replace('/[^\d]/', '', (string) $price_raw);
    }
}
if ($price_num <= 0 && function_exists('theme_gorod_display_min_price')) {
    $price_num = theme_gorod_display_min_price($cid);
}

$link = get_permalink($city_post);
if (!$link) {
    return;
}
?>

<a href="<?php echo esc_url($link); ?>" class="city-dir-card">
    <span class="city-dir-card__name"><?php echo esc_html(get_the_title($city_post)); ?></span>
    <?php if ($distance_label !== '') : ?>
        <span class="city-dir-card__distance"><?php echo esc_html($distance_label); ?></span>
    <?php endif; ?>
    <?php if ($price_num > 0) : ?>
        <span class="city-dir-card__price">от&nbsp;<?php echo esc_html(format_service_price($price_num)); ?>&nbsp;₽</span>
    <?php endif; ?>
</a>
