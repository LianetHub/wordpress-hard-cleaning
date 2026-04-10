<?php get_header(); ?>

<?php
$term = get_queried_object();
$title = get_field('term_title', $term) ?: $term->name;
$descr = get_field('term_descr', $term) ?: $term->description;
?>

<?php require_once(TEMPLATE_PATH . '/components/breadcrumbs.php'); ?>

<section class="heading">
    <div class="heading__container container">
        <div class="heading__offer">
            <h1 class="heading__title title-lg"><?php echo $title; ?></h1>
            <?php if ($descr): ?>
                <p class="heading__subtitle subtitle"><?php echo $descr; ?></p>
            <?php endif; ?>
        </div>
        <div class="heading__image"></div>
    </div>
</section>

<?php require_once(TEMPLATE_PATH . '_catalog.php'); ?>
<?php require_once(TEMPLATE_PATH . '_trust.php'); ?>
<?php require_once(TEMPLATE_PATH . '_faq.php'); ?>
<?php require_once(TEMPLATE_PATH . '_cta.php'); ?>

<?php get_footer(); ?>