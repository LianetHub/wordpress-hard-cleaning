<?php
$phone = get_field('phone', 'option');
$phone_clean = $phone ? preg_replace('/[^\d+]/', '', $phone) : '';

$scenarios_assets = get_template_directory_uri() . '/assets/';

$scenarios = [
    [
        'title' => 'После пожара',
        'icon'  => $scenarios_assets . 'img/icons/fire.svg',
        'image' => $scenarios_assets . 'fire_cleaning.jpg',
        'image_alt' => 'Помещение после пожара',
        'tags'  => [
            ['text' => 'Удаление копоти и гари', 'link' => '#'],
            ['text' => 'Устранение запаха дыма', 'link' => '#'],
            ['text' => 'Очистка стен и потолков', 'link' => '#'],
            ['text' => 'Вывоз обгоревшей мебели', 'link' => '#'],
        ]
    ],
    [
        'title' => 'После потопа',
        'icon'  => $scenarios_assets . 'img/icons/flood.svg',
        'image' => $scenarios_assets . 'after3.webp',
        'image_alt' => 'Помещение после затопления',
        'tags'  => [
            ['text' => 'Озонирование (от сырости)', 'link' => '#'],
            ['text' => 'Обработка от грибка', 'link' => '#'],
            ['text' => 'Осушение мебели', 'link' => '#'],
            ['text' => 'Срочная просушка', 'link' => '#'],
        ]
    ],
    [
        'title' => 'Уборка после смерти',
        'icon'  => $scenarios_assets . 'img/icons/bones.svg',
        'image' => $scenarios_assets . 'after1.webp',
        'image_alt' => 'Деликатная уборка',
        'tags'  => [
            ['text' => 'Полная дезинфекция', 'link' => '#'],
            ['text' => 'Удаление биозагрязнений', 'link' => '#'],
            ['text' => 'Спецобработка очага', 'link' => '#'],
            ['text' => 'Устранение трупного запаха', 'link' => '#'],
        ]
    ],
    [
        'title' => 'Антисанитария',
        'icon'  => $scenarios_assets . 'img/icons/unsanitary.svg',
        'image' => $scenarios_assets . 'after4.webp',
        'image_alt' => 'Уборка антисанитарных помещений',
        'tags'  => [
            ['text' => 'Вынос мусора и хлама', 'link' => '#'],
            ['text' => 'Удаление стойких пятен', 'link' => '#'],
            ['text' => 'Дезинсекция', 'link' => '#'],
            ['text' => 'Дезинфекция поверхностей', 'link' => '#'],
        ],

    ]
];
?>

<section class="services">
    <div class="services__container container">
        <div class="services__hint hint">НАШ ОПЫТ</div>
        <h2 class="services__title title">С какими <span class="color-accent">ситуациями</span> мы работаем</h2>
        <ul class="services__list">
            <?php foreach ($scenarios as $item): ?>
                <li class="services__item">
                    <div class="services__item-body">
                        <div class="services__item-header">
                            <div class="services__item-icon" aria-hidden="true">
                                <img src="<?php echo esc_url($item['icon']); ?>" alt="">
                            </div>
                            <h3 class="services__item-title"><?php echo esc_html($item['title']); ?></h3>
                        </div>

                        <?php if (!empty($item['tags'])): ?>
                            <div class="services__item-tags">
                                <?php foreach ($item['tags'] as $tag): ?>
                                    <a href="<?php echo esc_url($tag['link']); ?>"
                                        class="services__item-tag">
                                        <?php echo esc_html($tag['text']); ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <a class="services__item-btn icon-phone"
                            href="tel:<?php echo $phone_clean; ?>">Вызвать бригаду</a>
                    </div>
                    <div class="services__item-image">
                        <img src="<?php echo esc_url($item['image']); ?>"
                            alt="<?php echo esc_attr($item['image_alt']); ?>"
                            width="482"
                            height="686"
                            loading="lazy"
                            decoding="async">
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
        <a href="" class="services__more btn btn-outline">Все услуги</a>
    </div>
</section>