<?php

/**
 * Секция «Услуги в …» на лендинге города (single-gorod.php, CPT gorod).
 */

if (!is_singular('gorod')) {
    return;
}

$city_id = get_queried_object_id();
if ($city_id <= 0) {
    return;
}

$city_title = get_the_title($city_id);

$services_query = new WP_Query([
    'post_type'      => 'services',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
    'meta_query'     => [
        [
            'key'     => 'gorod_city',
            'value'   => $city_id,
            'compare' => '=',
            'type'    => 'NUMERIC',
        ],
    ],
]);
?>

<section class="catalog catalog--city-services">
    <div class="container">
        <div class="catalog__hint hint">Услуги в <?php echo esc_html($city_title); ?></div>
        <h2 class="catalog__title title">
            <?php echo wp_kses('Выберите <span class="color-accent">вашу ситуацию</span>', ['span' => ['class' => []]]); ?>
        </h2>
        <p class="catalog__subtitle subtitle">Нажмите на услугу — расскажем подробно что входит и&nbsp;сколько стоит</p>

        <?php if ($services_query->have_posts()) : ?>
            <div class="city-page__services-grid">
                <?php
                while ($services_query->have_posts()) :
                    $services_query->the_post();
                    get_template_part('templates/components/card', 'service-city');
                endwhile;
                wp_reset_postdata();
                ?>
            </div>
        <?php else : ?>
            <p class="city-page__empty subtitle">Для этого города пока не добавлены услуги — уточните детали у менеджера.</p>
        <?php endif; ?>
    </div>
</section>