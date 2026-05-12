<?php

/**
 * Блок портфолио на лендинге города (CPT gorod + мета gorod_city у работ).
 */

if (!is_singular('gorod')) {
    return;
}

$city_id = get_queried_object_id();
if ($city_id <= 0) {
    return;
}

$city_title = get_the_title($city_id);

$works_query = new WP_Query([
    'post_type'      => 'portfolio',
    'post_status'    => 'publish',
    'posts_per_page' => 6,
    'orderby'        => 'date',
    'order'          => 'DESC',
    'meta_query'     => [
        [
            'key'     => 'gorod_city',
            'value'   => $city_id,
            'compare' => '=',
            'type'    => 'NUMERIC',
        ],
    ],
]);

if (!$works_query->have_posts()) {
    wp_reset_postdata();
    return;
}
?>

<section class="works works--city">
    <div class="container">
        <div class="works__hint hint">Портфолио</div>
        <h2 class="works__title title">
            Наши работы в <span class="color-accent"><?php echo esc_html($city_title); ?></span>
        </h2>

        <div class="works__grid">
            <?php
            while ($works_query->have_posts()) :
                $works_query->the_post();
                get_template_part('templates/components/card-portfolio');
            endwhile;
            wp_reset_postdata();
            ?>
        </div>

        <a href="<?php echo esc_url(get_post_type_archive_link('portfolio')); ?>" class="cases__more btn btn-primary">Смотреть все работы →</a>
    </div>
</section>