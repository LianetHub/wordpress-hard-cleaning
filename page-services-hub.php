<?php

/**
 * Template Name: Универсальный хаб услуг
 */

get_header();

$current_slug = get_post_field('post_name', get_the_ID());

// Карта соответствия слага страницы и значения поля ACF
$filter_map = [
    'chastnym-licam' => 'private',
    'kompaniyam' => 'business',
    'drugie-uslugi' => 'other'
];

$target_filter = $filter_map[$current_slug] ?? 'private';

// Получаем категории, у которых ACF поле service_target соответствует фильтру
$terms = get_terms([
    'taxonomy' => 'service_cat',
    'hide_empty' => false,
    'meta_query' => [
        [
            'key' => 'service_target', // Имя поля в ACF для категории
            'value' => $target_filter,
            'compare' => 'LIKE' // Используем LIKE, если это checkbox (массив)
        ]
    ]
]);
?>

<section class="services-grid">
    <div class="container">
        <h1><?php the_title(); ?></h1>

        <div class="grid">
            <?php foreach ($terms as $term) :
                // Получаем список постов для каждой категории, чтобы вывести теги-услуги
                $services = get_posts([
                    'post_type' => 'services',
                    'tax_query' => [[
                        'taxonomy' => 'service_cat',
                        'field'    => 'term_id',
                        'terms'    => $term->term_id
                    ]]
                ]);
            ?>
                <div class="service-card">
                    <h3><?php echo $term->name; ?></h3>

                    <div class="tags">
                        <?php foreach ($services as $service) : ?>
                            <span class="tag"><?php echo get_the_title($service->ID); ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>




<?php get_footer(); ?>