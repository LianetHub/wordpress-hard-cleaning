<?php
$current_object = get_queried_object();
$is_archive = is_post_type_archive('services');
$current_term_id = (isset($current_object->term_id)) ? $current_object->term_id : 0;

$first_btn_text = 'Все услуги';
$first_btn_link = get_post_type_archive_link('services');
$is_first_btn_active = $is_archive;
$filter_terms = [];
$grid_terms = [];

if ($is_archive) {
    $filter_terms = get_terms([
        'taxonomy'   => 'service_cat',
        'hide_empty' => true,
        'parent'     => 0,
    ]);

    $all_terms = get_terms([
        'taxonomy'   => 'service_cat',
        'hide_empty' => true,
    ]);

    $grid_terms = array_filter($all_terms, function ($term) {
        return $term->parent !== 0;
    });
} else {
    $parent_term_id = $current_object->parent;

    if ($parent_term_id == 0) {
        $first_btn_text = 'Все ' . mb_strtolower($current_object->name);
        $first_btn_link = get_term_link($current_object);
        $is_first_btn_active = true;

        $filter_terms = get_terms([
            'taxonomy'   => 'service_cat',
            'hide_empty' => true,
            'parent'     => $current_term_id,
        ]);
    } else {
        $parent_term = get_term($parent_term_id, 'service_cat');
        $first_btn_text = 'Все ' . mb_strtolower($parent_term->name);
        $first_btn_link = get_term_link($parent_term);
        $is_first_btn_active = false;

        $filter_terms = get_terms([
            'taxonomy'   => 'service_cat',
            'hide_empty' => true,
            'parent'     => $parent_term_id,
        ]);
    }
}

$services_query = null;
if (!$is_archive) {
    $query_args = [
        'post_type'      => 'services',
        'posts_per_page' => -1,
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
        'tax_query' => [
            [
                'taxonomy'         => 'service_cat',
                'field'            => 'term_id',
                'terms'            => $current_term_id,
                'include_children' => true
            ]
        ]
    ];
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

        <div class="catalog__filters filters swiper">
            <div class="swiper-wrapper">
                <a href="<?php echo esc_url($first_btn_link); ?>"
                    class="filters__item swiper-slide btn btn-sm btn-outline <?php echo $is_first_btn_active ? 'active' : ''; ?>">
                    <?php echo esc_html($first_btn_text); ?>
                </a>

                <?php if (!empty($filter_terms) && !is_wp_error($filter_terms)): ?>
                    <?php foreach ($filter_terms as $term): ?>
                        <?php
                        $is_active = ($current_term_id === $term->term_id) ? 'active' : '';
                        $term_link = get_term_link($term);
                        ?>
                        <a href="<?php echo esc_url($term_link); ?>"
                            class="filters__item swiper-slide btn btn-sm btn-outline <?php echo $is_active; ?>">
                            <?php echo esc_html($term->name); ?>
                        </a>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>


        <?php if ($is_archive): ?>
            <?php if (!empty($grid_terms) && !is_wp_error($grid_terms)): ?>
                <ul class="services__list">
                    <?php foreach ($grid_terms as $term): ?>
                        <?php
                        get_template_part('templates/components/card', 'service-cat', [
                            'term' => $term
                        ]);
                        ?>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        <?php endif; ?>


        <?php get_template_part('templates/components/catalog-support-block'); ?>
    </div>
</section>