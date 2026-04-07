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

<section class="pricing">
    <div class="container">
        <span class="pricing__hint hint">Тарифы</span>
        <h2 class="pricing__title title">Стоимость <span class="color-accent">услуг</span></h2>
        <p class="pricing__subtitle">Цена зависит от площади помещения и степени загрязнения</p>
        <ul class="pricing__list">
            <?php foreach ($pricing_plans as $plan): ?>
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
                    <a href="<?php echo esc_url($plan['link']); ?>"
                        class="pricing-card__btn btn btn-outline">Подробнее</a>
                </li>
            <?php endforeach; ?>
            <li class="pricing-card pricing-card--special"
                aria-label="Сводка по услугам и минимальному заказу">
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
                <a href="<?php echo esc_url($special_card['link']); ?>"
                    class="btn btn-white btn-price-solid">
                    Показать все цены
                </a>
            </li>
        </ul>
    </div>
</section>