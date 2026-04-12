<?php

/**
 * Template Name: Page Reviews
 */
get_header(); ?>
<?php require_once(TEMPLATE_PATH . '/components/breadcrumbs.php'); ?>
<?php
$yandex_rating = get_field('yandex_reviews_value', 'option') ?: '5.0';
$yandex_link_data = get_field('yandex_reviews_link', 'option');
$yandex_link = is_array($yandex_link_data) ? $yandex_link_data['url'] : ($yandex_link_data ?: '#');

$reviews_query = new WP_Query([
    'post_type'      => 'reviews',
    'posts_per_page' => -1,
    'orderby'        => 'date',
    'order'          => 'ASC'
]);

$reviews_hint     = get_field('reviews_hint') ?: 'Отзывы клиентов';
$reviews_title    = get_field('reviews_title');
$reviews_subtitle = get_field('reviews_subtitle');
?>

<section class="reviews reviews--page">
    <div class="container">
        <?php if ($reviews_hint): ?>
            <div class="reviews__hint hint">
                <?php echo esc_html($reviews_hint); ?>
            </div>
        <?php endif; ?>
        <h2 class="reviews__title title">
            <?php echo esc_html($reviews_title); ?>
        </h2>
        <?php if ($reviews_subtitle): ?>
            <p class="reviews__subtitle subtitle">
                <?php echo esc_html($reviews_subtitle); ?>
            </p>
        <?php endif; ?>
        <?php if ($reviews_query->have_posts()):
            $all_reviews = $reviews_query->posts;

            $columns = [[], [], []];

            foreach ($all_reviews as $key => $post) {
                $columns[$key % 3][] = $post;
            }
        ?>
            <div class="reviews__grid">
                <?php foreach ($columns as $index => $column_posts): ?>
                    <div class="reviews__column">
                        <?php foreach ($column_posts as $post): ?>
                            <?php get_template_part(
                                'templates/components/review-card',
                                null,
                                ['id' => $post->ID]
                            ); ?>
                        <?php endforeach; ?>

                        <?php if ($index === 1):
                        ?>
                            <a href="<?php echo esc_url($yandex_link); ?>"
                                target="_blank"
                                class="reviews__column-btn btn btn-primary">
                                Посмотреть все отзывы
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php wp_reset_postdata();
        endif; ?>
        <a href="<?php echo esc_url($yandex_link); ?>"
            target="_blank"
            class="reviews__all-link btn btn-primary">
            Посмотреть все отзывы
        </a>
    </div>
</section>

<section class="yandex-banner">
    <div class="container">
        <div class="yandex-banner__content">
            <div class="yandex-banner__brand">
                <div class="yandex-banner__logo">
                    <img
                        src="<?php echo get_template_directory_uri() ?>/assets/img/yandex-logo.svg"
                        width="78"
                        height="78"
                        loading="lazy"
                        alt="Яндекс">
                </div>
                <div class="yandex-banner__info">
                    <h2 class="yandex-banner__name">Мы на Яндекс.Картах</h2>
                    <p class="yandex-banner__hint">Читайте и оставляйте отзывы напрямую</p>
                </div>
            </div>

            <div class="yandex-banner__rating rating-yandex">
                <div class="rating-yandex__value"><?php echo esc_html($yandex_rating); ?></div>
                <div class="rating-yandex__stars">
                    <?php
                    $rating_val = (float)$yandex_rating;
                    for ($i = 1; $i <= 5; $i++):
                        $star_color = ($i <= floor($rating_val)) ? '#F4B942' : '#FBE7BD';
                    ?>
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="19"
                            viewBox="0 0 20 19" fill="<?php echo $star_color; ?>">
                            <path d="M9.98633 0L12.3437 7.25532H19.9724L13.8007 11.7394L16.1581 18.9947L9.98633 14.5106L3.81458 18.9947L6.17198 11.7394L0.000234604 7.25532H7.62893L9.98633 0Z" />
                        </svg>
                    <?php endfor; ?>
                </div>
                <div class="rating-yandex__label">на основе отзывов</div>
            </div>
            <div class="yandex-banner__action">
                <a href="<?php echo esc_url($yandex_link); ?>"
                    target="_blank"
                    class="yandex-banner__btn btn btn-primary">
                    Читать на Яндекс Картах
                </a>
            </div>
        </div>
    </div>
</section>
<?php require_once(TEMPLATE_PATH . '_cta.php'); ?>

<?php get_footer(); ?>