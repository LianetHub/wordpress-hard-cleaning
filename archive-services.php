<?php get_header(); ?>


<?php
$terms = get_terms([
    'taxonomy'   => 'service_cat',
    'hide_empty' => false,
    'parent'     => 0,
    'operator'   => 'NOT IN'
]);

$all_terms = get_terms([
    'taxonomy'   => 'service_cat',
    'hide_empty' => false,
]);

$sub_terms = array_filter($all_terms, function ($term) {
    return $term->parent != 0;
});
?>

<?php require_once(TEMPLATE_PATH . '/components/breadcrumbs.php'); ?>
<section class="services">
    <div class="services__container container">
        <div class="services__hint hint">НАШИ НАПРАВЛЕНИЯ</div>
        <h1 class="services__title title">Все <span class="color-accent">услуги</span> клининга</h1>

        <?php if (!empty($sub_terms)) : ?>
            <ul class="services__list">
                <?php foreach ($sub_terms as $term) :
                    get_template_part('templates/components/card', 'service-cat', [
                        'term' => $term
                    ]);
                endforeach; ?>
            </ul>
        <?php else : ?>
            <p>Услуги скоро появятся.</p>
        <?php endif; ?>
    </div>
</section>
<?php require_once(TEMPLATE_PATH . '_faq.php'); ?>
<?php require_once(TEMPLATE_PATH . '_cta.php'); ?>


<?php get_footer(); ?>