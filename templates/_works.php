<?php
$queried_object = get_queried_object();
$show_portfolio = false;
$works_query = null;
$is_direct_search = false;
$term_ids = [];

if (is_tax('service_cat')) {
    $show_portfolio = get_field("show_portfolio", $queried_object);

    if ($show_portfolio === null) {
        $show_portfolio = true;
    }

    $term_ids = [$queried_object->term_id];

    if ($queried_object->slug === 'uborka-v-gorodah') {
        $all_services_terms = get_terms(['taxonomy' => 'service_cat', 'fields' => 'ids']);
        $term_ids = $all_services_terms;
    }
} else {
    $current_service_id = get_the_ID();
    $show_portfolio = get_field("show_portfolio", $current_service_id);
    $is_direct_search = true;

    $terms = get_the_terms($current_service_id, 'service_cat');
    if ($terms && !is_wp_error($terms)) {
        $term_ids = wp_list_pluck($terms, 'term_id');
    }
}

if ($show_portfolio !== false) :

    if ($is_direct_search) {
        $args_direct = [
            'post_type'      => 'portfolio',
            'posts_per_page' => 6,
            'meta_query'     => [
                'relation' => 'OR',
                [
                    'key'     => 'portfolio_service_link',
                    'value'   => '"' . $current_service_id . '"',
                    'compare' => 'LIKE',
                ],
                [
                    'key'     => 'portfolio_service_link',
                    'value'   => $current_service_id,
                    'compare' => '=',
                ],
            ]
        ];
        $works_query = new WP_Query($args_direct);
    }

    if (!$works_query || !$works_query->have_posts()) {
        if (!empty($term_ids)) {
            $category_conditions = ['relation' => 'OR'];
            foreach ($term_ids as $term_id) {
                $category_conditions[] = [
                    'key'     => 'case_service_link',
                    'value'   => '"' . $term_id . '"',
                    'compare' => 'LIKE',
                ];
            }

            $args_category = [
                'post_type'      => 'portfolio',
                'posts_per_page' => 6,
                'meta_query'     => [
                    'relation' => 'AND',
                    [
                        'relation' => 'OR',
                        ['key' => 'portfolio_service_link', 'value' => '', 'compare' => '='],
                        ['key' => 'portfolio_service_link', 'compare' => 'NOT EXISTS'],
                    ],
                    $category_conditions
                ]
            ];
            $works_query = new WP_Query($args_category);
        }
    }

    if ($works_query && $works_query->have_posts()) : ?>
        <section class="works">
            <div class="container">
                <div class="works__hint hint">Фотографии работ</div>
                <h2 class="works__title title">Наши работы — <span class="color-accent">до и после</span></h2>

                <div class="works__grid">
                    <?php while ($works_query->have_posts()) : $works_query->the_post(); ?>
                        <?php get_template_part('templates/components/card-portfolio'); ?>
                    <?php endwhile; ?>
                </div>

                <a href="<?php echo get_post_type_archive_link('portfolio') ?>" class="cases__more btn btn-primary">Посмотреть все работы →</a>
            </div>
        </section>
<?php
    endif;
    wp_reset_postdata();
endif;
?>