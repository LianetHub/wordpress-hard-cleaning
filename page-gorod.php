<?php

/**
 * Template Name: Города — хаб
 * Description: Список городов и фильтры. Задайте ярлык страницы uborka-v-gorodah для URL /uborka-v-gorodah/. Заголовок, контент и поля ACF настраиваются на этой странице.
 */

get_header();

while (have_posts()) :
    the_post();

    $page_id = get_the_ID();
    $catalog_url = get_permalink();

    $filter_slug = isset($_GET['usluga']) ? sanitize_title(wp_unslash($_GET['usluga'])) : '';

    $filter_term = null;
    if ($filter_slug !== '') {
        $filter_term = get_term_by('slug', $filter_slug, 'service_cat');
        if (!$filter_term || is_wp_error($filter_term)) {
            $filter_term = null;
        }
    }

    $filter_parent = get_term_by('slug', 'uborka-v-gorodah', 'service_cat');
    $scenario_terms = [];
    if ($filter_parent && !is_wp_error($filter_parent)) {
        $scenario_terms = get_terms([
            'taxonomy'   => 'service_cat',
            'parent'     => $filter_parent->term_id,
            'hide_empty' => false,
        ]);
    }
    if (is_wp_error($scenario_terms)) {
        $scenario_terms = [];
    }

    $cities_query = new WP_Query([
        'post_type'      => 'gorod',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'orderby'        => 'title',
        'order'          => 'ASC',
    ]);

    $cities_in_archive = (int) $cities_query->found_posts;

    $default_subtitle = 'Выберите, что случилось — и увидите все города';
    $subtitle = '';
    if (function_exists('get_field')) {
        $acf_sub = get_field('goroda_hub_subtitle', $page_id);
        if (is_string($acf_sub) && $acf_sub !== '') {
            $subtitle = $acf_sub;
        }
    }
    if ($subtitle === '') {
        $subtitle = has_excerpt() ? get_the_excerpt() : $default_subtitle;
    }

    require_once TEMPLATE_PATH . '/components/breadcrumbs.php';
?>

    <section class="heading heading--city-archive">
        <div class="heading__container container">
            <div class="heading__offer">
                <h1 class="heading__title title-lg"><?php echo esc_html(get_the_title()); ?></h1>
                <p class="heading__subtitle subtitle"><?php echo esc_html(fix_widows_after_prepositions(wp_strip_all_tags($subtitle))); ?></p>
            </div>
        </div>
    </section>
    <?php require_once(TEMPLATE_PATH . '_trust.php'); ?>



    <section class="goroda-directory">
        <div class="container">
            <div class="goroda-directory__filters catalog__filters">
                <div class="goroda-directory__chips">
                    <a href="<?php echo esc_url($catalog_url); ?>"
                        class="goroda-directory__chip btn btn-outline btn-sm <?php echo $filter_slug === '' ? 'is-active' : ''; ?>">
                        Все города
                    </a>
                    <?php foreach ($scenario_terms as $st) : ?>
                        <a href="<?php echo esc_url(add_query_arg('usluga', $st->slug, $catalog_url)); ?>"
                            class="goroda-directory__chip btn btn-outline btn-sm <?php echo ($filter_term && (int) $filter_term->term_id === (int) $st->term_id) ? 'is-active' : ''; ?>">
                            <?php echo esc_html($st->name); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="goroda-directory__grid">
                <?php
                $shown_cities = 0;
                if ($cities_query->have_posts()) :
                    foreach ($cities_query->posts as $gorod_post) :
                        if ($filter_term) {
                            $check = new WP_Query([
                                'post_type'              => 'services',
                                'post_status'            => 'publish',
                                'posts_per_page'         => 1,
                                'fields'                 => 'ids',
                                'no_found_rows'          => true,
                                'update_post_meta_cache' => false,
                                'meta_query'             => [
                                    [
                                        'key'     => 'gorod_city',
                                        'value'   => $gorod_post->ID,
                                        'compare' => '=',
                                        'type'    => 'NUMERIC',
                                    ],
                                ],
                                'tax_query'              => [
                                    [
                                        'taxonomy'         => 'service_cat',
                                        'field'            => 'term_id',
                                        'terms'            => $filter_term->term_id,
                                        'include_children' => true,
                                    ],
                                ],
                            ]);
                            if (!$check->have_posts()) {
                                continue;
                            }
                        }
                        $shown_cities++;
                        get_template_part('templates/components/card', 'city-directory', ['city_post' => $gorod_post]);
                    endforeach;
                endif;
                ?>
            </div>

            <?php if ($cities_in_archive === 0) : ?>
                <p class="goroda-directory__empty subtitle">Города ещё не добавлены — создайте записи в&nbsp;разделе «Города».</p>
            <?php elseif ($shown_cities === 0) : ?>
                <p class="goroda-directory__empty subtitle">Нет городов с&nbsp;выбранным типом услуги — попробуйте другой фильтр.</p>
            <?php endif; ?>
        </div>
    </section>
    <?php require_once(TEMPLATE_PATH . '_work.php'); ?>
    <?php require_once(TEMPLATE_PATH . '_guarantees.php'); ?>
    <?php require_once(TEMPLATE_PATH . '_reviews.php'); ?>
    <?php require_once(TEMPLATE_PATH . '_equipment.php'); ?>
    <?php require_once(TEMPLATE_PATH . '_coverage.php'); ?>
    <?php require_once(TEMPLATE_PATH . '_faq.php'); ?>
    <?php require_once(TEMPLATE_PATH . '_cta.php'); ?>

<?php
endwhile;

get_footer();
