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
$company_name = get_field('company_name', 'option');
$post_index_number = get_field('post_index_number', 'option');
$inn_number = get_field('inn_number', 'option');
$kpp_number = get_field('kpp_number', 'option');
$ogrn_number = get_field('ogrn_number', 'option');
$worktime = get_field('worktime', 'option');
?>
<section class="contacts">
    <div class="container">
        <div class="contacts__hint hint">Наши контакты</div>
        <h2 class="contacts__title title">Как с нами <span class="color-accent">связаться</span></h2>
        <p class="contacts__subtitle subtitle">Отвечаем на звонки и сообщения ежедневно — без выходных</p>
        <div class="contacts__footer">
            <div class="contacts__socials">
                <div class="contacts__socials-title">Написать в мессенджер</div>
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