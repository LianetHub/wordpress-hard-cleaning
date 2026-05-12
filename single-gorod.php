<?php

/**
 * Лендинг одного города (тип записей gorod). Шаблон: single-{post_type}.php → single-gorod.php.
 */

get_header();

if (!have_posts()) {
    get_footer();
    return;
}

while (have_posts()) :
    the_post();

    $city_id = get_the_ID();

    $phone = get_field('phone', 'option');
    $phone_clean = $phone ? preg_replace('/[^\d+]/', '', $phone) : '';

    $distance = get_post_meta($city_id, 'gorod_distance', true);
    $kicker_custom = get_post_meta($city_id, 'gorod_kicker', true);
    $stats_suffix = get_post_meta($city_id, 'gorod_stats_suffix', true);

    if ($stats_suffix === '' || $stats_suffix === null) {
        $stats_suffix = 'выезд в день обращения';
    }

    if ($kicker_custom !== '' && $kicker_custom !== null) {
        $kicker = $kicker_custom;
    } else {
        $parts = ['Уборка в ' . get_the_title()];
        if ($distance) {
            $parts[] = function_exists('mb_strtoupper') ? mb_strtoupper($distance, 'UTF-8') : strtoupper($distance);
        }
        $kicker = implode(' • ', $parts);
    }

    $min_price = function_exists('theme_gorod_display_min_price') ? theme_gorod_display_min_price($city_id) : 0;

    $services_count_query = new WP_Query([
        'post_type'              => 'services',
        'post_status'            => 'publish',
        'posts_per_page'         => -1,
        'fields'                 => 'ids',
        'no_found_rows'          => false,
        'update_post_meta_cache' => false,
        'meta_query'             => [
            [
                'key'     => 'gorod_city',
                'value'   => $city_id,
                'compare' => '=',
                'type'    => 'NUMERIC',
            ],
        ],
    ]);
    $services_count = (int) $services_count_query->found_posts;

    $h1 = sprintf('Сложная уборка в %s', get_the_title());

    require_once TEMPLATE_PATH . '/components/breadcrumbs.php';
?>

    <section class="heading heading--city">
        <div class="heading__container container">
            <div class="heading__offer">
                <?php if ($kicker) : ?>
                    <div class="heading__hint hint"><?php echo esc_html(function_exists('mb_strtoupper') ? mb_strtoupper($kicker, 'UTF-8') : strtoupper($kicker)); ?></div>
                <?php endif; ?>
                <h1 class="heading__title title-lg"><?php echo esc_html($h1); ?></h1>
                <div class="heading__stats heading__stats--city">
                    <?php if ($services_count > 0) : ?>
                        <span class="heading__stat heading__stat--text"><?php echo esc_html($services_count . ' ' . russian_plural($services_count, ['услуга', 'услуги', 'услуг'])); ?></span>
                    <?php endif; ?>
                    <span class="heading__stat heading__stat--text"><?php echo esc_html($stats_suffix); ?></span>
                    <?php if ($min_price > 0) : ?>
                        <span class="heading__stat heading__stat--text">от&nbsp;<?php echo esc_html(format_service_price($min_price)); ?>&nbsp;₽</span>
                    <?php endif; ?>
                </div>
                <div class="heading__btns">
                    <?php if ($phone) : ?>
                        <a href="tel:<?php echo esc_attr($phone_clean); ?>" class="heading__btn btn btn-secondary icon-phone">Вызвать бригаду</a>
                    <?php endif; ?>
                    <a href="#callback" data-fancybox class="heading__btn btn btn-outline">Рассчитать стоимость</a>
                </div>
            </div>
        </div>
    </section>

<?php
    require_once TEMPLATE_PATH . '_city-services.php';
    require_once TEMPLATE_PATH . '_works-gorod.php';
    require_once TEMPLATE_PATH . '_faq.php';
    require_once TEMPLATE_PATH . '_cta.php';

endwhile;

get_footer();
