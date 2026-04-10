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
<section class="services services--page">
    <div class="services__container container">
        <h1 class="services__title title-lg">Все услуги <span class="color-accent">спецуборки</span></h1>
        <p class="services__subtitle subtitle">Работаем со сложными случаями — после пожара, потопа, смерти и других ЧП. Выбирайте ситуацию — расскажем что входит и сколько стоит.</p>
        <div class="services__categories">
            <a href="" class="services__category btn btn-primary">Для частных лиц</a>
            <a href="" class="services__category btn btn-outline">Для бизнеса и юр. лиц</a>
            <a href="" class="services__category btn btn-primary">Прочие услуги</a>
        </div>
    </div>
</section>
<?php require_once(TEMPLATE_PATH . '_trust.php'); ?>
<?php require_once(TEMPLATE_PATH . '_faq.php'); ?>
<?php require_once(TEMPLATE_PATH . '_cta.php'); ?>


<?php get_footer(); ?>