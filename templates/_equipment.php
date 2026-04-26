<?php
$equip_assets = get_template_directory_uri() . '/assets/';

$equipment_data = [
    'equipment' => [
        [
            'title' => 'Осушители воздуха',
            'descr' => 'Просушка помещений и конструкций после залива',
            'image' => $equip_assets . 'equip_1.png',
        ],
        [
            'title' => 'Озонаторы',
            'descr' => 'Работа со стойкими запахами (гарь, сырость)',
            'image' => $equip_assets . 'equip_2.png',
        ],
        [
            'title' => 'Пылеводососы',
            'descr' => 'Удаление воды и глубокой грязи',
            'image' => $equip_assets . 'equip_3.png',
        ],
        [
            'title' => 'Распылители',
            'descr' => 'Обработка труднодоступных зон',
            'image' => $equip_assets . 'equip_4.png',
        ],
    ],
    'supplies' => [
        [
            'title' => 'Защитные костюмы',
            'descr' => 'Полная изоляция кожи и одежды при хим. обработке',
            'image' => $equip_assets . 'safety_1.png',
        ],
        [
            'title' => 'Проф. химия',
            'descr' => 'Средства для удаления биозагрязнений и копоти',
            'image' => $equip_assets . 'safety_2.png',
        ],
    ]
];

$active_category = $equipment_data['equipment'];
?>


<section class="equipment">
    <div class="equipment__container container">
        <div class="equipment__header">
            <h2 class="equipment__title title">Оборудование и средства для <span class="color-accent">сложных случаев</span></h2>
            <div class="equipment__tabs">
                <button type="button" class="equipment__tab btn active" data-filter="equipment">Оборудование</button>
                <button type="button" class="equipment__tab btn" data-filter="supplies">Средства и безопасность</button>
            </div>
        </div>
        <div class="equipment__slider swiper">
            <ul class="swiper-wrapper">
                <?php foreach ($equipment_data as $category => $items): ?>
                    <?php foreach ($items as $item): ?>
                        <?php
                        $is_active = ($category === 'equipment');
                        ?>
                        <li class="equipment__card swiper-slide"
                            data-category="<?php echo esc_attr($category); ?>"
                            style="<?php echo $is_active ? '' : 'display: none;'; ?>">
                            <div class="equipment__card-image">
                                <img src="<?php echo esc_url($item['image']); ?>"
                                    alt="<?php echo esc_attr($item['title']); ?>"
                                    loading="lazy"
                                    decoding="async"
                                    draggable="false">
                            </div>
                            <div class="equipment__card-content">
                                <h4 class="equipment__card-caption"><?php echo esc_html($item['title']); ?></h4>
                                <p class="equipment__card-description"><?php echo esc_html($item['descr']); ?></p>
                            </div>
                        </li>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </ul>
            <div class="equipment__slider-pagination swiper-pagination"></div>
        </div>
    </div>
</section>