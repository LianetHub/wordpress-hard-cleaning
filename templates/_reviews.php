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
?>

<section class="reviews">
    <div class="container">
        <div class="reviews__header">
            <h2 class="reviews__title title">
                Отзывы из <br>
                <span class="color-accent">Яндекс Карт</span>
            </h2>

            <a href="<?php echo esc_url($yandex_link); ?>" target="_blank" class="yandex-rating-card">
                <div class="yandex-rating-card__value"><?php echo esc_html($yandex_rating); ?></div>
                <div class="yandex-rating-card__info">
                    <div class="yandex-rating-card__stars">
                        <?php
                        $full_stars = floor((float)$yandex_rating);
                        for ($i = 1; $i <= 5; $i++):
                            $star_color = ($i <= $full_stars) ? '#F4B942' : '#FBE7BD';
                        ?>
                            <svg width="11" height="11" viewBox="0 0 11 11" fill="<?php echo $star_color; ?>">
                                <path d="M5.5 0L6.73482 3.79321H10.7246L7.4949 6.13858L8.72972 9.93179L5.5 7.58642L2.27028 9.93179L3.5051 6.13858L0.275386 3.79321H4.26518L5.5 0Z" />
                            </svg>
                        <?php endfor; ?>
                    </div>
                    <span class="yandex-rating-card__text">Рейтинг в Яндексе</span>
                </div>
            </a>

            <a href="<?php echo esc_url($yandex_link); ?>" target="_blank" class="reviews__btn btn btn-primary">Открыть в Яндексе</a>

            <div class="reviews__controls">
                <button type="button" aria-label="Назад" class="reviews__prev swiper-button-prev"></button>
                <button type="button" aria-label="Вперед" class="reviews__next swiper-button-next"></button>
            </div>
        </div>

        <?php if ($reviews_query->have_posts()): ?>
            <div class="reviews__slider swiper">
                <div class="swiper-wrapper">
                    <?php while ($reviews_query->have_posts()): $reviews_query->the_post(); ?>
                        <?php get_template_part(
                            'templates/components/review-card',
                            null,
                            [
                                'id'    => get_the_ID(),
                                'class' => 'swiper-slide'
                            ]
                        ); ?>
                    <?php endwhile;
                    wp_reset_postdata(); ?>
                </div>
                <div class="reviews__slider-pagination swiper-pagination"></div>
            </div>
        <?php endif; ?>
    </div>
</section>