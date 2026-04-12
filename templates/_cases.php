<?php
$current_service_id = get_the_ID();
$manual_ids = get_field('service_cases_manual');

if (!is_array($manual_ids)) {
    $manual_ids = [];
}

$final_ids = [];

if (count($manual_ids) < 4) {
    $needed = 4 - count($manual_ids);

    $auto_args = [
        'post_type'      => 'portfolio',
        'posts_per_page' => $needed,
        'post__not_in'   => $manual_ids,
        'orderby'        => 'date',
        'order'          => 'DESC',
        'fields'         => 'ids',
        'meta_query'     => [
            [
                'key'     => 'case_service_link',
                'value'   => $current_service_id,
                'compare' => '='
            ]
        ]
    ];

    $auto_ids = get_posts($auto_args);

    if (empty($auto_ids) && empty($manual_ids)) {
        unset($auto_args['meta_query']);
        $auto_ids = get_posts($auto_args);
    }

    $final_ids = array_merge($manual_ids, $auto_ids);
} else {
    $final_ids = array_slice($manual_ids, 0, 4);
}


$works_query = new WP_Query();

if (!empty($final_ids)) {
    $works_query = new WP_Query([
        'post_type'      => 'portfolio',
        'post__in'       => $final_ids,
        'orderby'        => 'post__in',
        'posts_per_page' => 4
    ]);
}
?>

<?php if ($works_query->have_posts()) : ?>
    <section class="works works--white">
        <div class="container">
            <div class="works__hint hint">до / после</div>
            <h2 class="works__title title">Наши <span class="color-accent">работы</span></h2>
            <div class="works__grid">
                <?php while ($works_query->have_posts()) : $works_query->the_post(); ?>
                    <?php get_template_part('templates/components/card-portfolio'); ?>
                <?php endwhile;
                wp_reset_postdata(); ?>
                <div class="cases-info-side">
                    <div class="cases-text-block">
                        <h3 class="title-md">Последствия ЧП? <br><span class="color-accent">Решаем — проверено!</span></h3>
                        <p class="subtitle">Реальные кейсы из нашей практики. Фотографии публикуются только с согласия клиентов.</p>
                    </div>

                    <div class="cases-cards-grid">
                        <!-- До -->
                        <div class="info-card card-white">
                            <h4>До</h4>
                            <ul>
                                <li>Загрязнения на стенах</li>
                                <li>Запах гари и дыма</li>
                                <li>Следы копоти на мебели</li>
                                <li>Повреждённые поверхности</li>
                                <li>Опасные частицы сажи в воздухе</li>
                                <li>Скрытые очаги гари в щелях</li>
                            </ul>
                        </div>
                        <!-- После -->
                        <div class="info-card card-blue">
                            <h4>После</h4>
                            <ul>
                                <li>Очищенные поверхности</li>
                                <li>Нейтральный запах</li>
                                <li>Дезинфекция проведена</li>
                                <li>Готово к ремонту</li>
                                <li>Безопасный микроклимат</li>
                                <li>Первоначальный вид материалов</li>
                            </ul>
                        </div>
                    </div>
                    <div class="faq__cta">
                        <h3 class="faq__cta-title">Оценим масштаб по фото</h3>
                        <p class="faq__cta-subtitle">Пришлите снимки вашего объекта — рассчитаем стоимость и сроки очистки за 15 минут.</p>
                        <div class="faq__cta-btns">
                            <a href="#" class="faq__cta-btn btn btn-white">Отправить фото</a>
                            <?php if ($phone): ?>
                                <a href="tel:<?php echo $phone_clean; ?>"
                                    class="faq__cta-btn btn btn-outline-white">
                                    Позвонить
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <a href="<?php echo get_post_type_archive_link('portfolio') ?>"
                class="cases__more btn btn-primary">
                Посмотреть все работы →
            </a>
        </div>
    </section>
<?php endif; ?>