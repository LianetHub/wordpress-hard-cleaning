<?php
$queried_object = get_queried_object();
$items = [];
$is_debug = isset($_GET['debug']);

$items[] = ['name' => 'Главная', 'link' => home_url('/')];

if (is_post_type_archive('services') || is_tax('service_cat') || is_singular('services')) {
    $items[] = ['name' => 'Услуги', 'link' => get_post_type_archive_link('services')];

    if (is_tax('service_cat')) {
        $ancestors = get_ancestors($queried_object->term_id, 'service_cat');
        foreach (array_reverse($ancestors) as $ancestor_id) {
            $ancestor = get_term($ancestor_id);
            if ($ancestor && !is_wp_error($ancestor)) {
                $items[] = ['name' => $ancestor->name, 'link' => get_term_link($ancestor)];
            }
        }
        $items[] = ['name' => $queried_object->name, 'link' => ''];
    } elseif (is_singular('services')) {
        $terms = get_the_terms(get_the_ID(), 'service_cat');
        if ($terms && !is_wp_error($terms)) {
            $main_term = $terms[0];
            foreach ($terms as $term) {
                if ($term->parent != 0) {
                    $main_term = $term;
                    break;
                }
            }

            $ancestors = get_ancestors($main_term->term_id, 'service_cat');
            foreach (array_reverse($ancestors) as $ancestor_id) {
                $ancestor = get_term($ancestor_id);
                if ($ancestor && !is_wp_error($ancestor)) {
                    $items[] = ['name' => $ancestor->name, 'link' => get_term_link($ancestor)];
                }
            }
            $items[] = ['name' => $main_term->name, 'link' => get_term_link($main_term)];
        }
        $items[] = ['name' => get_the_title(), 'link' => ''];
    } elseif (is_post_type_archive('services')) {
        $items[count($items) - 1]['link'] = '';
    }
} elseif (is_page()) {
    $ancestors = get_post_ancestors(get_the_ID());
    if ($ancestors) {
        foreach (array_reverse($ancestors) as $ancestor_id) {
            $items[] = ['name' => get_the_title($ancestor_id), 'link' => get_permalink($ancestor_id)];
        }
    }
    $items[] = ['name' => get_the_title(), 'link' => ''];
} elseif (is_404()) {
    $items[] = ['name' => '404', 'link' => ''];
} else {
    $items[] = ['name' => get_the_title(), 'link' => ''];
}

if ($is_debug) {
    echo '<pre style="background:#222; color:#fff; padding:20px; margin:20px; border-radius:10px; font-size:13px; line-height:1.5; position:relative; z-index:9999;">';
    echo "<b>DEBUG INFO:</b>\n";
    echo "Current Object ID: " . (isset($queried_object->term_id) ? $queried_object->term_id : get_the_ID()) . "\n";
    echo "is_tax('service_cat'): " . (is_tax('service_cat') ? 'YES' : 'NO') . "\n";
    echo "is_singular('services'): " . (is_singular('services') ? 'YES' : 'NO') . "\n";
    echo "is_page(): " . (is_page() ? 'YES' : 'NO') . "\n";
    echo "Taxonomy: " . get_query_var('taxonomy') . "\n";
    echo "Term: " . get_query_var('term') . "\n";
    echo "\n<b>BREADCRUMBS ARRAY:</b>\n";
    print_r($items);
    echo '</pre>';
}
?>

<nav aria-label="Хлебные крошки" class="breadcrumbs">
    <div class="container">
        <ul class="breadcrumbs__list" itemscope itemtype="https://schema.org/BreadcrumbList">
            <?php foreach ($items as $index => $item) : ?>
                <li class="breadcrumbs__item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <?php if ($item['link'] && $index < count($items) - 1) : ?>
                        <a href="<?php echo esc_url($item['link']); ?>" itemprop="item" class="breadcrumbs__link">
                            <span itemprop="name"><?php echo esc_html($item['name']); ?></span>
                        </a>
                    <?php else : ?>
                        <span itemprop="name" class="breadcrumbs__current">
                            <?php echo esc_html($item['name']); ?>
                        </span>
                        <link itemprop="item" href="<?php echo esc_url((is_ssl() ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>">
                    <?php endif; ?>
                    <meta itemprop="position" content="<?php echo $index + 1; ?>" />
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</nav>