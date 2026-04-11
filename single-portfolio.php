<?php get_header(); ?>

<?php
$before = get_field('case_before_img');
$after = get_field('case_after_img');
$service = get_field('case_service_link');
?>

<?php require_once(TEMPLATE_PATH . '/components/breadcrumbs.php'); ?>


<section class="heading">
    <div class="heading__container container">
        <div class="heading__offer">
            <h1 class="heading__title title-lg">
                <?php the_title(); ?>
            </h1>
            <p class="heading__subtitle subtitle"> <?php the_excerpt(); ?></p>
        </div>
        <div class="heading__image">
            <img src="<?php echo esc_url($before['url']); ?>" class="cover-image" alt="До">
            <img src="<?php echo esc_url($after['url']); ?>" class="cover-image" alt="После">

        </div>
    </div>
</section>
<?php require_once(TEMPLATE_PATH . '_results.php'); ?>
<div class="case-study">
    <div class="container">
        <div class="case-header">
            <?php if ($service): ?>
                <a href="<?php echo get_permalink($service->ID); ?>" class="case-category">
                    <?php echo get_the_title($service->ID); ?>
                </a>
            <?php endif; ?>
        </div>
        <div class="case-content">
            <div class="case-info">
                <div class="info-item">Площадь: <strong><?php the_field('case_area'); ?></strong></div>
                <div class="info-item">Срок: <strong><?php the_field('case_duration'); ?></strong></div>
                <div class="info-item">Персонал: <strong><?php the_field('case_staff'); ?></strong></div>
            </div>
        </div>
    </div>
</div>
<?php if (!empty(get_the_content())): ?>
    <article class="article">
        <div class="container">
            <div class="article__content typography-block">
                <?php the_content(); ?>
            </div>
        </div>
    </article>
<?php endif; ?>
<?php require_once(TEMPLATE_PATH . '_cta.php'); ?>
<?php get_footer(); ?>