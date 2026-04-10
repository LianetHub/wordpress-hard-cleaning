<?php get_header(); ?>

<?php require_once(TEMPLATE_PATH . '/components/breadcrumbs.php'); ?>

<section class="heading">
    <div class="heading__container container">
        <div class="heading__offer">
            <h1 class="heading__title title-lg">Все услуги <br> <span class="color-accent">спецуборки</span></h1>
            <p class="heading__subtitle subtitle">Работаем со сложными случаями — после пожара, потопа, смерти и других ЧП. Выбирайте ситуацию — расскажем что входит и сколько стоит.</p>
        </div>
        <div class="heading__image">
            <img src="<?php echo get_template_directory_uri() ?>/assets/img/banner-services.jpg"
                class="cover-image"
                alt="Баннер">
        </div>
    </div>
</section>

<?php require_once(TEMPLATE_PATH . '_catalog.php'); ?>
<?php require_once(TEMPLATE_PATH . '_trust.php'); ?>
<?php require_once(TEMPLATE_PATH . '_faq.php'); ?>
<?php require_once(TEMPLATE_PATH . '_cta.php'); ?>

<?php get_footer(); ?>