<?php
$target_cat_ids = [10, 12, 5, 6, 4];

$custom_descriptions = [
    10 => 'Уничтожение бактерий, вирусов и неприятных запахов',
    12 => 'Осушение стен, полов и предотвращение плесени',
    5  => 'Удаление воды, следов затопления и просушка',
    6  => 'Удаление биологических загрязнений и запахов',
    4  => 'Очистка копоти, гари и подготовка к ремонту'
];

$ordered_pricing_plans = [];
$global_min_price = PHP_INT_MAX;

$all_services_in_spb = get_posts([
    'post_type'      => 'services',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    'meta_query'     => [
        [
            'key'     => 'current_city',
            'value'   => 'Санкт-Петербург',
            'compare' => '='
        ]
    ]
]);
$all_spb_services_count = count($all_services_in_spb);

foreach ($target_cat_ids as $cat_id) {
    $category = get_term($cat_id, 'service_cat');

    if (!$category || is_wp_error($category)) continue;

    $cat_posts = get_posts([
        'post_type'      => 'services',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'tax_query'      => [
            [
                'taxonomy' => 'service_cat',
                'field'    => 'term_id',
                'terms'    => $cat_id,
            ]
        ],
        'meta_query'     => [
            [
                'key'     => 'current_city',
                'value'   => 'Санкт-Петербург',
                'compare' => '='
            ]
        ]
    ]);

    $cat_min_price = PHP_INT_MAX;

    foreach ($cat_posts as $p) {
        $service_data = get_field('service_data_' . $p->ID, 'option');
        $price_raw = isset($service_data['service_price']) ? $service_data['service_price'] : '0';
        $price = intval(preg_replace('/[^0-9]/', '', $price_raw));

        if ($price > 0 && $price < $cat_min_price) {
            $cat_min_price = $price;
        }

        if ($price > 0 && $price < $global_min_price) {
            $global_min_price = $price;
        }
    }

    $ordered_pricing_plans[] = [
        'amount' => ($cat_min_price === PHP_INT_MAX) ? '0' : $cat_min_price,
        'title'  => $category->name,
        'descr'  => $custom_descriptions[$cat_id] ?? $category->description,
        'link'   => get_term_link($category)
    ];
}

if ($global_min_price === PHP_INT_MAX) {
    $global_min_price = 0;
}

$prices_page_obj = get_page_by_path('czeny');
$prices_page_url = $prices_page_obj ? get_permalink($prices_page_obj->ID) : home_url('/czeny/');

$special_card = [
    'count'     => $all_spb_services_count,
    'min_price' => $global_min_price,
    'link'      => $prices_page_url
];
?>

<section class="pricing">
    <div class="container">
        <span class="pricing__hint hint">Тарифы</span>
        <h2 class="pricing__title title">Стоимость <span class="color-accent">услуг</span></h2>
        <p class="pricing__subtitle">Цена зависит от площади помещения и степени загрязнения</p>
        <ul class="pricing__list">
            <?php foreach ($ordered_pricing_plans as $plan): ?>
                <li class="pricing-card">
                    <div class="pricing-card__value">
                        <span class="pricing-card__value-from">от</span>
                        <span class="pricing-card__value-amount"><?php echo esc_html($plan['amount']); ?></span>
                        <span class="pricing-card__value-currency">₽</span>
                    </div>
                    <div class="pricing-card__info">
                        <h4 class="pricing-card__caption"><?php echo esc_html($plan['title']); ?></h4>
                        <p class="pricing-card__description"><?php echo esc_html($plan['descr']); ?></p>
                    </div>
                    <a href="<?php echo esc_url($plan['link']); ?>" class="pricing-card__btn btn btn-outline">Подробнее</a>
                </li>
            <?php endforeach; ?>

            <li class="pricing-card pricing-card--special" aria-label="Сводка по услугам и минимальному заказу">
                <div class="pricing-card__stats">
                    <div class="pricing-card__figure">
                        <div class="pricing-card__figure-header">
                            <span class="pricing-card__value-amount"><?php echo esc_html($special_card['count']); ?></span>
                            <span class="pricing-card__value-currency">+</span>
                        </div>
                        <div class="pricing-card__figure-bottom">
                            Услуг
                        </div>
                    </div>
                    <div class="pricing-card__figure">
                        <div class="pricing-card__figure-header">
                            <span class="pricing-card__value-from">от</span>
                            <span class="pricing-card__value-amount"><?php echo esc_html($special_card['min_price']); ?></span>
                            <span class="pricing-card__value-currency">₽</span>
                        </div>
                        <div class="pricing-card__figure-bottom">
                            Минимальный заказ
                        </div>
                    </div>
                </div>
                <a href="<?php echo esc_url($special_card['link']); ?>" class="btn btn-white btn-price-solid">
                    Показать все цены
                </a>
            </li>
        </ul>
    </div>
</section>