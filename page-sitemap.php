<?php

/**
 * Template Name: Page Sitemap
 */
get_header(); ?>

<?php require_once(TEMPLATE_PATH . '/components/breadcrumbs.php'); ?>

<section class="heading">
    <div class="heading__container container">
        <div class="heading__offer">
            <h1 class="heading__title title-lg">
                <?php the_title(); ?>
            </h1>
        </div>
    </div>
</section>

<?php if (!empty(get_the_content())): ?>
    <article class="article">
        <div class="container">
            <div class="article__content typography-block">
                <?php the_content(); ?>
            </div>
        </div>
    </article>
<?php endif; ?>

<section class="sitemap">
    <div class="container">
        <div class="sitemap__grid">
            <?php
            $post_types = [
                'page'      => 'Страницы',
                'services'  => 'Услуги',
                'portfolio' => 'Портфолио',
                'post'      => 'Статьи'
            ];

            foreach ($post_types as $type => $label) :
                $query = new WP_Query([
                    'post_type'      => $type,
                    'posts_per_page' => -1,
                    'post_status'    => 'publish',
                    'orderby'        => 'title',
                    'order'          => 'ASC',
                ]);

                if ($query->have_posts()) :
                    if ($type === 'services') :
                        $spb_services = [];
                        $region_services = [];

                        while ($query->have_posts()) : $query->the_post();
                            if (class_exists('WPSEO_Options')) {
                                $noindex = get_post_meta(get_the_ID(), '_yoast_wpseo_meta-robots-noindex', true);
                                if ($noindex === '1' || $noindex === 1) continue;
                            }

                            $city = get_field('current_city');
                            $item = [
                                'link'  => get_permalink(),
                                'title' => get_the_title()
                            ];

                            if ($city === 'Санкт-Петербург') {
                                $spb_services[] = $item;
                            } else {
                                $region_services[] = $item;
                            }
                        endwhile;

                        if (!empty($spb_services)) : ?>
                            <div class="sitemap__section typography-block">
                                <h2 class="sitemap__type-title"><?php echo esc_html($label); ?></h2>
                                <ul class="sitemap__list">
                                    <?php foreach ($spb_services as $svc) : ?>
                                        <li class="sitemap__item">
                                            <a href="<?php echo $svc['link']; ?>" class="sitemap__link"><?php echo $svc['title']; ?></a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif;

                        if (!empty($region_services)) : ?>
                            <div class="sitemap__section typography-block">
                                <h2 class="sitemap__type-title">Услуги в городах</h2>
                                <ul class="sitemap__list">
                                    <?php foreach ($region_services as $svc) : ?>
                                        <li class="sitemap__item">
                                            <a href="<?php echo $svc['link']; ?>" class="sitemap__link"><?php echo $svc['title']; ?></a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif;
                    else :
                        $has_visible_posts = false;
                        ob_start();
                        ?>
                        <ul class="sitemap__list">
                            <?php while ($query->have_posts()) : $query->the_post();
                                if (class_exists('WPSEO_Options')) {
                                    $noindex = get_post_meta(get_the_ID(), '_yoast_wpseo_meta-robots-noindex', true);
                                    if ($noindex === '1' || $noindex === 1) continue;
                                }
                                $has_visible_posts = true;
                            ?>
                                <li class="sitemap__item">
                                    <a href="<?php the_permalink(); ?>" class="sitemap__link"><?php the_title(); ?></a>
                                </li>
                            <?php endwhile; ?>
                        </ul>
                        <?php
                        $list_content = ob_get_clean();
                        if ($has_visible_posts) : ?>
                            <div class="sitemap__section typography-block">
                                <h2 class="sitemap__type-title"><?php echo esc_html($label); ?></h2>
                                <?php echo $list_content; ?>
                            </div>
                <?php endif;
                    endif;
                endif;
                wp_reset_postdata(); ?>
            <?php endforeach; ?>

            <?php
            $taxonomies = [
                'service_cat' => 'Категории услуг',
                'category'    => 'Категории блога'
            ];

            foreach ($taxonomies as $tax => $label) :
                $terms = get_terms([
                    'taxonomy'   => $tax,
                    'hide_empty' => true,
                    'exclude'    => ($tax === 'category') ? get_option('default_category') : '',
                ]);

                if (!empty($terms) && !is_wp_error($terms)) :
                    $rendered_terms = 0;
                    ob_start();
            ?>
                    <ul class="sitemap__list">
                        <?php foreach ($terms as $term) :
                            if (class_exists('WPSEO_Options')) {
                                $tax_noindex = get_term_meta($term->term_id, 'wpseo_noindex', true);
                                if ($tax_noindex === 'noindex') continue;
                            }
                            if ($term->slug === 'uncategorized') continue;
                            $rendered_terms++;
                        ?>
                            <li class="sitemap__item">
                                <a href="<?php echo get_term_link($term); ?>" class="sitemap__link"><?php echo $term->name; ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <?php
                    $tax_list_content = ob_get_clean();
                    if ($rendered_terms > 0) : ?>
                        <div class="sitemap__section typography-block">
                            <h2 class="sitemap__type-title"><?php echo esc_html($label); ?></h2>
                            <?php echo $tax_list_content; ?>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>