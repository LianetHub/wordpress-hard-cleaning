<?php

/**
 * Template Name: Page Contacts
 */
get_header(); ?>
<?php require_once(TEMPLATE_PATH . '/components/breadcrumbs.php'); ?>
<?php
$phone = get_field('phone', 'option');
$phone_clean = $phone ? preg_replace('/[^\d+]/', '', $phone) : '';
$email = get_field('email', 'option');
$address = get_field('address', 'option');
$worktime = get_field('worktime', 'option');
?>
<section class="contacts">
    <div class="container">
        <div class="contacts__hint hint">Наши контакты</div>
        <h2 class="contacts__title title">Как с нами <span class="color-accent">связаться</span></h2>
        <p class="contacts__subtitle subtitle">Отвечаем на звонки и сообщения ежедневно — без выходных</p>
        <ul class="contacts__list">
            <?php if ($phone): ?>
                <li class="trust__card">
                    <div class="trust__card-icon">
                        <img src="<?php echo get_template_directory_uri() ?>/assets/img/icons/phone.svg"
                            alt="Иконка">
                    </div>
                    <h4 class="trust__card-caption trust__card-caption--large">Телефон</h4>
                    <a href="tel:<?php echo $phone_clean ?>"
                        class="trust__card-description">
                        <?php echo $phone ?>
                    </a>
                </li>
            <?php endif; ?>
            <?php if ($email): ?>
                <li class="trust__card">
                    <div class="trust__card-icon">
                        <img src="<?php echo get_template_directory_uri() ?>/assets/img/icons/envelope.svg"
                            alt="Иконка">
                    </div>
                    <h4 class="trust__card-caption trust__card-caption--large">Email</h4>
                    <a href="mailto:<?php echo $email ?>"
                        class="trust__card-description">
                        <?php echo $email ?>
                    </a>
                </li>
            <?php endif; ?>
            <?php if ($address): ?>
                <li class="trust__card">
                    <div class="trust__card-icon">
                        <img src="<?php echo get_template_directory_uri() ?>/assets/img/icons/location.svg"
                            alt="Иконка">
                    </div>
                    <h4 class="trust__card-caption trust__card-caption--large">Адрес офиса</h4>
                    <address
                        class="trust__card-description">
                        <?php echo nl2br($address) ?>
                    </address>
                </li>
            <?php endif; ?>
        </ul>
        <div class="contacts__footer">
            <div class="contacts__socials">
                <div class="contacts__socials-title">Написать в мессенджер</div>

                <?php if (have_rows('socials', 'option')): ?>
                    <div class="contacts__socials-btns">
                        <?php while (have_rows('socials', 'option')): the_row();
                            $link = get_sub_field('link');

                            if ($link):
                                $link_url    = $link['url'];
                                $link_title  = !empty($link['title']) ? $link['title'] : '';
                                $link_target = $link['target'] ?: '_self';

                                $icon_class = 'icon-default';
                                $title_lower = mb_strtolower($link_title);

                                if (strpos($title_lower, 'tele') !== false || strpos($title_lower, 'телег') !== false) {
                                    $icon_class = 'icon-telegram';
                                } elseif (strpos($title_lower, 'vk') !== false || strpos($title_lower, 'вконтак') !== false) {
                                    $icon_class = 'icon-vk';
                                } elseif (strpos($title_lower, 'max') !== false || strpos($title_lower, 'макс') !== false) {
                                    $icon_class = 'icon-max';
                                } elseif (strpos($title_lower, 'whatsapp') !== false || strpos($title_lower, 'ватсап') !== false) {
                                    $icon_class = 'icon-whatsapp';
                                }
                        ?>
                                <a href="<?php echo esc_url($link_url); ?>"
                                    class="contacts__socials-btn btn <?php echo esc_attr($icon_class); ?>"
                                    target="<?php echo esc_attr($link_target); ?>">
                                    <?php echo esc_html($link_title); ?>
                                </a>
                            <?php endif; ?>
                        <?php endwhile; ?>
                    </div>
                <?php endif; ?>
            </div>
            <?php if ($worktime): ?>
                <div class="contacts__worktime info-highlight-box">
                    <div class="contacts__worktime-title">Режим работы</div>
                    <p class="contacts__worktime-text">
                        <?php echo $worktime ?>
                    </p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<section class="place">
    <div class="container">
        <div class="place__hint hint">Как нас найти</div>
        <h2 class="place__title title">Наш <span class="color-accent">офис</span></h2>
        <?php if ($address): ?>
            <address class="place__address subtitle">
                <?php echo nl2br($address) ?>
            </address>
        <?php endif; ?>
        <div class="place__map">
            <?php require_once(TEMPLATE_PATH . 'components/map.php'); ?>
        </div>
    </div>
</section>
<?php require_once(TEMPLATE_PATH . '_requisites.php'); ?>
<?php require_once(TEMPLATE_PATH . '_faq.php'); ?>

<?php get_footer(); ?>