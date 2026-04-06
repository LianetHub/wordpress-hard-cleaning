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

<section class="equipment-section">
    <div class="container">

        <div class="equipment-header">
            <h2 class="equipment-title">Оборудование и средства<br>для <span class="text-blue">сложных случаев</span></h2>

            <div class="equipment-tabs">
                <button type="button" class="equip-tab active" data-filter="equipment">Оборудование</button>
                <button type="button" class="equip-tab" data-filter="supplies">Средства и безопасность</button>
            </div>
        </div>

        <div class="equipment-grid">
            <?php foreach ($active_category as $item): ?>
                <article class="equip-card">
                    <div class="equip-card-image">
                        <img src="<?php echo esc_url($item['image']); ?>"
                            alt="<?php echo esc_attr($item['title']); ?>"
                            loading="lazy"
                            decoding="async"
                            draggable="false">
                    </div>
                    <div class="equip-card-content">
                        <h4><?php echo esc_html($item['title']); ?></h4>
                        <p><?php echo esc_html($item['descr']); ?></p>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>