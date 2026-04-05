<section class="reviews-section-new">
    <div class="container">

        <!-- Шапка блока -->
        <div class="reviews-header">
            <div class="reviews-header-left">
                <h2 class="reviews-title">Отзывы из <br><span>Яндекс Карт</span></h2>

                <!-- Плашка рейтинга -->
                <div class="yandex-rating-card">
                    <div class="rating-circle">4,7</div>
                    <div class="rating-info">
                        <div class="rating-stars">
                            <?php for ($i = 0; $i < 4; $i++): ?>
                                <svg width="11" height="11" viewBox="0 0 11 11" fill="#F4B942">
                                    <path d="M5.5 0L6.73482 3.79321H10.7246L7.4949 6.13858L8.72972 9.93179L5.5 7.58642L2.27028 9.93179L3.5051 6.13858L0.275386 3.79321H4.26518L5.5 0Z" />
                                </svg>
                            <?php endfor; ?>
                            <svg width="11" height="11" viewBox="0 0 11 11" fill="#FBE7BD">
                                <path d="M5.5 0L6.73482 3.79321H10.7246L7.4949 6.13858L8.72972 9.93179L5.5 7.58642L2.27028 9.93179L3.5051 6.13858L0.275386 3.79321H4.26518L5.5 0Z" />
                            </svg>
                        </div>
                        <span class="rating-text">Рейтинг в Яндексе</span>
                    </div>
                </div>
            </div>

            <div class="reviews-header-right">
                <a href="#" class="btn-yandex-open">Открыть в Яндексе</a>
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

        <!-- Сетка отзывов -->
        <div class="reviews-slider-window">
            <div class="reviews-grid-new">

                <!-- Отзыв 1 -->
                <div class="review-card-item">
                    <p class="review-text">Большое спасибо за качественно выполненную работу. Уборка проведена со знанием дела. Все поверхности посто блестят! На мой взгляд оптимальное сочетание цены и качества. Буду обращаться еще.</p>
                    <div class="review-footer">
                        <div class="author-avatar" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/review_avatar_1.jpg');"></div>
                        <div class="author-info">
                            <h4><a href="https://yandex.by/maps/user/ezdtrbwkhj1tgqfm8xa8xuuqh8?ll=27.701393%2C52.858248&z=7" target="_blank">Гудкова Оля</a></h4>
                            <span>Источник: Яндекс</span>
                        </div>
                    </div>
                </div>

                <!-- Отзыв 2 -->
                <div class="review-card-item">
                    <p class="review-text">Сделали ремонт и случайно наткнулись на эту компанию. Нашему счастью нет предела. Во первых клиентоориентированность на высшем уровне, договорились о дате и времени без проблем. Во вторых никаких изъян после уборки мы не обнаружили. Так что теперь советуем всем знакомым эту компанию!</p>
                    <div class="review-footer">
                        <div class="author-avatar" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/review_avatar_2.webp');"></div>
                        <div class="author-info">
                            <h4><a href="https://yandex.by/maps/user/g70x1e32czmjfarc3vhwqe1c98?ll=27.701393%2C52.858248&z=7" target="_blank">Ксения Малинина</a></h4>
                            <span>Источник: Яндекс</span>
                        </div>
                    </div>
                </div>

                <!-- Отзыв 3 -->
                <div class="review-card-item">
                    <p class="review-text">Персонал отлично справился со своим делом. После ремонта не успела убрать всё, решила вызвать клиннинг. В выборе вашей компании я не ошиблась! Убрали все отлично, даже стало легче дышать. Нет такого, что я не понимаю что и где, наоборот всё сделано просто, но аккуратно.</p>
                    <div class="review-footer">
                        <div class="author-avatar" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/review_avatar_3.webp');"></div>
                        <div class="author-info">
                            <h4><a href="https://yandex.by/maps/user/ev6c5e9wjypppwruju1a31mmjr?ll=27.701393%2C52.858248&z=7" target="_blank">Лина Артамонова</a></h4>
                            <span>Источник: Яндекс</span>
                        </div>
                    </div>
                </div>
                <!-- Отзыв 4 -->
                <div class="review-card-item">
                    <p class="review-text">Очень довольна работой этой клининговой компании! Они сделали уборку быстро и качественно, оставив квартиру идеально чистой. Обязательно обращусь к ним снова и рекомендую всем
                    </p>
                    <div class="review-footer">
                        <div class="author-avatar" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/review_avatar_4.webp');"></div>
                        <div class="author-info">
                            <h4><a href="#" target="_blank">Элна X.</a></h4>
                            <span>Источник: Яндекс</span>
                        </div>
                    </div>
                </div>
                <!-- Отзыв 5 -->
                <div class="review-card-item">
                    <p class="review-text">Обратилась в клининговую компанию для проведения уборки после сдачи квартиры. Работу выполнили качественно и в оговорённые сроки. Ни каких следов прежнего проживания не осталось. Квартира после уборки выглядит чистой и свежей - полностью готова к заселению новых жильцов. Огромное спасибо за профессиональный подход. Рекомендую!
                    </p>
                    <div class="review-footer">
                        <div class="author-avatar" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/review_avatar_5.webp');"></div>
                        <div class="author-info">
                            <h4><a href="#" target="_blank">Ирина Бу</a></h4>
                            <span>Источник: Яндекс</span>
                        </div>
                    </div>
                </div>
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