<?php
$queried_object = get_queried_object();
$items = [];

$items[] = ['name' => 'Главная', 'link' => home_url('/')];


$items[] = ['name' => 'Услуги', 'link' => get_post_type_archive_link('services')];

if (is_tax('service_cat')) {
    $ancestors = get_ancestors($queried_object->term_id, 'service_cat');
    foreach (array_reverse($ancestors) as $ancestor_id) {
        $ancestor = get_term($ancestor_id);
        $items[] = ['name' => $ancestor->name, 'link' => get_term_link($ancestor)];
    }
    $items[] = ['name' => $queried_object->name, 'link' => ''];
} elseif (is_singular('services')) {

    $terms = get_the_terms(get_the_ID(), 'service_cat');
    if ($terms) {
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
            $items[] = ['name' => $ancestor->name, 'link' => get_term_link($ancestor)];
        }
        $items[] = ['name' => $main_term->name, 'link' => get_term_link($main_term)];
    }
    $items[] = ['name' => get_the_title(), 'link' => ''];
}
?>

<nav aria-label="Хлебные крошки" class="breadcrumbs">
    <div class="container">
        <ul class="breadcrumbs__list">
            <?php foreach ($items as $index => $item) : ?>
                <li class="breadcrumbs__item">
                    <?php if ($item['link'] && $index < count($items) - 1) : ?>
                        <a href="<?php echo esc_url($item['link']); ?>"><?php echo esc_html($item['name']); ?></a>
                    <?php else : ?>
                        <span><?php echo esc_html($item['name']); ?></span>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</nav>