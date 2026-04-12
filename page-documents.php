<?php

/**
 * Template Name: Page Documents
 */
get_header(); ?>

<?php
$docs_query = new WP_Query([
    'post_type'      => 'certificates',
    'posts_per_page' => -1,
    'post_status'    => 'publish'
]);
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
                    $is_active = ($value === 'all') ? 'active' : '';
                ?>
                    <button type="button"
                        data-filter="<?php echo esc_attr($value); ?>"
                        class="filters__item swiper-slide btn btn-sm btn-outline <?php echo $is_active; ?>">
                        <?php echo esc_html($label); ?>
                    </button>
                <?php endforeach; ?>
            </div>
        </div>

        <ul class="certs__grid">
            <?php if ($docs_query->have_posts()): while ($docs_query->have_posts()): $docs_query->the_post();
                    $type = get_field('cert_type');
                    $type_value = $type['value'] ?? 'other';
                    $type_label = $type['label'] ?? 'Документ';
                    $gallery = get_field('cert_gallery');
            ?>
                    <?php if ($gallery):
                        $first_image = $gallery[0];
                        $count = count($gallery);

                        $gallery_data = [];
                        foreach ($gallery as $img) {
                            $gallery_data[] = [
                                'src'     => $img['url'],
                                'caption' => get_the_title()
                            ];
                        }
                        $json_gallery = esc_attr(json_encode($gallery_data));
                    ?>
                        <li class="certs__item" data-type="<?php echo esc_attr($type_value); ?>">
                            <a href="<?php echo esc_url($first_image['url']); ?>"
                                class="certs__item-image icon-zoom"
                                data-fancybox-gallery
                                data-gallery='<?php echo $json_gallery; ?>'>

                                <img src="<?php echo esc_url($first_image['url']); ?>"
                                    alt="<?php echo esc_attr($first_image['alt']); ?>"
                                    loading="lazy"
                                    decoding="async"
                                    class="cover-image">
                            </a>

                            <div class="certs__item-name"><?php the_title(); ?></div>
                            <div class="certs__item-footer">
                                <div class="certs__item-type"><?php echo esc_html($type_label); ?></div>

                                <a href="<?php echo esc_url($first_image['url']); ?>"
                                    class="certs__item-btn btn btn-primary"
                                    data-fancybox-gallery
                                    data-gallery='<?php echo $json_gallery; ?>'>
                                    Смотреть
                                </a>
                            </div>
                        </li>
                    <?php endif; ?>
                <?php endwhile;
                wp_reset_postdata();
            else: ?>
                <p>Документы скоро будут добавлены.</p>
            <?php endif; ?>
        </ul>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', () => {

        // Логика фильтрации
        const filterBtns = document.querySelectorAll('.filters__item');
        const certItems = document.querySelectorAll('.certs__item');

        filterBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const filter = btn.dataset.filter;
                filterBtns.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');

                certItems.forEach(item => {
                    item.style.display = (filter === 'all' || item.dataset.type === filter) ? 'block' : 'none';
                });
            });
        });

    });
</script>

<?php get_footer(); ?>