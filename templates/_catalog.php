<?php
$current_object = get_queried_object();
$is_archive = is_post_type_archive('services');
$current_term_id = (isset($current_object->term_id)) ? $current_object->term_id : 0;

$first_btn_text = 'Все услуги';
$first_btn_link = get_post_type_archive_link('services');
$is_first_btn_active = $is_archive;
$filter_terms = [];

if ($is_archive) {
    $filter_terms = get_terms([
        'taxonomy'   => 'service_cat',
        'hide_empty' => false,
        'parent'     => 0,
    ]);
} else {
    $parent_term_id = $current_object->parent;

    if ($parent_term_id == 0) {
        $first_btn_text = 'Все ' . mb_strtolower($current_object->name);
        $first_btn_link = get_term_link($current_object);
        $is_first_btn_active = true;

        $filter_terms = get_terms([
            'taxonomy'   => 'service_cat',
            'hide_empty' => false,
            'parent'     => $current_term_id,
        ]);
    } else {
        $parent_term = get_term($parent_term_id, 'service_cat');
        $first_btn_text = 'Все ' . mb_strtolower($parent_term->name);
        $first_btn_link = get_term_link($parent_term);
        $is_first_btn_active = false;

        $filter_terms = get_terms([
            'taxonomy'   => 'service_cat',
            'hide_empty' => false,
            'parent'     => $parent_term_id,
        ]);
    }
}

$query_args = [
    'post_type'      => 'services',
    'posts_per_page' => -1,
    'orderby'        => 'menu_order',
    'order'          => 'ASC'
];

if (!$is_archive && $current_term_id) {
    $query_args['tax_query'] = [
        [
            'taxonomy'         => 'service_cat',
            'field'            => 'term_id',
            'terms'            => $current_term_id,
            'include_children' => true
        ]
    ];
}

$services_query = new WP_Query($query_args);
?>

<section class="catalog">
    <div class="container">
        <div class="catalog__hint hint">Каталог</div>
        <h2 class="catalog__title title">
            <?php echo wp_kses('Выберите <span class="color-accent">вашу ситуацию</span>', ['span' => ['class' => []]]); ?>
        </h2>
        <p class="catalog__subtitle subtitle">Нажмите на услугу — расскажем подробно что входит и&nbsp;сколько стоит</p>

        <div class="catalog__filters swiper">
            <div class="swiper-wrapper">
                <a href="<?php echo esc_url($first_btn_link); ?>"
                    class="catalog__filter swiper-slide btn btn-sm btn-outline <?php echo $is_first_btn_active ? 'active' : ''; ?>">
                    <?php echo esc_html($first_btn_text); ?>
                </a>

                <?php if (!empty($filter_terms) && !is_wp_error($filter_terms)): ?>
                    <?php foreach ($filter_terms as $term): ?>
                        <?php
                        $is_active = ($current_term_id === $term->term_id) ? 'active' : '';
                        $term_link = get_term_link($term);
                        ?>
                        <a href="<?php echo esc_url($term_link); ?>"
                            class="catalog__filter swiper-slide btn btn-sm btn-outline <?php echo $is_active; ?>">
                            <?php echo esc_html($term->name); ?>
                        </a>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <div class="catalog__grid">
            <?php if ($services_query->have_posts()): ?>
                <?php while ($services_query->have_posts()): $services_query->the_post(); ?>
                    <?php get_template_part('templates/components/card-catalog'); ?>
                <?php endwhile;
                wp_reset_postdata(); ?>
            <?php else: ?>
                <div class="catalog__empty">
                    <h3 class="catalog__empty-title title-sm">В этой категории пока нет услуг</h3>
                    <p class="catalog__empty-text subtitle">Мы скоро добавим описание работ для этого раздела. А пока вы можете уточнить детали у менеджера.</p>
                    <a href="<?php echo get_post_type_archive_link('services'); ?>" class="btn btn-outline btn-sm">Показать все услуги</a>
                </div>
            <?php endif; ?>
        </div>

        <div class="catalog__support">
            <div class="catalog__support-card">
                <div class="catalog__support-main">
                    <div class="catalog__support-caption">Не нашли свою ситуацию?</div>
                    <div class="catalog__support-desc">У нас есть и другие услуги — опишите что случилось, и мы подберём решение под вашу задачу.</div>
                </div>
                <div class="catalog__support-btns">
                    <a href="#" class="catalog__support-btn btn btn-primary">Уточнить лично</a>
                    <a href="tel:+70000000000" class="catalog__support-btn btn btn-outline">Позвонить</a>
                </div>
            </div>
            <div class="catalog__support-card catalog__support-card--blue">
                <div class="catalog__support-main">
                    <div class="catalog__support-caption">Хотите узнать точную стоимость?</div>
                    <div class="catalog__support-desc">Все цены в одном месте — таблица по каждой услуге с комментариями</div>
                </div>
                <div class="catalog__support-btns">
                    <a href="#" class="catalog__support-btn btn btn-white">Смотреть прайс</a>
                    <a href="tel:+70000000000" class="catalog__support-btn btn btn-outline-white">Позвонить</a>
                </div>
            </div>
        </div>
    </div>
</section>