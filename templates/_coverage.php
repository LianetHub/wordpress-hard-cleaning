<?php

/**
 * Данные о районах Санкт-Петербурга
 */
$districts = [
    [
        'name'   => 'Центральный',
        'desc'   => 'Исторический центр — приоритетная зона. Минимальное время ожидания.',
        'time'   => 'от 30–45 мин',
        'is_fast' => true
    ],
    [
        'name'   => 'Петроградский',
        'desc'   => 'Петроградская сторона, Крестовский остров, Чкаловская — быстрый выезд.',
        'time'   => 'от 30–45 мин',
        'is_fast' => true
    ],
    [
        'name'   => 'Адмиралтейский',
        'desc'   => 'Садовая, Сенная, Коломна — в приоритетной зоне выезда.',
        'time'   => 'от 30–50 мин',
        'is_fast' => true
    ],
    [
        'name'   => 'Василеостровский',
        'desc'   => 'В.О., Гавань, Морской вокзал — опытная бригада в вашем районе.',
        'time'   => 'от 35–55 мин',
        'is_fast' => true
    ],
    [
        'name'   => 'Невский',
        'desc'   => 'Весь Невский район, включая Рыбацкое и Обухово — без наценки.',
        'time'   => 'от 40–60 мин',
        'is_fast' => true
    ],
    [
        'name'   => 'Московский',
        'desc'   => 'Парк Победы, Купчино, Электросила — быстрый выезд без доплат.',
        'time'   => 'от 40–55 мин',
        'is_fast' => false
    ],
    [
        'name'   => 'Фрунзенский',
        'desc'   => 'Волковская, Международная, Купчино — в зоне быстрого реагирования.',
        'time'   => 'от 40–60 мин',
        'is_fast' => false
    ],
    [
        'name'   => 'Калининский',
        'desc'   => 'Гражданка, Академическая, Пискарёвка — работаем без наценок.',
        'time'   => 'от 40–60 мин',
        'is_fast' => false
    ],
    [
        'name'   => 'Выборгский',
        'desc'   => 'Лесной, Удельная, Озерки — полный охват района.',
        'time'   => 'от 45–65 мин',
        'is_fast' => false
    ],
    [
        'name'   => 'Приморский',
        'desc'   => 'Комендантский проспект, Коломяги, Озерки — выезжаем регулярно.',
        'time'   => 'от 50–70 мин',
        'is_fast' => false
    ],
    [
        'name'   => 'Кировский',
        'desc'   => 'Автово, Нарвская, Дачное — без доплат за выезд.',
        'time'   => 'от 50–70 мин',
        'is_fast' => false
    ],
    [
        'name'   => 'Красносельский',
        'desc'   => 'Красное Село, Горелово, Сосновая Поляна — выезд по договорённости.',
        'time'   => 'от 55–75 мин',
        'is_fast' => false
    ]
];


$phone = get_field('phone', 'option');
$phone_clean = $phone ? preg_replace('/[^\d+]/', '', $phone) : '';

?>

<section class="coverage-section">
    <div class="container">

        <span class="coverage__hint hint">Зона покрытия</span>
        <h2 class="coverage__title title">Где мы <span class="color-accent">работаем?</span></h2>
        <p class="coverage__desc subtitle">Выезжаем во все районы Санкт-Петербурга. Время прибытия — от 60 минут после звонка. Жмите на свой район — проверьте время выезда.</p>

        <div class="coverage__content">
            <div class="districts-grid">
                <?php foreach ($districts as $index => $district): ?>
                    <div class="district-card <?php echo $index === 0 ? 'active' : ''; ?>"
                        data-name="<?php echo esc_attr($district['name']); ?>"
                        data-desc="<?php echo esc_attr($district['desc']); ?>"
                        data-time="<?php echo esc_attr($district['time']); ?>">

                        <div class="district-top">
                            <h4><?php echo esc_html($district['name']); ?></h4>
                            <?php if ($district['is_fast']): ?>
                                <span class="badge-fast">Быстро</span>
                            <?php endif; ?>
                        </div>
                        <div class="district-time">
                            <svg width="18" height="21" viewBox="0 0 24 24" fill="none" stroke="#467E9E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                            <span><?php echo esc_html($district['time']); ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="coverage__info-mobile info-highlight-box">
                <?php
                $first = $districts[0];
                ?>
                <p class="district-card__details"><strong><?php echo esc_html($first['name']); ?> район</strong> — <?php echo esc_html($first['desc']); ?> <span class="text-blue fw-700">Время выезда: <?php echo esc_html($first['time']); ?></span></p>
            </div>

            <div class="coverage-bottom">
                <div class="coverage-info-left">
                    <div class="coverage__info-desktop info-highlight-box">
                        <?php
                        $first = $districts[0];
                        ?>
                        <p class="district-card__details"><strong><?php echo esc_html($first['name']); ?> район</strong> — <?php echo esc_html($first['desc']); ?> <span class="text-blue fw-700">Время выезда: <?php echo esc_html($first['time']); ?></span></p>
                    </div>

                    <div class="info-region-box">
                        <h4>Ленинградская область</h4>
                        <p>Выезжаем по предварительному звонку — стоимость уточняется индивидуально.</p>
                        <span class="region-cities">Гатчина · Всеволожск · Выборг · Тосно · Кириши · Сосновый Бор</span>
                    </div>
                </div>

                <div class="coverage-cta-box">
                    <h3>Не нашли свой район?</h3>
                    <p>Позвоните — уточним за 1 минуту. Работаем ежедневно с 9:00 до 23:00</p>
                    <?php if ($phone): ?>
                        <a href="tel:<?php echo $phone_clean; ?>" class="btn btn-primary">Проверить выезд в мой район</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>