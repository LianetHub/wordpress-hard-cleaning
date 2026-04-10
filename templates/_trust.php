<?php
$hide_headers = get_field('trust_hide_headers');

$local_hint = get_field('trust_hint');
$local_title = get_field('trust_title');
$local_subtitle = get_field('trust_subtitle');

if ($hide_headers) {
    $hint = '';
    $title = '';
    $subtitle = '';
} else {
    $hint = !empty($local_hint) ? $local_hint : get_field('trust_hint', 'option');
    $title = !empty($local_title) ? $local_title : get_field('trust_title', 'option');
    $subtitle = !empty($local_subtitle) ? $local_subtitle : get_field('trust_subtitle', 'option');
}

$local_bg = get_field('trust_bg_variant');
$bg_class = !empty($local_bg) ? $local_bg : (get_field('trust_bg_variant', 'option') ?: 'bg-white');

$local_cards = get_field('trust_cards');
$cards = !empty($local_cards) ? $local_cards : get_field('trust_cards', 'option');

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
            <p class="trust__subtitle subtitle"><?php echo esc_html($subtitle); ?></p>
        <?php endif; ?>

        <?php if (!empty($cards)): ?>
            <div class="trust__slider swiper">
                <ul class="swiper-wrapper">
                    <?php foreach ($cards as $card):
                        $icon = isset($card['icon']) ? $card['icon'] : null;
                        $card_title = isset($card['title']) ? $card['title'] : '';
                        $descr = isset($card['descr']) ? $card['descr'] : '';

                        $icon_url = '';
                        $icon_alt = '';

                        if (is_array($icon)) {
                            $icon_url = $icon['url'];
                            $icon_alt = $icon['alt'] ?: $card_title;
                        } elseif (is_numeric($icon)) {
                            $icon_url = wp_get_attachment_image_url($icon, 'full');
                            $icon_alt = get_post_meta($icon, '_wp_attachment_image_alt', true) ?: $card_title;
                        } elseif (is_string($icon)) {
                            $icon_url = $icon;
                            $icon_alt = $card_title;
                        }
                    ?>
                        <li class="trust__card swiper-slide">
                            <?php if ($icon_url): ?>
                                <div class="trust__card-icon">
                                    <img src="<?php echo esc_url($icon_url); ?>"
                                        alt="<?php echo esc_attr($icon_alt); ?>">
                                </div>
                            <?php endif; ?>

                            <?php if ($card_title): ?>
                                <h4 class="trust__card-caption"><?php echo esc_html($card_title); ?></h4>
                            <?php endif; ?>

                            <?php if ($descr): ?>
                                <p class="trust__card-description"><?php echo esc_html($descr); ?></p>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <div class="trust__slider-pagination swiper-pagination"></div>
            </div>
        <?php endif; ?>
    </div>
</<?php echo $wrapper_tag; ?>>