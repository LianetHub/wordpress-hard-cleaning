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
            </ul>

        <?php elseif ($services_query && $services_query->have_posts()): ?>
            <div class="catalog__grid">
                <?php while ($services_query->have_posts()): $services_query->the_post(); ?>
                    <?php get_template_part('templates/components/card-catalog'); ?>
                <?php endwhile;
                wp_reset_postdata(); ?>
            </div>

        <?php else: ?>
            <div class="catalog__grid">
                <div class="catalog__empty">
                    <h3 class="catalog__empty-title title-sm">В этой категории пока нет услуг</h3>
                    <p class="catalog__empty-text subtitle">Мы скоро добавим описание работ для этого раздела. А пока вы можете уточнить детали у менеджера.</p>
                    <a href="<?php echo get_post_type_archive_link('services'); ?>" class="btn btn-outline btn-sm">Показать все услуги</a>
                </div>
            </div>
        <?php endif; ?>

        <?php get_template_part('templates/components/catalog-support-block'); ?>
    </div>
</section>