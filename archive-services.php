<?php get_header(); ?>

<?php
$img_left   = get_field('services_banner_left', 'option');
$img_center = get_field('services_banner_center', 'option');
$img_right  = get_field('services_banner_right', 'option');

$default_url = get_template_directory_uri() . '/assets/img/banner-services.jpg';

$has_custom_images = ($img_left || $img_center || $img_right);
?>

<?php require_once(TEMPLATE_PATH . '/components/breadcrumbs.php'); ?>

<section class="heading">
    <div class="heading__container container">
        <div class="heading__offer">
            <h1 class="heading__title title-lg">Все услуги <br> <span class="color-accent">спецуборки</span></h1>
            <p class="heading__subtitle subtitle">Работаем со сложными случаями — после пожара, потопа, смерти и других ЧП. Выбирайте ситуацию — расскажем что входит и сколько стоит.</p>
        </div>

        <?php if ($has_custom_images): ?>
            <div class="heading__images">
                <div class="heading__images-block heading__images-left">
                    <img src="<?php echo $img_left ? esc_url($img_left['url']) : $default_url; ?>"
                        class="cover-image"
                        alt="<?php echo esc_attr($img_left['alt'] ?? 'Баннер'); ?>">
                </div>
                <div class="heading__images-block heading__images-center">
                    <img src="<?php echo $img_center ? esc_url($img_center['url']) : $default_url; ?>"
                        class="cover-image"
                        alt="<?php echo esc_attr($img_center['alt'] ?? 'Баннер'); ?>">
                </div>
                <div class="heading__images-block heading__images-right">
                    <img src="<?php echo $img_right ? esc_url($img_right['url']) : $default_url; ?>"
                        class="cover-image"
                        alt="<?php echo esc_attr($img_right['alt'] ?? 'Баннер'); ?>">
                </div>
            </div>
        <?php else: ?>
            <div class="heading__image">
                <img src="<?php echo esc_url($default_url); ?>"
                    class="cover-image"
                    alt="Спецуборка">
            </div>
        <?php endif; ?>

    </div>
</section>

<?php require_once(TEMPLATE_PATH . '_catalog.php'); ?>
<?php require_once(TEMPLATE_PATH . '_trust.php'); ?>
<?php require_once(TEMPLATE_PATH . '_faq.php'); ?>
<?php require_once(TEMPLATE_PATH . '_cta.php'); ?>

<?php get_footer(); ?>
<?php require_once(TEMPLATE_PATH . '_catalog.php'); ?>
<?php require_once(TEMPLATE_PATH . '_trust.php'); ?>
<?php require_once(TEMPLATE_PATH . '_faq.php'); ?>
<?php require_once(TEMPLATE_PATH . '_cta.php'); ?>

<?php get_footer(); ?>