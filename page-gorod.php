<?php

/**
 * Template Name: Города — хаб
 * Description: Ярлык uborka-v-gorodah. Шапка: как single-services (service_*). Секция каталога: goroda_directory_hint, goroda_directory_title (HTML, span.color-accent), goroda_directory_subtitle; фильтры — разметка как page-documents (swiper + filters__item).
 */

get_header();

while (have_posts()) :
    the_post();

    $page_id = get_the_ID();

    $filter_slug = isset($_GET['usluga']) ? sanitize_title(wp_unslash($_GET['usluga'])) : '';

    $filter_term = null;
    if ($filter_slug !== '') {
        $filter_term = get_term_by('slug', $filter_slug, 'service_cat');
        if (!$filter_term || is_wp_error($filter_term)) {
            $filter_term = null;
        }
    }

    $filter_letter = isset($_GET['letter']) ? sanitize_text_field(wp_unslash($_GET['letter'])) : '';
    if ($filter_letter !== '') {
        $filter_letter = mb_strtoupper(mb_substr(trim($filter_letter), 0, 1, 'UTF-8'), 'UTF-8');
    }
    if ($filter_letter !== '' && !preg_match('/^[А-ЯЁ]$/u', $filter_letter)) {
        $filter_letter = '';
    }

    $cities_query = new WP_Query([
        'post_type'      => 'gorod',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'orderby'        => 'title',
        'order'          => 'ASC',
    ]);

    $unique_first_letters = function_exists('theme_get_unique_city_first_letters')
        ? theme_get_unique_city_first_letters()
        : [];

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

    $phone = get_field('phone', 'option');
    $phone_clean = $phone ? preg_replace('/[^\d+]/', '', $phone) : '';

    $heading_title = get_field('service_title', $page_id) ?: get_the_title();
    $heading_descr = get_field('service_subtitle', $page_id);
    if ($heading_descr === null || $heading_descr === '') {
        $heading_descr = $subtitle;
    }

    $image_main = get_field('service_main_image', $page_id);
    if (empty($image_main)) {
        $thumb = get_the_post_thumbnail_url($page_id, 'full');
        $image_main = $thumb ? ['url' => $thumb, 'alt' => get_the_title()] : [];
    }
    $image_left = get_field('service_extra_image_1', $page_id);
    $image_right = get_field('service_extra_image_2', $page_id);

    $is_collage = !empty($image_left) || !empty($image_right);

    $dir_hint = 'Каталог';
    $dir_title_html = 'Города — <span class="color-accent">выберите направление</span>';
    $dir_subtitle = 'Выберите, что случилось — и увидите все города';
    if (function_exists('get_field')) {
        $h = get_field('goroda_directory_hint', $page_id);
        if (is_string($h) && $h !== '') {
            $dir_hint = $h;
        }
        $t = get_field('goroda_directory_title', $page_id);
        if (is_string($t) && $t !== '') {
            $dir_title_html = $t;
        }
        $s = get_field('goroda_directory_subtitle', $page_id);
        if (is_string($s) && $s !== '') {
            $dir_subtitle = $s;
        }
    }

    require_once TEMPLATE_PATH . '/components/breadcrumbs.php';
?>

    <section class="heading">
        <div class="heading__container container">
            <div class="heading__offer">
                <h1 class="heading__title title-lg"><?php echo esc_html($heading_title); ?></h1>
                <?php if ($heading_descr) : ?>
                    <p class="heading__subtitle subtitle"><?php echo esc_html(fix_widows_after_prepositions(wp_strip_all_tags($heading_descr))); ?></p>
                <?php endif; ?>
                <div class="heading__btns">
                    <?php if ($phone) : ?>
                        <a href="tel:<?php echo esc_attr($phone_clean); ?>" class="heading__btn btn btn-secondary">Срочный вызов</a>
                    <?php endif; ?>
                    <a href="#callback" data-fancybox class="heading__btn btn btn-outline">Оставить заявку</a>
                </div>
            </div>

            <?php if ($is_collage) : ?>
                <div class="heading__images">
                    <?php if (!empty($image_left)) : ?>
                        <div class="heading__images-block heading__images-left">
                            <img src="<?php echo esc_url($image_left['url']); ?>"
                                alt="<?php echo esc_attr($image_left['alt'] ?: $heading_title); ?>"
                                fetchpriority="high"
                                class="cover-image">
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($image_main['url'])) : ?>
                        <div class="heading__images-block heading__images-center">
                            <img src="<?php echo esc_url($image_main['url']); ?>"
                                alt="<?php echo esc_attr(($image_main['alt'] ?? '') ?: $heading_title); ?>"
                                fetchpriority="high"
                                class="cover-image">
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($image_right)) : ?>
                        <div class="heading__images-block heading__images-right">
                            <img src="<?php echo esc_url($image_right['url']); ?>"
                                alt="<?php echo esc_attr($image_right['alt'] ?: $heading_title); ?>"
                                fetchpriority="high"
                                class="cover-image">
                        </div>
                    <?php endif; ?>
                </div>
            <?php else : ?>
                <div class="heading__image">
                    <?php if (!empty($image_main['url'])) : ?>
                        <img src="<?php echo esc_url($image_main['url']); ?>"
                            alt="<?php echo esc_attr(($image_main['alt'] ?? '') ?: $heading_title); ?>"
                            fetchpriority="high"
                            class="cover-image">
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
   
    <section class="goroda-directory">
        <div class="container">
            <div class="goroda-directory__hint hint"><?php echo esc_html($dir_hint); ?></div>
            <h2 class="goroda-directory__title title">
                <?php echo wp_kses($dir_title_html, ['span' => ['class' => []], 'br' => []]); ?>
            </h2>
            <p class="goroda-directory__subtitle subtitle"><?php echo esc_html(fix_widows_after_prepositions($dir_subtitle)); ?></p>

            <div class="goroda-directory__filters filters swiper">
                <div class="swiper-wrapper">
                    <?php $all_active = ($filter_letter === '') ? 'active' : ''; ?>
                    <button type="button"
                        data-letter="all"
                        class="filters__item goroda-letter-filter swiper-slide btn btn-sm btn-outline <?php echo esc_attr($all_active); ?>">
                        <?php echo esc_html('Все'); ?>
                    </button>
                    <?php foreach ($unique_first_letters as $letter) : ?>
                        <?php $item_active = ($filter_letter === $letter) ? 'active' : ''; ?>
                        <button type="button"
                            data-letter="<?php echo esc_attr($letter); ?>"
                            class="filters__item goroda-letter-filter swiper-slide btn btn-sm btn-outline <?php echo esc_attr($item_active); ?>">
                            <?php echo esc_html($letter); ?>
                        </button>
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
                        get_template_part('templates/components/card', 'city-directory', [
                            'city_post'     => $gorod_post,
                            'letter_filter' => $filter_letter,
                        ]);
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
    <?php require_once(TEMPLATE_PATH . '_faq.php'); ?>
    <?php require_once(TEMPLATE_PATH . '_cta.php'); ?>

<?php
endwhile;

get_footer();
