<?php

/**
 * Данные для отзывов (имитация ACF)
 */
$yandex_rating = '4.7'; // Общий рейтинг
$yandex_link = get_field('yandex_maps_link', 'option') ?: '#'; // Ссылка на карты

$reviews = [
    [
        'text'   => 'Большое спасибо за качественно выполненную работу. Уборка проведена со знанием дела. Все поверхности посто блестят! На мой взгляд оптимальное сочетание цены и качества. Буду обращаться еще.',
        'author' => 'Гудкова Оля',
        'avatar' => get_template_directory_uri() . '/assets/review_avatar_1.jpg',
        'link'   => 'https://yandex.by/maps/user/ezdtrbwkhj1tgqfm8xa8xuuqh8'
    ],
    [
        'text'   => 'Сделали ремонт и случайно наткнулись на эту компанию. Нашему счастью нет предела. Во первых клиентоориентированность на высшем уровне, договорились о дате и времени без проблем. Во вторых никаких изъян после уборки мы не обнаружили.',
        'author' => 'Ксения Малинина',
        'avatar' => get_template_directory_uri() . '/assets/review_avatar_2.webp',
        'link'   => 'https://yandex.by/maps/user/g70x1e32czmjfarc3vhwqe1c98'
    ],
    [
        'text'   => 'Персонал отлично справился со своим делом. После ремонта не успела убрать всё, решила вызвать клиннинг. В выборе вашей компании я не ошиблась! Убрали все отлично, даже стало легче дышать.',
        'author' => 'Лина Артамонова',
        'avatar' => get_template_directory_uri() . '/assets/review_avatar_3.webp',
        'link'   => 'https://yandex.by/maps/user/ev6c5e9wjypppwruju1a31mmjr'
    ],
    [
        'text'   => 'Очень довольна работой этой клининговой компании! Они сделали уборку быстро и качественно, оставив квартиру идеально чистой. Обязательно обращусь к ним снова и рекомендую всем.',
        'author' => 'Элна X.',
        'avatar' => get_template_directory_uri() . '/assets/review_avatar_4.webp',
        'link'   => '#'
    ],
    [
        'text'   => 'Обратилась в клининговую компанию для проведения уборки после сдачи квартиры. Работу выполнили качественно и в оговорённые сроки. Ни каких следов прежнего проживания не осталось.',
        'author' => 'Ирина Бу',
        'avatar' => get_template_directory_uri() . '/assets/review_avatar_5.webp',
        'link'   => '#'
    ]
];
?>

<section class="reviews-section-new">
    <div class="container">

        <div class="reviews-header">
            <div class="reviews-header-left">
                <h2 class="reviews-title">Отзывы из <br><span>Яндекс Карт</span></h2>

                <a href="https://yandex.com/maps/org/cleaningspb1/4725499215/reviews/?ll=30.422776%2C59.954106&utm_campaign=v1&utm_medium=rating&utm_source=badge&z=16" target="_blank" class="yandex-rating-card">
                    <div class="rating-circle"><?php echo $yandex_rating; ?></div>
                    <div class="rating-info">
                        <div class="rating-stars">
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
                        <span class="rating-text">Рейтинг в Яндексе</span>
                    </div>
                </a>
            </div>

            <div class="reviews-header-right">
                <a href="<?php echo esc_url($yandex_link); ?>" target="_blank" class="btn-yandex-open">Открыть в Яндексе</a>
                <div class="reviews-nav">
                    <button class="nav-arrow prev">
                        <svg width="12" height="24" viewBox="0 0 12 24" fill="none">
                            <path d="M10 2L2 12L10 22" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                    <button class="nav-arrow next">
                        <svg width="12" height="24" viewBox="0 0 12 24" fill="none">
                            <path d="M2 2L10 12L2 22" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div class="reviews-slider-window">
            <div class="reviews-grid-new">
                <?php foreach ($reviews as $review): ?>
                    <div class="review-card-item">
                        <p class="review-text"><?php echo esc_html($review['text']); ?></p>
                        <div class="review-footer">
                            <div class="author-avatar" style="background-image: url('<?php echo esc_url($review['avatar']); ?>');"></div>
                            <div class="author-info">
                                <h4>
                                    <?php if ($review['link'] !== '#'): ?>
                                        <a href="<?php echo esc_url($review['link']); ?>" target="_blank"><?php echo esc_html($review['author']); ?></a>
                                    <?php else: ?>
                                        <?php echo esc_html($review['author']); ?>
                                    <?php endif; ?>
                                </h4>
                                <span>Источник: Яндекс</span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="reviews-mobile-indicator" id="reviews-mobile-indicator" aria-hidden="true"></div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const track = document.querySelector('.reviews-grid-new');
        const sliderWindow = document.querySelector('.reviews-slider-window');
        const cards = document.querySelectorAll('.review-card-item');
        const nextBtn = document.querySelector('.nav-arrow.next');
        const prevBtn = document.querySelector('.nav-arrow.prev');
        const mobileIndicator = document.getElementById('reviews-mobile-indicator');

        if (!track || !sliderWindow || cards.length === 0 || !nextBtn || !prevBtn) return;

        let currentIndex = 0;

        const renderMobileDots = () => {
            if (!mobileIndicator) return;
            mobileIndicator.innerHTML = '';
            cards.forEach((_, i) => {
                const dot = document.createElement('span');
                dot.className = 'reviews-mobile-indicator__dot' + (i === 0 ? ' is-active' : '');
                mobileIndicator.appendChild(dot);
            });
        };

        const updateMobileDots = () => {
            if (!mobileIndicator) return;
            const dots = mobileIndicator.querySelectorAll('.reviews-mobile-indicator__dot');
            if (!dots.length) return;
            let active = 0;
            let minDelta = Infinity;
            const windowRect = sliderWindow.getBoundingClientRect();
            cards.forEach((card, index) => {
                const rect = card.getBoundingClientRect();
                const delta = Math.abs(rect.left - windowRect.left);
                if (delta < minDelta) {
                    minDelta = delta;
                    active = index;
                }
            });
            dots.forEach((dot, i) => dot.classList.toggle('is-active', i === active));
        };

        function updateSlider() {
            if (window.innerWidth <= 700) {
                track.style.transform = 'none';
                updateMobileDots();
                return;
            }

            let visibleCards = 3;
            if (window.innerWidth <= 1024) visibleCards = 2;
            if (window.innerWidth <= 768) visibleCards = 1;

            const maxIndex = Math.max(0, cards.length - visibleCards);

            if (currentIndex > maxIndex) currentIndex = maxIndex;
            if (currentIndex < 0) currentIndex = 0;

            const card = cards[currentIndex];
            const offsetX = card ? Math.round(card.offsetLeft) : 0;
            track.style.transform = 'translateX(-' + offsetX + 'px)';

            prevBtn.style.opacity = (currentIndex === 0) ? '0.3' : '1';
            prevBtn.style.pointerEvents = (currentIndex === 0) ? 'none' : 'auto';

            nextBtn.style.opacity = (currentIndex >= maxIndex) ? '0.3' : '1';
            nextBtn.style.pointerEvents = (currentIndex >= maxIndex) ? 'none' : 'auto';
        }

        nextBtn.addEventListener('click', () => {
            currentIndex++;
            updateSlider();
        });

        prevBtn.addEventListener('click', () => {
            currentIndex--;
            updateSlider();
        });

        sliderWindow.addEventListener('scroll', () => {
            if (window.innerWidth <= 700) {
                updateMobileDots();
            }
        }, {
            passive: true
        });

        renderMobileDots();
        window.addEventListener('resize', updateSlider);
        updateSlider();
    });
</script>