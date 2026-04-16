<?php
$price_factors = [
    [
        'id' => '01',
        'icon' => 'sizes.svg',
        'title' => 'Площадь объекта',
        'desc' => 'Чем больше помещение — тем больше времени и материалов. Считаем по площади пола.'
    ],
    [
        'id' => '02',
        'icon' => 'house-damage.svg',
        'title' => 'Степень повреждений',
        'desc' => 'Лёгкое задымление и полное выгорание — принципиально разный объём работ и химии.'
    ],
    [
        'id' => '03',
        'icon' => 'instruments.svg',
        'title' => 'Наличие демонтажа',
        'desc' => 'Если нужно снять обгоревшую отделку или испорченный пол — это отдельный прайс.'
    ],
    [
        'id' => '04',
        'icon' => 'trash.svg',
        'title' => 'Вывоз мусора',
        'desc' => 'Зависит от объёма — считаем кубометрами. Загрузка, вывоз и утилизация включены.'
    ],
    [
        'id' => '05',
        'icon' => 'car.svg',
        'title' => 'Срочность выезда',
        'desc' => 'Стандартный выезд — без доплат. Ночной или экстренный выезд — по согласованию.'
    ],
    [
        'id' => '06',
        'icon' => 'pin.svg',
        'title' => 'Удалённость объекта',
        'desc' => 'В пределах КАД — бесплатно. За КАД — доплата за выезд по согласованию.'
    ]
];
?>

<section class="price-formation">
    <div class="container">
        <span class="price-formation__hint hint">Ценообразование</span>
        <h2 class="price-formation__title title">От чего зависит <span class="color-accent">итоговая цена</span></h2>
        <p class="price-formation__subtitle subtitle">Закрываем уборку, дезинфекцию, запахи, просушку и вывоз — без поиска отдельных специалистов.</p>

        <ol class="price-formation__list">
            <?php foreach ($price_factors as $factor): ?>
                <li class="price-formation__card" data-number="<?= $factor['id'] ?>">
                    <div class="price-formation__card-content">
                        <div class="price-formation__card-icon">
                            <img
                                src="<?php echo get_template_directory_uri() ?>/assets/img/icons/<?= $factor['icon'] ?>"
                                alt="<?= htmlspecialchars($factor['title']) ?>">
                        </div>
                        <h3 class="price-formation__card-title"><?= htmlspecialchars($factor['title']) ?></h3>
                        <p class="price-formation__card-desc"><?= htmlspecialchars($factor['desc']) ?></p>
                    </div>
                </li>
            <?php endforeach; ?>
        </ol>
    </div>
</section>