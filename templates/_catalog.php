<?php
$current_object = get_queried_object();
$is_archive = is_post_type_archive('services');
$current_term_id = (isset($current_object->term_id)) ? $current_object->term_id : 0;

if ($is_archive) {
    $parent_id = 0;
} else {
    $parent_id = $current_term_id;
}

$terms = get_terms([
    'taxonomy'   => 'service_cat',
    'hide_empty' => false,
    'parent'     => $parent_id,
]);

if (empty($terms) && !$is_archive) {
    $terms = get_terms([
        'taxonomy'   => 'service_cat',
        'hide_empty' => false,
        'parent'     => $current_object->parent,
    ]);
}

$archive_link = get_post_type_archive_link('services');
?>

<section class="catalog">
    <div class="container">
        <div class="catalog__hint hint">Каталог</div>
        <h2 class="catalog__title title">Выберите <span class="color-accent">вашу ситуацию</span></h2>
        <p class="catalog__subtitle subtitle">Нажмите на услугу — расскажем подробно что входит и&nbsp;сколько стоит</p>

        <div class="catalog__filters">
            <a href="<?php echo esc_url($archive_link); ?>"
                class="catalog__filter btn btn-outline <?php echo $is_archive ? 'active' : ''; ?>">
                Все услуги
            </a>

            <?php if (!empty($terms) && !is_wp_error($terms)): ?>
                <?php foreach ($terms as $term): ?>
                    <?php
                    $is_active = ($current_term_id === $term->term_id) ? 'active' : '';
                    $term_link = get_term_link($term);
                    ?>
                    <a href="<?php echo esc_url($term_link); ?>"
                        class="catalog__filter btn btn-outline <?php echo $is_active; ?>">
                        <?php echo esc_html($term->name); ?>
                    </a>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <div class="catalog__grid">
            <?php
            $main_query_args = [
                'post_type' => 'services',
                'posts_per_page' => -1,
            ];

            if (!$is_archive) {
                $main_query_args['tax_query'] = [[
                    'taxonomy' => 'service_cat',
                    'field'    => 'term_id',
                    'terms'    => $current_term_id,
                ]];
            }

            if (!empty($terms) && !is_wp_error($terms)) {
                foreach ($terms as $term_item) {
                    get_template_part('templates/components/card-catalog', null, ['term' => $term_item]);
                }
            }
            ?>
        </div>

        <div class="catalog__support">
            <div class="catalog__support-card">
                <div class="catalog__support-main">
                    <div class="catalog__support-caption">Не нашли свою ситуацию?</div>
                    <div class="catalog__support-desc">У нас есть и другие услуги — опишите что случилось, и мы подберём решение под вашу задачу.</div>
                </div>
                <div class="catalog__support-btns">
                    <a href="" class="catalog__support-btn btn btn-primary">Уточнить лично</a>
                    <a href="" class="catalog__support-btn btn btn-outline">Позвонить</a>
                </div>
            </div>
            <div class="catalog__support-card catalog__support-card--blue">
                <div class="catalog__support-main">
                    <div class="catalog__support-caption">Хотите узнать точную стоимость?</div>
                    <div class="catalog__support-desc">Все цены в одном месте — таблица по каждой услуге с комментариями</div>
                </div>
                <div class="catalog__support-btns">
                    <a href="" class="catalog__support-btn btn btn-white">Смотреть прайс</a>
                    <a href="" class="catalog__support-btn btn btn-outline-white">Позвонить</a>
                </div>
            </div>
        </div>
    </div>
</section>