<?php get_header(); ?>
<?php require_once(TEMPLATE_PATH . '/components/breadcrumbs.php'); ?>

<section class="portfolio">
    <div class="container">
        <div class="portfolio__hint hint">Наши работы</div>
        <h1 class="portfolio__title title">Примеры <span class="color-accent">выполненных работ</span></h1>
        <p class="portfolio__subtitle subtitle">Фотографии до и после — без фильтров и обработки</p>

        <div class="portfolio__grid">
            <?php
            global $query_string;
            query_posts($query_string . '&posts_per_page=-1');

            if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <div class="portfolio__item">
                        <?php get_template_part('templates/components/card-portfolio'); ?>
                    </div>
                <?php endwhile;
                wp_reset_query();
                ?>
            <?php else : ?>
                <p>Работы еще не добавлены.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php require_once(TEMPLATE_PATH . '_cta.php'); ?>
<?php get_footer(); ?>