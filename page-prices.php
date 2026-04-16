<?php

/**
 * Template Name: Page Prices
 */
get_header(); ?>
<?php
$phone = get_field('phone', 'option');
$phone_clean = $phone ? preg_replace('/[^\d+]/', '', $phone) : '';

$title = get_field('pricing_title');
$descr = get_field('pricing_subtitle');

$image_main = get_field('pricing_main_image');
$image_left = get_field('pricing_extra_image_1');
$image_right = get_field('pricing_extra_image_2');

$is_collage = !empty($image_left) || !empty($image_right);
?>


<?php require_once(TEMPLATE_PATH . '/components/breadcrumbs.php'); ?>

<section class="heading">
    <div class="heading__container container">
        <div class="heading__offer">
            <h1 class="heading__title title-lg">
                <?php echo $title ?>
            </h1>
            <?php if ($descr): ?>
                <p class="heading__subtitle subtitle">
                    <?php echo $descr ?>
                </p>
            <?php endif; ?>
            <div class="heading__btns">
                <?php if ($phone): ?>
                    <a href="tel:<?php echo $phone_clean; ?>" class="heading__btn btn btn-primary">Срочный вызов</a>
                <?php endif; ?>
                <a href="" class="heading__btn btn btn-outline">Оставить заявку</a>
            </div>
        </div>

        <?php if ($is_collage): ?>
            <div class="heading__images">
                <?php if (!empty($image_left)): ?>
                    <div class="heading__images-block heading__images-left">
                        <img src="<?php echo esc_url($image_left['url']); ?>"
                            alt="<?php echo esc_attr($image_left['alt'] ?: $title); ?>"
                            class="cover-image">
                    </div>
                <?php endif; ?>

                <?php if (!empty($image_main['url'])): ?>
                    <div class="heading__images-block heading__images-center">
                        <img src="<?php echo esc_url($image_main['url']); ?>"
                            alt="<?php echo esc_attr($image_main['alt'] ?: $title); ?>"
                            class="cover-image">
                    </div>
                <?php endif; ?>

                <?php if (!empty($image_right)): ?>
                    <div class="heading__images-block heading__images-right">
                        <img src="<?php echo esc_url($image_right['url']); ?>"
                            alt="<?php echo esc_attr($image_right['alt'] ?: $title); ?>"
                            class="cover-image">
                    </div>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <div class="heading__image">
                <?php if (!empty($image_main['url'])): ?>
                    <img src="<?php echo esc_url($image_main['url']); ?>"
                        alt="<?php echo esc_attr($image_main['alt'] ?: $title); ?>"
                        class="cover-image">
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php require_once(TEMPLATE_PATH . '_price-list.php'); ?>
<?php require_once(TEMPLATE_PATH . '_pricing-formation.php'); ?>
<?php require_once(TEMPLATE_PATH . '_trust.php'); ?>
<?php require_once(TEMPLATE_PATH . '_faq.php'); ?>
<?php require_once(TEMPLATE_PATH . '_cta.php'); ?>

<?php get_footer(); ?>