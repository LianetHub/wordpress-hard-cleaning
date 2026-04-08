<section class="faq">
    <div class="faq__container container">

        <div class="faq__main">
            <div class="faq__header">
                <span class="faq__hint hint">FAQ</span>
                <h2 class="faq__title title">Частые <span class="color-accent">вопросы</span></h2>
                <p class="faq__subtitle subtitle">Коротко отвечаем на главное: сроки, стоимость, безопасность и порядок работ.</p>
            </div>

            <div class="faq__cta">
                <h3 class="faq__cta-title">Не нашли вопрос?</h3>
                <p class="faq__cta-subtitle">Отправьте фото — подскажем план работ.</p>
                <a href="#" class="faq__cta-btn btn btn-white">Отправить фото</a>
            </div>
        </div>

        <?php if (have_rows('faq_list', 'options')): ?>
            <ul class="faq__list">
                <?php $count = 0; ?>
                <?php while (have_rows('faq_list', 'options')): the_row(); ?>
                    <li class="faq__item <?php echo ($count === 0) ? 'active' : ''; ?>">
                        <button class="faq__question">
                            <span><?php the_sub_field('question'); ?></span>
                            <span class="faq__arrow">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M6 9l6 6 6-6" />
                                </svg>
                            </span>
                        </button>

                        <div class="faq__answer">
                            <div class="faq__answer-inner">
                                <?php the_sub_field('answer'); ?>
                            </div>
                        </div>
                    </li>
                    <?php $count++; ?>
                <?php endwhile; ?>
            </ul>
        <?php endif; ?>

    </div>
</section>