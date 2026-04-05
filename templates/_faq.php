<section class="faq-section">
    <div class="container">
        <div class="faq-grid">

            <!-- Левая колонка (Заголовок + CTA) -->
            <div class="faq-left">
                <div class="faq-sticky-wrapper">
                    <div class="faq-header">
                        <span class="faq-kicker">FAQ</span>
                        <h2 class="faq-title">Частые <span class="text-blue">вопросы</span></h2>
                        <p class="faq-desc">Коротко отвечаем на главное: сроки, стоимость, безопасность и порядок работ.</p>
                    </div>

                    <div class="faq-cta-card">
                        <h3>Не нашли вопрос?</h3>
                        <p>Отправьте фото — подскажем план работ.</p>
                        <a href="#" class="btn btn-faq-white">Отправить фото</a>
                    </div>
                </div>
            </div>

            <!-- Правая колонка (Аккордеон вопросов) -->
            <div class="faq-right">

                <!-- Вопрос 1 -->
                <div class="faq-item active">
                    <!-- Белая плашка (кнопка) -->
                    <button class="faq-question">
                        <span>Сколько стоит спецуборка?</span>
                        <span class="faq-arrow">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M6 9l6 6 6-6" />
                            </svg>
                        </span>
                    </button>
                    <!-- Ответ на сером фоне (выезжает снизу) -->
                    <div class="faq-answer">
                        <div class="faq-answer-inner">
                            <p>Стоимость зависит от площади, степени загрязнения/повреждений, необходимости выноса и обработки от запахов. Мы называем ориентир после уточнения деталей, а точную стоимость — после оценки на месте или по фото/видео.</p>
                        </div>
                    </div>
                </div>

                <!-- Вопрос 2 -->
                <div class="faq-item">
                    <button class="faq-question">
                        <span>Можно ли назвать цену по фото?</span>
                        <span class="faq-arrow">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M6 9l6 6 6-6" />
                            </svg>
                        </span>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-answer-inner">
                            <p>Да, в большинстве случаев можно. По фото мы даём предварительную оценку и план работ. Финальная стоимость может немного корректироваться после осмотра на месте.</p>
                        </div>
                    </div>
                </div>

                <!-- Вопрос 3 -->
                <div class="faq-item">
                    <button class="faq-question">
                        <span>Как быстро вы можете приехать?</span>
                        <span class="faq-arrow">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M6 9l6 6 6-6" />
                            </svg>
                        </span>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-answer-inner">
                            <p>Обычно выезд возможен в день обращения или в течение 24 часов. В экстренных ситуациях (пожар, потоп и т.д.) стараемся приехать максимально быстро.</p>
                        </div>
                    </div>
                </div>

                <!-- Вопрос 4 -->
                <div class="faq-item">
                    <button class="faq-question">
                        <span>Что делать до приезда бригады?</span>
                        <span class="faq-arrow">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M6 9l6 6 6-6" />
                            </svg>
                        </span>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-answer-inner">
                            <p>По возможности ограничьте доступ в помещение. Не пытайтесь самостоятельно убирать опасные загрязнения. Если был потоп — отключите электричество, если это безопасно. Мы дадим дополнительные рекомендации после вашего обращения.</p>
                        </div>
                    </div>
                </div>

                <!-- Вопрос 5 -->
                <div class="faq-item">
                    <button class="faq-question">
                        <span>Чем спецуборка отличается от обычного клининга?</span>
                        <span class="faq-arrow">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M6 9l6 6 6-6" />
                            </svg>
                        </span>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-answer-inner">
                            <p>Спецуборка — это работа с опасными загрязнениями и сложными ситуациями. Используются профессиональные средства, оборудование и средства защиты. Проводится дезинфекция, удаление запахов и полное восстановление безопасности помещения.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const faqItems = document.querySelectorAll('.faq-item');

        // Функция для инициализации (чтобы открытый по умолчанию блок сразу получил правильную высоту)
        const initFaq = () => {
            faqItems.forEach(item => {
                if (item.classList.contains('active')) {
                    const answer = item.querySelector('.faq-answer');
                    answer.style.maxHeight = answer.scrollHeight + "px";
                }
            });
        }

        // Запускаем инициализацию при загрузке
        initFaq();

        // Обработчик кликов
        faqItems.forEach(item => {
            const questionBtn = item.querySelector('.faq-question');

            questionBtn.addEventListener('click', () => {
                const isActive = item.classList.contains('active');

                // Сначала закрываем все открытые вопросы (опционально, но так красивее)
                faqItems.forEach(otherItem => {
                    otherItem.classList.remove('active');
                    otherItem.querySelector('.faq-answer').style.maxHeight = 0;
                });

                // Если кликнули по закрытому — открываем
                if (!isActive) {
                    item.classList.add('active');
                    const answer = item.querySelector('.faq-answer');
                    answer.style.maxHeight = answer.scrollHeight + "px";
                }
            });
        });

        // Пересчет высоты при ресайзе окна (чтобы текст не обрезался, если пользователь повернет телефон)
        window.addEventListener('resize', () => {
            initFaq();
        });
    });
</script>