<?php
$process_steps = [
    [
        'icon'  => 'eye.svg',
        'title' => 'Осмотр и оценка',
        'desc'  => 'Согласуем сроки и удобное время выезда.'
    ],
    [
        'icon'  => 'drying.svg',
        'title' => 'Просушка помещений',
        'desc'  => 'Осушаем помещение и конструкции до безопасной влажности.'
    ],
    [
        'icon'  => 'bacterium.svg',
        'title' => 'Дезинфекция',
        'desc'  => 'Снижаем риски для здоровья и распространения бактерий.'
    ],
    [
        'icon'  => 'blot.svg',
        'title' => 'Удаление загрязнений',
        'desc'  => 'Убираем последствия ЧП и сложные загрязнения.'
    ],
    [
        'icon'  => 'smell.svg',
        'title' => 'Устранение запахов',
        'desc'  => 'Нейтрализуем стойкие запахи (гарь, сырость и др.).'
    ],
    [
        'icon'  => 'tools.svg',
        'title' => 'Подготовка к ремонту',
        'desc'  => 'Вывозим мусор и повреждённые предметы при необходимости.'
    ]
];

$final_steps = wp_is_mobile() ? $process_steps : array_merge($process_steps, $process_steps);
?>

<section class="process">
    <div class="container">
        <div class="process__header">
            <div class="process__main">
                <span class="process__hint hint">Процесс</span>
                <h2 class="process__title title">Что мы делаем <span class="color-accent">под ключ</span></h2>
                <p class="process__desc">Закрываем уборку, дезинфекцию, запахи, просушку и вывоз — без поиска отдельных специалистов.</p>
            </div>
            <div class="process__controls">
                <button type="button" aria-label="Назад" class="process__prev swiper-button-prev"></button>
                <button type="button" aria-label="Вперед" class="process__next swiper-button-next"></button>
            </div>
        </div>
        <div class="process__slider swiper">
            <div class="swiper-wrapper">
                <?php foreach ($final_steps as $step) : ?>
                    <div class="process__slide swiper-slide">
                        <div class="process__slide-icon">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/icons/<?php echo esc_attr($step['icon']); ?>" alt="icon">
                        </div>
                        <h4 class="process__slide-title"><?php echo esc_html($step['title']); ?></h4>
                        <p class="process__slide-desc"><?php echo esc_html($step['desc']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="process__slider-pagination swiper-pagination"></div>
        </div>
    </div>
</section>