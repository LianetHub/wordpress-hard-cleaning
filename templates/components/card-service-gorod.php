<?php

$item = $args['item'] ?? null;
if (!$item) {
    return;
}

$phone = get_field('phone', 'option');
$phone_clean = $phone ? preg_replace('/[^\d+]/', '', $phone) : '';

$is_term = ($item instanceof WP_Term);

$icon = '';
$image = [];
$title = '';
$link = '';
$min_price = 0;

if ($is_term) {
    $icon = get_field('category_icon', $item);
    $image = get_field('category_image', $item);
    $title = $item->name;
    $link = get_term_link($item);

    $services_query = new WP_Query([
        'post_type'      => 'services',
        'posts_per_page' => -1,
        'tax_query'      => [[
            'taxonomy'         => 'service_cat',
            'field'            => 'term_id',
            'terms'            => $item->term_id,
            'include_children' => false
        ]],
    ]);

    $prices_group = get_field('all_services_prices_list', 'option');
    if ($services_query->have_posts()) {
        while ($services_query->have_posts()) {
            $services_query->the_post();
            $sid = get_the_ID();
            $service_data = $prices_group['service_data_' . $sid] ?? null;
            $price = !empty($service_data['service_price']) ? (int)preg_replace('/[^\d]/', '', $service_data['service_price']) : 0;

            if ($price > 0 && ($min_price === 0 || $price < $min_price)) {
                $min_price = $price;
            }
        }
        wp_reset_postdata();
    }
} else { // $item is WP_Post
    $icon = get_field('category_icon', $item->ID);
    $image = [];
    if (function_exists('get_field')) {
        $acf_image = get_field('category_image', $item->ID);
        if (!empty($acf_image)) {
            $image = $acf_image;
        } else {
            $thumb = get_the_post_thumbnail_url($item->ID, 'full');
            if ($thumb) {
                $image = ['url' => $thumb, 'alt' => $title];
            }
        }
    }
    $title = $item->post_title;
    $link = get_permalink($item);

    $prices_group = get_field('all_services_prices_list', 'option');
    $service_data = $prices_group['service_data_' . $item->ID] ?? null;
    if (!empty($service_data['service_price'])) {
        $min_price = (int) preg_replace('/[^\d]/', '', $service_data['service_price']);
    }
}

if (!$link) {
    return;
}

?>

<li class="services__item">
    <?php if ($image): ?>
        <a href="<?php echo esc_url($link); ?>" class="services__item-image">
            <img src="<?php echo esc_url($image['url']); ?>"
                alt="<?php echo esc_attr($title); ?>"
                width="482"
                height="686"
                loading="lazy"
                decoding="async">
        </a>
    <?php endif; ?>
    <div class="services__item-body">
        <div class="services__item-main">
            <div class="services__item-header">
                <?php if ($icon): ?>
                    <div class="services__item-icon" aria-hidden="true">
                        <?php echo get_processed_svg($icon['url'], '#ffffff'); ?>
                    </div>
                <?php endif; ?>

                <a href="<?php echo esc_url($link); ?>" class="services__item-info">
                    <div class="services__item-title">
                        <?php echo fix_widows_after_prepositions($title); ?>
                    </div>
                    <?php if ($min_price > 0): ?>
                        <div class="services__item-price">
                            от&nbsp;<?php echo format_service_price($min_price); ?>&nbsp;₽
                        </div>
                    <?php endif; ?>
                </a>
            </div>
            <a class="services__item-btn btn btn-secondary-outline icon-phone"
                href="tel:<?php echo $phone_clean; ?>">Вызвать бригаду</a>
        </div>
    </div>
</li>