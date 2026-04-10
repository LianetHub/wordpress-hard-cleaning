<?php get_header(); ?>

<?php
$term = get_queried_object();
$title = get_field('term_title', $term) ?: $term->name;
$descr = get_field('term_descr', $term) ?: $term->description;

$image = get_field('category_heading_image', $term) ?: get_field('category_image', $term);
?>

<?php require_once(TEMPLATE_PATH . '/components/breadcrumbs.php'); ?>

<section class="heading">
    <div class="heading__container container">
        <div class="heading__offer">
            <h1 class="heading__title title-lg">
                <?php echo wp_kses($title, ['span' => ['class' => []]]); ?>
            </h1>
            <?php if ($descr): ?>
                <p class="heading__subtitle subtitle"><?php echo $descr; ?></p>
            <?php endif; ?>
        </div>
        <?php if ($image): ?>
            <div class="heading__image">
                <img src="<?php echo esc_url($image['url']); ?>"
                    alt="<?php echo esc_attr($image['alt'] ?: $title); ?>"
                    class="cover-image">
            </div>
        <?php endif; ?>
    </div>
</section>


<?php require_once(TEMPLATE_PATH . '_catalog.php'); ?>
<?php require_once(TEMPLATE_PATH . '_trust.php'); ?>
<?php require_once(TEMPLATE_PATH . '_faq.php'); ?>
<?php require_once(TEMPLATE_PATH . '_cta.php'); ?>

<?php get_footer(); ?>