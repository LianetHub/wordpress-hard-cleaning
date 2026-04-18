<?php

/**
 * Template Name: Page Documents
 */
get_header();

$active_filter = isset($_GET['type']) ? sanitize_text_field($_GET['type']) : 'all';

$docs_query = new WP_Query([
    'post_type'      => 'certificates',
    'posts_per_page' => -1,
    'post_status'    => 'publish'
]);

$found_any = false; // Флаг для проверки видимых элементов на уровне PHP
?>

<?php require_once(TEMPLATE_PATH . '/components/breadcrumbs.php'); ?>

<section class="certs">
    <div class="container">
        <div class="certs__hint hint">Документы</div>
        <h1 class="certs__title title-lg">Сертификаты <span class="color-accent">и лицензии</span></h1>
        <p class="certs__subtitle subtitle">Нажмите на документ, чтобы открыть в полном размере</p>

        <div class="certs__filters filters swiper">
            <div class="swiper-wrapper">
                <?php
                $doc_types = [
                    'all'         => 'Все документы',
                    'offer'       => 'Договоры оферты',
                    'license'     => 'Лицензии',
                    'certificate' => 'Сертификаты'
                ];

                foreach ($doc_types as $value => $label):
                    $is_active = ($value === $active_filter) ? 'active' : '';
                ?>
                    <button type="button"
                        data-filter="<?php echo esc_attr($value); ?>"
                        class="filters__item docs-filter swiper-slide btn btn-sm btn-outline <?php echo $is_active; ?>">
                        <?php echo esc_html($label); ?>
                    </button>
                <?php endforeach; ?>
            </div>
        </div>

        <ul class="certs__grid">
            <?php if ($docs_query->have_posts()): while ($docs_query->have_posts()): $docs_query->the_post();
                    $type = get_field('cert_type');

                    $type_value = (!empty($type['value'])) ? $type['value'] : 'certificate';
                    $type_label = (!empty($type['label'])) ? $type['label'] : 'Сертификат';

                    $gallery = get_field('cert_gallery');
                    $is_visible = ($active_filter === 'all' || $active_filter === $type_value);
                    if ($is_visible) $found_any = true;

                    $display_style = $is_visible ? 'display: flex;' : 'display: none;';
            ?>
                    <?php if ($gallery):
                        $first_image = $gallery[0];
                        $gallery_data = [];
                        foreach ($gallery as $img) {
                            $gallery_data[] = [
                                'src'     => $img['url'],
                                'caption' => get_the_title()
                            ];
                        }
                        $json_gallery = esc_attr(json_encode($gallery_data));
                    ?>
                        <li class="certs__item"
                            data-type="<?php echo esc_attr($type_value); ?>"
                            style="<?php echo $display_style; ?>">

                            <a href="<?php echo esc_url($first_image['url']); ?>"
                                class="certs__item-image icon-zoom"
                                data-fancybox-gallery
                                data-gallery='<?php echo $json_gallery; ?>'>
                                <img src="<?php echo esc_url($first_image['url']); ?>"
                                    alt="<?php echo esc_attr($first_image['alt']); ?>"
                                    class="cover-image">
                            </a>

                            <div class="certs__item-name"><?php the_title(); ?></div>

                            <div class="certs__item-footer">
                                <div class="certs__item-type"><?php echo esc_html($type_label); ?></div>
                                <button type="button"
                                    class="certs__item-btn btn btn-primary"
                                    data-fancybox-gallery
                                    data-gallery='<?php echo $json_gallery; ?>'>
                                    Смотреть
                                </button>
                            </div>
                        </li>
                    <?php endif; ?>
                <?php endwhile;
                wp_reset_postdata(); ?>

                <div class="certs__empty"
                    style="<?php echo $found_any ? 'display: none;' : 'display: block;'; ?>">
                    <p>Документов в данной категории пока нет.</p>
                </div>

            <?php else: ?>
                <div class="certs__empty">
                    <p>Документы скоро будут добавлены.</p>
                </div>
            <?php endif; ?>
        </ul>
    </div>
</section>

<?php get_footer(); ?>