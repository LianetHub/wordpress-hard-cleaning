<section class="cases-section">
    <div class="container">

        <span class="cases__hint hint">до / после</span>
        <h2 class="cases__title title">Наши <span class="color-accent">работы</span></h2>

        <div class="cases-main-flex">


            <div class="cases-visual-side">
                <div class="before-slider">
                    <div class="before-slider__layer before-slider__layer--before">
                        <img class="before-slider__image"
                            src="<?php echo get_template_directory_uri(); ?>/assets/bef-aft2.webp"
                            alt="До"
                            loading="lazy"
                            decoding="async">
                    </div>

                    <div class="before-slider__layer before-slider__layer--after">
                        <img class="before-slider__image"
                            src="<?php echo get_template_directory_uri(); ?>/assets/bef-aft1.webp"
                            alt="После"
                            loading="lazy"
                            decoding="async">
                    </div>

                    <span class="before-slider__label before-slider__label--before">До</span>
                    <span class="before-slider__label before-slider__label--after">После</span>

                    <div class="before-slider__divider">
                        <div class="before-slider__arrows">
                            <svg width="6" height="8" viewBox="0 0 6 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4.21892 0.126182L0.24656 3.1655C0.155241 3.23537 0.0913189 3.30524 0.0547914 3.37511C0.018264 3.44498 0 3.52183 0 3.60568C0 3.68952 0.018264 3.76638 0.0547914 3.83625C0.0913189 3.90612 0.155241 3.97598 0.24656 4.04585L4.21892 7.08517C4.27372 7.12709 4.33326 7.1584 4.39754 7.17908C4.46183 7.19976 4.53014 7.21038 4.60246 7.21094C4.74857 7.21094 4.87642 7.17237 4.986 7.09523C5.09559 7.0181 5.15038 6.91693 5.15038 6.79172V0.419633C5.15038 0.293868 5.09559 0.192418 4.986 0.115282C4.87642 0.0381465 4.74857 -0.000141621 4.60246 0.000417709C4.56594 0.000417709 4.43809 0.0423388 4.21892 0.126182Z" fill="white" />
                            </svg>
                            <svg width="6" height="8" viewBox="0 0 6 8" fill="none" xmlns="http://www.w3.org/2000/svg" style="transform: rotate(180deg)">
                                <path d="M4.21892 0.126182L0.24656 3.1655C0.155241 3.23537 0.0913189 3.30524 0.0547914 3.37511C0.018264 3.44498 0 3.52183 0 3.60568C0 3.68952 0.018264 3.76638 0.0547914 3.83625C0.0913189 3.90612 0.155241 3.97598 0.24656 4.04585L4.21892 7.08517C4.27372 7.12709 4.33326 7.1584 4.39754 7.17908C4.46183 7.19976 4.53014 7.21038 4.60246 7.21094C4.74857 7.21094 4.87642 7.17237 4.986 7.09523C5.09559 7.0181 5.15038 6.91693 5.15038 6.79172V0.419633C5.15038 0.293868 5.09559 0.192418 4.986 0.115282C4.87642 0.0381465 4.74857 -0.000141621 4.60246 0.000417709C4.56594 0.000417709 4.43809 0.0423388 4.21892 0.126182Z" fill="white" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ПРАВАЯ КОЛОНКА -->
            <div class="cases-info-side">
                <div class="cases-text-block">
                    <h3>Последствия ЧП? <br><span class="color-accent">Решаем — проверено!</span></h3>
                    <p>Реальные кейсы из нашей практики. Фотографии публикуются только с согласия клиентов.</p>
                </div>

                <div class="cases-cards-grid">
                    <!-- До -->
                    <div class="info-card card-white">
                        <h4>До</h4>
                        <ul>
                            <li>Загрязнения на стенах</li>
                            <li>Запах гари и дыма</li>
                            <li>Следы копоти на мебели</li>
                            <li>Повреждённые поверхности</li>
                        </ul>
                    </div>
                    <!-- После -->
                    <div class="info-card card-blue">
                        <h4>После</h4>
                        <ul>
                            <li>Очищенные поверхности</li>
                            <li>Нейтральный запах</li>
                            <li>Дезинфекция проведена</li>
                            <li>Готово к ремонту</li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
        <a href="<?php echo get_post_type_archive_link('portfolio') ?>"
            class="cases__more btn btn-primary">
            Посмотреть все работы →
        </a>
    </div>
</section>