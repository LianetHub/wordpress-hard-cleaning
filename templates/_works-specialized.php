<?php
$specialized_cases = [215, 242, 224, 950, 1027, 1050];

if (!empty($specialized_cases)) :
    $args = [
        'post_type'      => 'portfolio',
        'post__in'       => $specialized_cases,
        'orderby'        => 'post__in',
        'posts_per_page' => -1,
    ];

    $works_query = new WP_Query($args);

    if ($works_query->have_posts()) : ?>
        <section class="works works--specialized">
            <div class="container">
                <div class="works__hint hint">Примеры выполненных работ</div>
                <h2 class="works__title title">Результаты нашей <span class="color-accent">спецуборки</span></h2>

                <div class="works__grid">
                    <?php while ($works_query->have_posts()) : $works_query->the_post(); ?>
                        <?php get_template_part('templates/components/card-portfolio'); ?>
                    <?php endwhile; ?>
                </div>

                <a href="<?php echo get_post_type_archive_link('portfolio') ?>" class="cases__more btn btn-primary">
                    Посмотреть все работы →
                </a>
            </div>
        </section>
<?php
    endif;
    wp_reset_postdata();
endif;
?>