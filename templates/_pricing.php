<?php
$pricing_plans = [
    [
        'amount' => '2000',
        'title'  => 'Дезинфекция помещений',
        'descr'  => 'Уничтожение бактерий, вирусов и неприятных запахов',
        'link'   => '#'
    ],
    [
        'amount' => '3000',
        'title'  => 'Просушка помещений',
        'descr'  => 'Осушение стен, полов и предотвращение плесени',
        'link'   => '#'
    ],
    [
        'amount' => '4000',
        'title'  => 'Уборка после потопа',
        'descr'  => 'Удаление воды, следов затопления и просушка',
        'link'   => '#'
    ],
    [
        'amount' => '5000',
        'title'  => 'Уборка после смерти',
        'descr'  => 'Удаление биологических загрязнений и запахов',
        'link'   => '#'
    ],
    [
        'amount' => '7000',
        'title'  => 'Уборка после пожара',
        'descr'  => 'Очистка копоти, гари и подготовка к ремонту',
        'link'   => '#'
    ],
];

// Данные для синей карточки
$special_card = [
    'count' => '20',
    'min_price' => '2000',
    'link' => '#'
];
?>

<section class="pricing-section-new">
    <div class="container">

        <div class="pricing-header">
            <span class="price-kicker">Тарифы</span>
            <h2>Стоимость <span class="text-blue">услуг</span></h2>
            <p class="pricing-subtitle pricing-subtitle--desktop">Цена зависит от площади помещения и степени загрязнения</p>
            <p class="pricing-subtitle pricing-subtitle--mobile">Закрываем уборку, дезинфекцию, запахи, просушку и вывоз — без поиска отдельных специалистов.</p>
        </div>

        <div class="pricing-grid-new">
            <?php foreach ($pricing_plans as $plan): ?>
                <div class="price-card-regular">
                    <div class="price-val">
                        <span class="price-from">от</span>
                        <span class="price-amount"><?php echo esc_html($plan['amount']); ?></span>
                        <span class="price-currency">₽</span>
                    </div>
                    <div class="price-info">
                        <h4><?php echo esc_html($plan['title']); ?></h4>
                        <p><?php echo esc_html($plan['descr']); ?></p>
                    </div>
                    <a href="<?php echo esc_url($plan['link']); ?>" class="btn-price-outline">Подробнее</a>
                </div>
            <?php endforeach; ?>

            <article class="price-card-special" aria-label="Сводка по услугам и минимальному заказу">
                <div class="price-card-special__stats">
                    <div class="price-card-special__figure">
                        <p class="title-big">
                            <span class="title-big__num"><?php echo esc_html($special_card['count']); ?></span><span class="title-big__plus">+</span>
                        </p>
                    </div>
                    <div class="price-card-special__figure">
                        <p class="title-small">
                            <span class="title-small__prefix">от</span><span class="title-small__amount"><?php echo esc_html($special_card['min_price']); ?></span><span class="title-small__currency">₽</span>
                        </p>
                    </div>
                    <p class="text-muted">Услуг</p>
                    <p class="text-muted">Минимальный заказ</p>
                </div>
                <a href="<?php echo esc_url($special_card['link']); ?>" class="btn-price-solid button">Показать все цены</a>
            </article>

        </div>
    </div>
</section>