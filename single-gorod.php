<?php

/**
 * Лендинг одного города (тип записей gorod). Шаблон: single-{post_type}.php → single-gorod.php.
 */

use HardClean\Theme;

get_header();

if (!have_posts()) {
    get_footer();
    return;
}

while (have_posts()) :
    the_post();

    $city_id = get_the_ID();

    $phone = get_field('phone', 'option');
    $phone_clean = $phone ? preg_replace('/[^\d+]/', '', $phone) : '';

    $gorod_name = get_the_title($city_id);
    $gorod_name_declined = function_exists('theme_gorod_decline_in_prepositional') ? theme_gorod_decline_in_prepositional($gorod_name) : $gorod_name;

    $heading_title = sprintf('Сложная уборка - %s', $gorod_name);
    $heading_descr = get_the_excerpt($city_id);

    $distance_label = function_exists('theme_gorod_distance_label') ? theme_gorod_distance_label($city_id) : '';

    $image_main = get_field('service_main_image', $city_id);
    if (empty($image_main)) {
        $thumb = get_the_post_thumbnail_url($city_id, 'full');
        $image_main = $thumb ? ['url' => $thumb, 'alt' => get_the_title($city_id)] : [];
    }
    $image_left = get_field('service_extr-image_1', $city_id);
    $image_right = get_field('service_extr-image_2', $city_id);
    $is_collage = !empty($image_left) || !empty($image_right);

    require_once TEMPLATE_PATH . '/components/breadcrumbs.php';
?>

    <section class="heading">
        <div class="heading__container container">
            <div class="heading__offer">
                <?php if ($distance_label !== '') : ?>
                    <div class="heading__hint hint"><?php echo esc_html($distance_label); ?></div>
                <?php endif; ?>
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
    <?php require_once(TEMPLATE_PATH . '_trust.php'); ?>
    <section class="city-services-catalog services">
        <div class="services__container container">
            <div class="services__hint hint">Спецуборка</div>
            <h2 class="services__title title">Наши услуги в <?php echo esc_html($gorod_name_declined); ?></h2>
            <p class="services__subtitle subtitle">Нажмите на услугу — расскажем подробно что входит и&nbsp;сколько стоит</p>
            <ul class="services__list">
                <?php
                $terms = get_terms([
                    'taxonomy'   => 'service_cat',
                    'hide_empty' => false,
                    'include'    => [8, 6, 4, 5, 41],
                    'orderby'    => 'include'
                ]);

                $extra_service_id = 821;
                $extra_service = get_post($extra_service_id);

                if (!empty($terms) && !is_wp_error($terms)) :
                    foreach ($terms as $term):
                        get_template_part('templates/components/card', 'service-gorod', ['item' => $term]);
                    endforeach;
                endif;

                if ($extra_service && $extra_service->post_status === 'publish') :
                    get_template_part('templates/components/card', 'service-gorod', ['item' => $extra_service]);
                endif;
                ?>
            </ul>
        </div>
    </section>

<?php
    require_once TEMPLATE_PATH . '_works-specialized.php';
    require_once(TEMPLATE_PATH . '_price.php');
    require_once(TEMPLATE_PATH . '_guarantees.php');
    if (!empty(get_the_content())): ?>
        <article class="article">
            <div class="container">
                <div class="article__content typography-block">
                    <?php the_content(); ?>
                </div>
            </div>
        </article>
   <?php endif;
    require_once(TEMPLATE_PATH . '_reviews.php');
    require_once TEMPLATE_PATH . '_faq.php';
    require_once TEMPLATE_PATH . '_cta.php';

endwhile;

get_footer();