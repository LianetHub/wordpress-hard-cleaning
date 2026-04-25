<?php
$target_cat_ids = [6, 4, 5, 8, 10, 9];
$dynamic_prices = [];
$active_key = '';

foreach ($target_cat_ids as $cat_id) {
    $category = get_term($cat_id, 'service_cat');

    if (!$category || is_wp_error($category)) {
        continue;
    }

    $cat_slug = $category->slug;
    if (empty($active_key)) $active_key = $cat_slug;

    $icon_data = get_field('category_icon', $category);
    $icon_url = is_array($icon_data) ? $icon_data['url'] : $icon_data;

    $svg_icon = '';
    if ($icon_url) {
        $svg_icon = get_processed_svg($icon_url, 'currentColor');
    }

    $short_tagline = get_field('short_tagline', $category);

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

    $table_data = [];
    foreach ($cat_posts as $p) {
        $service_data = get_field('service_data_' . $p->ID, 'option');
        $price_raw = isset($service_data['service_price']) ? $service_data['service_price'] : get_field('service_price', $p->ID);
        $comment_raw = isset($service_data['service_comment']) ? $service_data['service_comment'] : get_field('service_comment', $p->ID);

        $table_data[] = [
            'price_name'    => $p->post_title,
            'price_link'    => get_permalink($p->ID),
            'price_value'   => $price_raw ? $price_raw : 'По запросу',
            'price_comment' => $comment_raw ? $comment_raw : $p->post_excerpt
        ];
    }

    $dynamic_prices[$cat_slug] = [
        'tab_title'    => $category->name,
        'tab_subtitle' => $short_tagline,
        'icon'         => $svg_icon,
        'header_title' => $category->name,
        'header_tags'  => $short_tagline,
        'link'         => get_term_link($category),
        'table'        => $table_data
    ];
}
?>

<section class="price-list">
    <div class="container">
        <div class="price-list__hint hint">Прайс-лист</div>
        <h2 class="price-list__title title">Цены на <span class="color-accent">все услуги</span></h2>
        <p class="price-list__subtitle subtitle">Выберите услугу — покажем детальный прайс</p>

        <div class="price-list__content">
            <aside class="price-list__tabs">
                <?php foreach ($dynamic_prices as $key => $item): ?>
                    <button class="price-list__tab <?= ($key === $active_key) ? 'is-active' : '' ?>"
                        data-target="<?= esc_attr($key) ?>">
                        <div class="price-list__tab-icon">
                            <?= $item['icon'] ?>
                        </div>
                        <div class="price-list__tab-info">
                            <span class="price-list__tab-title"><?= esc_html($item['tab_title']) ?></span>
                            <span class="price-list__tab-subtitle"><?= esc_html($item['tab_subtitle']) ?></span>
                        </div>
                    </button>
                <?php endforeach; ?>
            </aside>

            <div class="price-list__main">
                <?php foreach ($dynamic_prices as $key => $item): ?>
                    <div class="price-list__pane <?= ($key === $active_key) ? 'is-active' : '' ?>"
                        id="pane-<?= esc_attr($key) ?>"
                        style="<?= ($key === $active_key) ? '' : 'display: none;' ?>">

                        <div class="price-list__header">
                            <div class="price-list__header-info">
                                <div class="price-list__header-icon">
                                    <?= $item['icon'] ?>
                                </div>
                                <div class="price-list__header-content">
                                    <h3 class="price-list__header-title"><?= esc_html($item['header_title']) ?></h3>
                                    <p class="price-list__header-tags"><?= esc_html($item['header_tags']) ?></p>
                                </div>
                            </div>
                            <a href="<?= esc_url($item['link']) ?>" class="price-list__link">Подробнее об услуге <span>→</span></a>
                        </div>

                        <div class="custom-table">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Наименование</th>
                                        <th>Стоимость</th>
                                        <th>Комментарий</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($item['table'])): ?>
                                        <?php foreach ($item['table'] as $row): ?>
                                            <tr>
                                                <td data-label="Наименование">
                                                    <a href="<?= esc_url($row['price_link']); ?>" class="price__service-link">
                                                        <?= esc_html($row['price_name']); ?>
                                                    </a>
                                                </td>
                                                <td data-label="Стоимость" class="price__value">
                                                    от&nbsp;<?php echo format_service_price($row['price_value']); ?>&nbsp;₽
                                                </td>
                                                <td data-label="Комментарий" class="price__comment"><?= esc_html($row['price_comment']); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="3" style="text-align: center;">Услуги для данного города не найдены</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>