<?php

$specialized_cat_ids = [
    6,
    4,
    8,
    10,
    5,
    12,
    28
];

$specialized_posts = [];


foreach ($specialized_cat_ids as $cat_id) {
    $args = [
        'post_type'      => 'portfolio',
        'posts_per_page' => 1,
        'fields'         => 'ids',
        'meta_query'     => [
            [
                'key'     => 'case_service_link',
                'value'   => '"' . $cat_id . '"',
                'compare' => 'LIKE',
            ],
        ],
    ];

    $query = new WP_Query($args);

    if (!empty($query->posts)) {
        $specialized_posts[] = $query->posts[0];
    }
}


if (!empty($specialized_posts)) : ?>
    <section class="works works--specialized">
        <div class="container">
            <div class="works__hint hint">Примеры выполненных работ</div>
            <h2 class="works__title title">Результаты нашей <span class="color-accent">спецуборки</span></h2>

            <div class="works__grid">
                <?php
                $final_query = new WP_Query([
                    'post_type' => 'portfolio',
                    'post__in'  => $specialized_posts,
                    'orderby'   => 'post__in'
                ]);

                if ($final_query->have_posts()) :
                    while ($final_query->have_posts()) : $final_query->the_post();
                        get_template_part('templates/components/card-portfolio');
                    endwhile;
                endif;
                wp_reset_postdata();
                ?>
            </div>

            <a href="<?php echo get_post_type_archive_link('portfolio') ?>" class="cases__more btn btn-primary">
                Посмотреть все кейсы →
            </a>
        </div>
    </section>
<?php endif; ?>