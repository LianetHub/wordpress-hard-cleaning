<?php
$term = $args['term'] ?? null;

if ($term) {
    $title = $term->name;
    $link = get_term_link($term);
    $image = get_field('category_image', $term);
    $description = term_description($term->term_id, 'service_cat');

    $tags_query = new WP_Query([
        'post_type' => 'services',
        'posts_per_page' => 2,
        'tax_query' => [[
            'taxonomy' => 'service_cat',
            'field' => 'term_id',
            'terms' => $term->term_id,
            'include_children' => false
        ]],
    ]);
    $tag_names = [];
    if ($tags_query->have_posts()) {
        while ($tags_query->have_posts()) {
            $tags_query->the_post();
            $tag_names[] = get_the_title();
        }
        wp_reset_postdata();
    }
} else {
    $title = get_the_title();
    $link = get_permalink();
    $image = get_field('service_card_image') ?: ['url' => get_the_post_thumbnail_url(get_the_ID(), 'full'), 'alt' => $title];
    $description = get_the_excerpt();

    $post_terms = get_the_terms(get_the_ID(), 'service_cat');
    $tag_names = [];
    if ($post_terms && !is_wp_error($post_terms)) {
        foreach (array_slice($post_terms, 0, 2) as $t) {
            $tag_names[] = $t->name;
        }
    }
}
?>

<div class="catalog__card">
    <a href="<?php echo esc_url($link); ?>" class="catalog__card-image">
        <?php if (!empty($image['url'])): ?>
            <img src="<?php echo esc_url($image['url']); ?>"
                alt="<?php echo esc_attr($image['alt'] ?: $title); ?>"
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
                <?php echo wp_trim_words($description, 20, '...'); ?>
            </div>
        <?php endif; ?>

        <div class="catalog__card-footer">
            <a href="<?php echo esc_url($link); ?>" class="catalog__card-btn btn btn-primary">
                Подробнее
            </a>
        </div>
    </div>
</div>