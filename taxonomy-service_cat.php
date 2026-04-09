<?php get_header(); ?>

<?php
$current_term = get_queried_object();
$all_main_categories = get_terms([
    'taxonomy'   => 'service_cat',
    'hide_empty' => false,
    'parent'     => 0,
]);

$is_parent = ($current_term->parent == 0);

if ($is_parent) {
    $display_terms = get_terms([
        'taxonomy'   => 'service_cat',
        'hide_empty' => false,
        'parent'     => $current_term->term_id,
    ]);
} else {
    $display_terms = [$current_term];
}
?>

<?php require_once(TEMPLATE_PATH . '/components/breadcrumbs.php'); ?>

<section class="services">
    <div class="services__container container">
        <h1 class="services__title title">
            <?php echo fix_widows_after_prepositions($current_term->name); ?>
        </h1>

        <?php if (!empty($all_main_categories)) : ?>
            <div class="services__filter">
                <ul class="filter-list">
                    <li class="filter-item">
                        <a href="<?php echo get_post_type_archive_link('services'); ?>" class="filter-link">Все</a>
                    </li>
                    <?php foreach ($all_main_categories as $main_cat) : 
                        $is_active = ($current_term->term_id === $main_cat->term_id || $current_term->parent === $main_cat->term_id);
                    ?>
                        <li class="filter-item">
                            <a href="<?php echo get_term_link($main_cat); ?>" 
                               class="filter-link <?php echo $is_active ? 'is-active' : ''; ?>">
                                <?php echo esc_html($main_cat->name); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if (!empty($display_terms)) : ?>
            <ul class="services__list">
                <?php foreach ($display_terms as $term) :
                    get_template_part('templates/components/card', 'service-cat', [
                        'term' => $term
                    ]);
                endforeach; ?>
            </ul>
        <?php else : ?>
            <p>В данной категории услуг пока нет.</p>
        <?php endif; ?>
    </div>
</section>

<?php require_once(TEMPLATE_PATH . '_faq.php'); ?>
<?php require_once(TEMPLATE_PATH . '_cta.php'); ?>

<?php get_footer(); ?>