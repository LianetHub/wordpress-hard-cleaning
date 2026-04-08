<?php
$hint = get_field('trust_hint');
$title = get_field('trust_title');
$subtitle = get_field('trust_subtitle');
$bg_class = get_field('trust_bg_variant') ?: 'bg-white';

$wrapper_tag = $title ? 'section' : 'div';
?>

<<?php echo $wrapper_tag; ?> class="trust <?php echo esc_attr($bg_class); ?>">
    <div class="container">
        <?php if ($hint): ?>
            <div class="trust__hint hint"><?php echo esc_html($hint); ?></div>
        <?php endif; ?>

        <?php if ($title): ?>
            <h2 class="trust__title title"><?php echo $title; ?></h2>
        <?php endif; ?>

        <?php if ($subtitle): ?>
            <p class="trust__subtitle"><?php echo esc_html($subtitle); ?></p>
        <?php endif; ?>

        <?php if (have_rows('trust_cards')): ?>
            <div class="trust__slider swiper">
                <ul class="swiper-wrapper">
                    <?php while (have_rows('trust_cards')): the_row();
                        $icon = get_sub_field('icon');
                        $card_title = get_sub_field('title');
                        $descr = get_sub_field('descr');
                    ?>
                        <li class="trust__card swiper-slide">
                            <?php if ($icon): ?>
                                <div class="trust__card-icon">
                                    <img src="<?php echo esc_url($icon['url']); ?>"
                                        alt="<?php echo esc_attr($icon['alt'] ?: $card_title); ?>">
                                </div>
                            <?php endif; ?>

                            <?php if ($card_title): ?>
                                <h4 class="trust__card-caption"><?php echo esc_html($card_title); ?></h4>
                            <?php endif; ?>

                            <?php if ($descr): ?>
                                <p class="trust__card-description"><?php echo esc_html($descr); ?></p>
                            <?php endif; ?>
                        </li>
                    <?php endwhile; ?>
                </ul>
                <div class="trust__slider-pagination swiper-pagination"></div>
            </div>
        <?php endif; ?>
    </div>
</<?php echo $wrapper_tag; ?>>