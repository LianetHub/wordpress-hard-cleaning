<?php if (have_rows('trust_cards')): ?>
    <div class="trust">
        <div class="container">
            <div class="trust__slider swiper">
                <ul class="swiper-wrapper">
                    <?php while (have_rows('trust_cards')): the_row();
                        $icon = get_sub_field('icon');
                        $title = get_sub_field('title');
                        $descr = get_sub_field('descr');
                    ?>
                        <li class="trust__card swiper-slide">
                            <?php if ($icon): ?>
                                <div class="trust__card-icon">
                                    <img src="<?php echo esc_url($icon['url']); ?>"
                                        alt="<?php echo esc_attr($icon['alt'] ?: $title); ?>">
                                </div>
                            <?php endif; ?>

                            <?php if ($title): ?>
                                <h4 class="trust__card-caption"><?php echo esc_html($title); ?></h4>
                            <?php endif; ?>

                            <?php if ($descr): ?>
                                <p class="trust__card-description"><?php echo esc_html($descr); ?></p>
                            <?php endif; ?>
                        </li>
                    <?php endwhile; ?>
                </ul>
                <div class="trust__slider-pagination swiper-pagination"></div>
            </div>
        </div>
    </div>
<?php endif; ?>