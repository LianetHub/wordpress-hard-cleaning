<?php
$term = $args['term'] ?? null;
if (!$term) return;

$term_link = get_term_link($term);
$image = get_field('category_image', $term);
$description = term_description($term->term_id, 'service_cat');

$services_query = new WP_Query([
    'post_type'      => 'services',
    'posts_per_page' => 4,
    'tax_query'      => [[
        'taxonomy' => 'service_cat',
        'field'    => 'term_id',
        'terms'    => $term->term_id,
        'include_children' => false
    ]],
]);
?>

<div class="catalog__card">
    <a href="<?php echo esc_url($term_link); ?>" class="catalog__card-image">
        <?php if ($image): ?>
            <img
                src="<?php echo esc_url($image['url']); ?>"
                alt="<?php echo esc_attr($image['alt'] ?: $term->name); ?>"
                loading="lazy"
                class="cover-image">
        <?php else: ?>
            <div class="catalog__card-placeholder">
                <img
                    src="<?php echo get_template_directory_uri(); ?>/assets/img/catalog-card-placeholder.svg"
                    alt="Нет фото"
                    class="placeholder-icon">
            </div>
        <?php endif; ?>
    </a>

    <div class="catalog__card-content">
        <h3 class="catalog__card-title">
            <a href="<?php echo esc_url($term_link); ?>">
                <?php echo esc_html($term->name); ?>
            </a>
        </h3>

        <?php if ($description): ?>
            <div class="catalog__card-description">
                <?php echo wp_trim_words($description, 20, '...'); ?>
            </div>
        <?php endif; ?>

        <div class="catalog__card-footer">

            <a href="<?php echo esc_url($term_link); ?>"
                class="catalog__card-btn btn btn-primary">
                Подробнее
            </a>
        </div>
    </div>
</div>