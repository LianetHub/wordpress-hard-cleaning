<?php get_header(); ?>
<?php require_once(TEMPLATE_PATH . '/components/breadcrumbs.php'); ?>
<section class="portfolio">
    <div class="container">
        <h1 class="portfolio__title title">Наши работы (портфолио)</h1>

        <div class="portfolio__grid">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <?php get_template_part('templates/components/card-portfolio'); ?>
                <?php endwhile;
                wp_reset_postdata(); ?>
            <?php else : ?>
                <p>Работы еще не добавлены.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>