<?php get_header(); ?>

<?php require_once(TEMPLATE_PATH . '/components/breadcrumbs.php'); ?>

<section class="article">
    <div class="container">
        <h1 class="article__title title"><?php the_title(); ?></h1>
        <div class="article__header">
            <div class="row">
                <div class="col-lg-6">
                    <div class="article__image">
                        <?php if (has_post_thumbnail()) : ?>
                            <?php the_post_thumbnail('full'); ?>
                        <?php else : ?>
                            <img src=" <?php echo get_template_directory_uri(); ?>/assets/img/3-4-thumb.svg" alt="Default Image" />
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="article__main">
                        <time datetime="<?php the_time('c'); ?>"
                            class="article__time icon-calendar"><?php the_time('d.m.Y'); ?></time>
                        <p class="article__desc">
                            <?php echo esc_html(get_field('short_desc')); ?>
                        </p>
                    </div>
                    <div class="article__info">
                        <?php
                        $long_desc = get_field('long_desc');
                        if ($long_desc) :
                        ?>
                            <div class="article__long-desc">
                                <?php echo $long_desc; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <article class="article__body typography-block">
            <?php the_content(); ?>
        </article>
    </div>
</section>

<?php

$current_post_id = get_the_ID();
$args = array(
    'post_type' => 'post',
    'posts_per_page' => 3,
    'post__not_in' => array($current_post_id),
);

$query = new WP_Query($args);

if ($query->have_posts()) :
?>
    <section class="blog">
        <div class="container">
            <h2 class="blog__title">Другие статьи</h2>
            <div class="blog__body">
                <div class="blog__grid">
                    <?php
                    while ($query->have_posts()) : $query->the_post();
                    ?>
                        <?php get_template_part('templates/components/blog-card'); ?>
                    <?php
                    endwhile;
                    wp_reset_postdata();
                    ?>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>



<?php get_footer(); ?>