<?php

/**
 * Template Name: Page Contacts
 */
get_header(); ?>
<?php require_once(TEMPLATE_PATH . '/components/breadcrumbs.php'); ?>

<section class="contacts">
    <div class="container">
        <div class="contacts__hint hint">Наши контакты</div>
        <h2 class="contacts__title title">Как с нами <span class="color-accent">связаться</span></h2>
        <p class="contacts__subtitle subtitle">Отвечаем на звонки и сообщения ежедневно — без выходных</p>
    </div>
</section>

<?php require_once(TEMPLATE_PATH . '_faq.php'); ?>

<?php get_footer(); ?>