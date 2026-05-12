<?php
$current_object = get_queried_object();
$is_archive = is_post_type_archive('services');
$current_term_id = (isset($current_object->term_id)) ? $current_object->term_id : 0;

$grid_categories = [];

if ($is_archive) {
    $all_terms = get_terms([
        'taxonomy'   => 'service_cat',
        'hide_empty' => true,
    ]);

    $grid_categories = array_filter($all_terms, function ($t) {
        return $t->parent !== 0;
    });
} else {
    $parent_term_id = $current_object->parent;

    $grid_categories = get_terms([
        'taxonomy'   => 'service_cat',
        'hide_empty' => true,
        'parent'     => $current_term_id,
    ]);
}

$services_query = null;

if (empty($grid_categories)) {
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
}

$extra_service_id = 821;
$extra_service = get_post($extra_service_id);
$show_extra = ($current_term_id === 11 && $extra_service && $extra_service->post_status === 'publish');

$regional_cities = [];
$gorod_posts = get_posts([
    'post_type'      => 'gorod',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'orderby'        => 'title',
    'order'          => 'ASC',
    'no_found_rows'  => true,
]);
foreach ($gorod_posts as $city_post) {
    if (!$city_post instanceof WP_Post) {
        continue;
    }
    $link = get_permalink($city_post);
    if (!$link) {
        continue;
    }
    $regional_cities[get_the_title($city_post)] = $link;
}
?>

<section class="catalog">
    <div class="container">
        <div class="catalog__hint hint">Каталог</div>
        <h2 class="catalog__title title">
            <?php echo wp_kses('Выберите <span class="color-accent">вашу ситуацию</span>', ['span' => ['class' => []]]); ?>
        </h2>
        <p class="catalog__subtitle subtitle">Нажмите на услугу — расскажем подробно что входит и&nbsp;сколько стоит</p>

        <?php if (!empty($grid_categories)): ?>
            <ul class="services__cards">
                <?php foreach ($grid_categories as $g_term): ?>
                    <?php
                    get_template_part('templates/components/card', 'service-cat', [
                        'term' => $g_term
                    ]);
                    ?>
                <?php endforeach; ?>
                <?php if ($show_extra): ?>
                    <?php get_template_part('templates/components/card', 'service-item', [
                        'post' => $extra_service
                    ]); ?>
                <?php endif; ?>
            </ul>

        <?php elseif ($services_query && $services_query->have_posts()): ?>
            <div class="catalog__grid">
                <?php while ($services_query->have_posts()): $services_query->the_post(); ?>
                    <?php get_template_part('templates/components/card-catalog'); ?>
                <?php endwhile; ?>

                <?php wp_reset_postdata(); ?>
            </div>

        <?php else: ?>
            <div class="catalog__grid">
                <div class="catalog__empty">
                    <h3 class="catalog__empty-title title-sm">В этой категории пока нет услуг</h3>
                    <p class="catalog__empty-text subtitle">Мы скоро добавим описание работ для этого раздела. А пока вы можете уточнить детали у менеджера.</p>
                    <a href="<?php echo get_post_type_archive_link('services'); ?>" class="btn btn-secondary btn-sm">Показать все услуги</a>
                </div>
            </div>
        <?php endif; ?>

        <?php if (!empty($regional_cities)) : ?>
            <div class="catalog__regions-cloud" style="margin-top: 40px;">
                <h3 class="catalog__regions-title title-sm" style="margin-bottom: 20px;">Услуги в других городах:</h3>
                <div class="tags-cloud" style="display: flex; flex-wrap: wrap; gap: 10px;">
                    <?php foreach ($regional_cities as $city_name => $city_link) : ?>
                        <a href="<?php echo esc_url($city_link); ?>" class="btn btn-outline btn-sm">
                            <?php echo esc_html($city_name); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <?php get_template_part('templates/components/catalog-support-block'); ?>
    </div>
</section>