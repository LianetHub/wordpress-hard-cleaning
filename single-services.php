<?php get_header(); ?>
<?php require_once(TEMPLATE_PATH . '/components/breadcrumbs.php'); ?>
<article class="service">
    <div class="container">
        <h1 class="service__title title-lg"><?php the_title() ?></h1>
    </div>
</article>
<?php require_once(TEMPLATE_PATH . '_reviews.php'); ?>
<?php require_once(TEMPLATE_PATH . '_faq.php'); ?>
<?php require_once(TEMPLATE_PATH . '_cta.php'); ?>
<?php get_footer(); ?>