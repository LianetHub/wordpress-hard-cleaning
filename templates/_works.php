<?php
$current_service_id = get_the_ID();
$terms = get_the_terms($current_service_id, 'service_cat');

if ($terms && !is_wp_error($terms)) :
    $term_ids = wp_list_pluck($terms, 'term_id');

    $args = [
        'post_type'      => 'portfolio',
        'posts_per_page' => 6,
        'meta_query'     => [
            'relation' => 'OR',
        ]
    ];

    foreach ($term_ids as $term_id) {
        $args['meta_query'][] = [
            'key'     => 'case_service_link',
            'value'   => $term_id,
            'compare' => '=',
        ];
    }

    $works_query = new WP_Query($args);

    if ($works_query->have_posts()) : ?>
        <section class="works">
            <div class="container">
                <div class="works__hint hint">Фотографии работ</div>
                <h2 class="works__title title">Наши работы — <span class="color-accent">до и после</span></h2>

                <div class="works__grid">
                    <?php while ($works_query->have_posts()) : $works_query->the_post(); ?>
                        <?php get_template_part('templates/components/card-portfolio'); ?>
                    <?php endwhile; ?>
                </div>

                <a href="<?php echo get_post_type_archive_link('portfolio') ?>"
                    class="cases__more btn btn-primary">
                    Посмотреть все работы →
                </a>
            </div>
        </section>
<?php
    endif;
    wp_reset_postdata();
endif;
?>