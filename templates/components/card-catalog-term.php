<?php
$term = get_query_var('catalog_term');

if (!$term) return;

$term_obj = (is_numeric($term)) ? get_term($term, 'service_cat') : $term;

$title = $term_obj->name;
$link = get_term_link($term_obj);
$description = term_description($term_obj->term_id, $term_obj->taxonomy);

$selector = $term_obj->taxonomy . '_' . $term_obj->term_id;
$image = get_field('category_image', $selector);

$top_services = get_posts([
    'post_type'      => 'services',
    'posts_per_page' => 2,
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
    'tax_query'      => [
        [
            'taxonomy' => $term_obj->taxonomy,
            'field'    => 'term_id',
            'terms'    => $term_obj->term_id,
        ],
    ],
]);
?>

<div class="catalog__card catalog__card--term">
    <a href="<?php echo esc_url($link); ?>" class="catalog__card-image">
        <?php if (!empty($image) && is_array($image) && isset($image['url'])): ?>
            <img src="<?php echo esc_url($image['url']); ?>"
                alt="<?php echo esc_attr($image['alt'] ?: $title); ?>"
                class="cover-image" loading="lazy">
        <?php elseif (!empty($image) && is_string($image)): ?>
            <img src="<?php echo esc_url($image); ?>"
                alt="<?php echo esc_attr($title); ?>"
                class="cover-image" loading="lazy">
        <?php else: ?>
            <div class="catalog__card-placeholder">
                <img
                    src="<?php echo get_template_directory_uri(); ?>/assets/img/catalog-card-placeholder.svg"
                    alt="Нет фото"
                    loading="lazy"
                    class="cover-image">
            </div>
        <?php endif; ?>
    </a>

    <div class="catalog__card-content">
        <h3 class="catalog__card-title">
            <a href="<?php echo esc_url($link); ?>">
                <?php echo esc_html($title); ?>
            </a>
        </h3>

        <?php if ($description): ?>
            <div class="catalog__card-description">
                <?php echo wp_trim_words(strip_tags($description), 15, '...'); ?>
            </div>
        <?php endif; ?>



        <div class="catalog__card-footer">
            <?php if (!empty($top_services)): ?>
                <div class="catalog__card-services">
                    <?php foreach ($top_services as $top_service): ?>
                        <a href="<?php echo esc_url(get_permalink($top_service->ID)); ?>"
                            class="catalog__card-service">
                            <?php echo esc_html($top_service->post_title); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <a href="<?php echo esc_url($link); ?>"
                class="catalog__card-btn btn btn-primary">
                Подробнее
            </a>
        </div>
    </div>
</div>