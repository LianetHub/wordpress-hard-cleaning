<?php get_header(); ?>

<?php
$title = get_field('service_title') ?: get_the_title();
$descr = get_field('service_subtitle') ?: get_the_excerpt();

$image_main = get_field('service_main_image') ?: [
    'url' => get_the_post_thumbnail_url(get_the_ID(), 'full'),
    'alt' => get_the_title()
];

$image_left = get_field('service_extra_image_1');
$image_right = get_field('service_extra_image_2');

$is_collage = !empty($image_left) || !empty($image_right);
?>

<?php require_once(TEMPLATE_PATH . '/components/breadcrumbs.php'); ?>

<section class="heading">
    <div class="heading__container container">
        <div class="heading__offer">
            <h1 class="heading__title title-lg">
                <?php echo esc_html($title); ?>
            </h1>
            <?php if ($descr): ?>
                <p class="heading__subtitle subtitle"><?php echo fix_widows_after_prepositions($descr); ?></p>
            <?php endif; ?>
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
<?php require_once(TEMPLATE_PATH . '_work.php'); ?>
<?php require_once(TEMPLATE_PATH . '_price.php'); ?>
<article class="article">
    <div class="container">
        <div class="article__content typography-block">
            <?php the_content() ?>
        </div>
    </div>
</article>

<?php require_once(TEMPLATE_PATH . '_reviews.php'); ?>
<?php require_once(TEMPLATE_PATH . '_faq.php'); ?>
<?php require_once(TEMPLATE_PATH . '_cta.php'); ?>
<?php get_footer(); ?>