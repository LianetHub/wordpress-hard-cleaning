<?php

/**
 * Данные для табов гарантий
 */
$guarantee_tabs = [
    [
        'id'      => 'g-contract',
        'nav_btn' => 'Договор',
        'title'   => 'Договор / акт',
        'content' => '<p>Заключаем договор до начала работ. Фиксируем объём, сроки и стоимость. По окончании подписываем акт выполненных работ — никаких устных договорённостей.</p>'
    ],
    [
        'id'      => 'g-confidential',
        'nav_btn' => 'Конфиденциальность',
        'title'   => 'Информация об объекте защищена',
        'content' => '
            <p>Конфиденциальность для нас — обязательный стандарт работы, особенно в сложных и чувствительных ситуациях.</p>
            <p>Мы понимаем, что вы можете находиться в стрессе или не хотеть обсуждать детали, поэтому выстраиваем процесс так, чтобы ваше участие было минимальным, а информация об объекте не выходила за пределы задачи.</p>
            <p>Мы не публикуем фотографии, видео и любые подробности объекта без вашего прямого согласия. Сотрудники соблюдают внутренние правила общения и работы на месте: без лишних вопросов, без обсуждений, без распространения информации третьим лицам.</p>
        '
    ],
    [
        'id'      => 'g-siz',
        'nav_btn' => 'СИЗ',
        'title'   => 'Безопасность и СИЗ',
        'content' => '<p>Все работы выполняются в строгом соответствии с нормами безопасности и профессиональными стандартами. Мы используем современные средства индивидуальной защиты (СИЗ), включая защитные костюмы, респираторы, перчатки и специализированное оборудование.</p>'
    ],
    [
        'id'      => 'g-result',
        'nav_btn' => 'Проверка результата',
        'title'   => 'Контроль качества',
        'content' => '<p>Контроль качества — обязательная часть нашей работы. Мы отслеживаем результат на каждом этапе, чтобы убедиться, что все загрязнения полностью устранены, а помещение приведено в безопасное состояние.</p>'
    ],
    [
        'id'      => 'g-means',
        'nav_btn' => 'Средства',
        'title'   => 'Профессиональные средства',
        'content' => '<p>В работе мы используем профессиональные и сертифицированные средства, предназначенные для решения сложных задач. Подбор химии и технологий осуществляется индивидуально.</p>'
    ]
];

/**
 * Данные для карточек документов
 */
$guarantee_docs = [
    [
        'label' => 'Договор оферты',
        'img'   => get_template_directory_uri() . '/assets/certificate_1.jpg',
        'link'  => '#'
    ],
    [
        'label' => 'Сертификаты',
        'img'   => get_template_directory_uri() . '/assets/certificate_2.jpg',
        'link'  => '#'
    ],
    [
        'label' => 'Лицензии',
        'img'   => get_template_directory_uri() . '/assets/certificate_3.jpg',
        'link'  => '#'
    ]
];
?>

<section class="guarantees-section">
    <div class="container">
        <span class="guarantees__hint hint">Надёжность</span>
        <h2 class="guarantees__title title">Гарантии и <span class="color-accent">безопасность</span> работ</h2>
        <div class="g-main-card">
            <aside class="g-sidebar">
                <nav class="g-nav">
                    <?php foreach ($guarantee_tabs as $index => $tab): ?>
                        <a href="#"
                            class="g-nav-link <?php echo $index === 0 ? 'active' : ''; ?>"
                            data-target="<?php echo esc_attr($tab['id']); ?>">
                            <?php echo esc_html($tab['nav_btn']); ?>
                        </a>
                    <?php endforeach; ?>
                </nav>
            </aside>

            <div class="g-content-wrapper">
                <?php foreach ($guarantee_tabs as $index => $tab): ?>
                    <div class="g-tab-content <?php echo $index === 0 ? 'active' : ''; ?>"
                        id="<?php echo esc_attr($tab['id']); ?>">
                        <h3><?php echo esc_html($tab['title']); ?></h3>
                        <div class="g-text">
                            <?php echo $tab['content']; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <p class="g-docs-kicker">Наши документы</p>
        <div class="g-docs-grid documents-slider swiper">
            <div class="swiper-wrapper">
                <?php foreach ($guarantee_docs as $doc): ?>
                    <div class="g-doc-card swiper-slide">
                        <div class="g-doc-image">
                            <img src="<?php echo esc_url($doc['img']); ?>"
                                alt="<?php echo esc_attr($doc['label']); ?>"
                                loading="lazy" decoding="async">
                        </div>
                        <div class="g-doc-footer">
                            <span class="g-doc-label"><?php echo esc_html($doc['label']); ?></span>
                            <a href="<?php echo esc_url($doc['link']); ?>" class="g-doc-link">Смотреть <span class="link-arrow" aria-hidden="true">→</span></a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const navLinks = document.querySelectorAll('.g-nav-link');
        const tabContents = document.querySelectorAll('.g-tab-content');

        tabContents.forEach((tab, index) => {
            const step = String(index + 1).padStart(2, '0');
            tab.setAttribute('data-step', step);
            const title = tab.querySelector('h3');
            if (title) title.setAttribute('data-step', step);
        });

        navLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                const targetId = link.getAttribute('data-target');
                navLinks.forEach(l => l.classList.remove('active'));
                tabContents.forEach(c => c.classList.remove('active'));
                link.classList.add('active');
                document.getElementById(targetId).classList.add('active');
            });
        });
    });
</script>