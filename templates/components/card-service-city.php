<?php

/**
 * Карточка услуги на лендинге города (компактная сетка).
 */

$phone = get_field('phone', 'option');
$phone_clean = $phone ? preg_replace('/[^\d+]/', '', $phone) : '';

$sid = get_the_ID();
$title = get_the_title();
$link = get_permalink();

$prices_group = get_field('all_services_prices_list', 'option');
$service_data = $prices_group['service_data_' . $sid] ?? null;
$display_price = !empty($service_data['service_price']) ? $service_data['service_price'] : '';

$excerpt = has_excerpt() ? get_the_excerpt() : wp_trim_words(wp_strip_all_tags(get_the_content()), 22);

$icon_html = '';
$terms = get_the_terms($sid, 'service_cat');
if ($terms && !is_wp_error($terms)) {
    foreach ($terms as $t) {
        $icon_data = get_field('category_icon', $t);
        if ($icon_data) {
            $url = is_array($icon_data) ? ($icon_data['url'] ?? '') : $icon_data;
            if ($url) {
                $icon_html = get_processed_svg($url, 'currentColor');
                break;
            }
        }
    }
}
?>

<article class="city-service-card">
    <div class="city-service-card__head">
        <?php if ($icon_html) : ?>
            <div class="city-service-card__icon" aria-hidden="true"><?php echo $icon_html; ?></div>
        <?php endif; ?>
        <div class="city-service-card__main">
            <h3 class="city-service-card__title"><?php echo esc_html(fix_widows_after_prepositions($title)); ?></h3>
            <?php if ($display_price) : ?>
                <div class="city-service-card__price">от&nbsp;<?php echo esc_html(format_service_price($display_price)); ?>&nbsp;₽</div>
            <?php endif; ?>
        </div>
    </div>
    <?php if ($excerpt) : ?>
        <p class="city-service-card__text"><?php echo esc_html(fix_widows_after_prepositions($excerpt)); ?></p>
    <?php endif; ?>
    <div class="city-service-card__actions">
        <a href="<?php echo esc_url($link); ?>" class="btn btn-outline btn-sm city-service-card__more">Подробнее</a>
        <?php if ($phone) : ?>
            <a href="tel:<?php echo esc_attr($phone_clean); ?>" class="btn btn-secondary btn-sm icon-phone city-service-card__call">Вызвать бригаду</a>
        <?php endif; ?>
    </div>
</article>