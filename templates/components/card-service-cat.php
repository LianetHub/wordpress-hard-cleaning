<?php
$term = $args['term'] ?? null;
if (!$term) return;

$phone = get_field('phone', 'option');
$phone_clean = $phone ? preg_replace('/[^\d+]/', '', $phone) : '';

$icon = get_field('category_icon', $term);
$image = get_field('category_image', $term);
$term_link = get_term_link($term);

$services_query = new WP_Query([
    'post_type'      => 'services',
    'posts_per_page' => -1,
    'tax_query'      => [[
        'taxonomy' => 'service_cat',
        'field'    => 'term_id',
        'terms'    => $term->term_id,
        'include_children' => false
    ]],
]);

$total_services = $services_query->found_posts;
$limit = 4;
$counter = 0;
?>

<li class="services__item">
    <div class="services__item-body">
        <div class="services__item-main">
            <div class="services__item-header">
                <?php if ($icon): ?>
                    <div class="services__item-icon" aria-hidden="true">
                        <?php echo get_processed_svg($icon['url'], '#ffffff'); ?>
                    </div>
                <?php endif; ?>

                <h3 class="services__item-title">
                    <a href="<?php echo esc_url($term_link); ?>">
                        <?php echo fix_widows_after_prepositions($term->name); ?>
                    </a>
                </h3>
            </div>
            <a class="services__item-btn btn btn-primary icon-phone"
                href="tel:<?php echo $phone_clean; ?>">Вызвать бригаду</a>
        </div>

        <?php if ($services_query->have_posts()): ?>
            <div class="services__item-tags">
                <?php while ($services_query->have_posts()): $services_query->the_post();
                    if ($counter < $limit): ?>
                        <a href="<?php the_permalink(); ?>" class="services__item-tag">
                            <?php echo fix_widows_after_prepositions(get_the_title()); ?>
                        </a>
                <?php
                    endif;
                    $counter++;
                endwhile; ?>

                <?php if ($total_services > $limit):
                    $remaining = $total_services - $limit; ?>
                    <a href="<?php echo esc_url($term_link); ?>" class="services__item-tag services__item-tag--more">
                        +<?php echo $remaining; ?> <?php echo russian_plural($remaining, ['услугу', 'услуги', 'услуг']); ?>
                    </a>
                <?php endif; ?>

                <?php wp_reset_postdata(); ?>
            </div>
        <?php endif; ?>
    </div>

    <?php if ($image): ?>
        <a href="<?php echo esc_url($term_link); ?>" class="services__item-image">
            <img src="<?php echo esc_url($image['url']); ?>"
                alt="<?php echo esc_attr($term->name); ?>"
                width="482"
                height="686"
                loading="lazy"
                decoding="async">
        </a>
    <?php endif; ?>
</li>