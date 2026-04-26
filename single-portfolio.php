<?php get_header(); ?>

<?php
$phone = get_field('phone', 'option');
$phone_clean = $phone ? preg_replace('/[^\d+]/', '', $phone) : '';

$is_slider = get_field('case_display_mode');
$single_img = get_field('case_single_img');
$before = get_field('case_before_img');
$after = get_field('case_after_img');

$service = get_field('case_service_link');
$area = get_field('case_area');
$duration = get_field('case_duration');
$staff = get_field('case_staff');

$cards = [];
if ($area) {
    $cards[] = [
        'title' => 'Площадь',
        'descr' => $area,
        'icon'  => get_template_directory_uri() . '/assets/img/icons/size.svg'
    ];
}
if ($duration) {
    $cards[] = [
        'title' => 'Срок',
        'descr' => $duration,
        'icon'  => get_template_directory_uri() . '/assets/img/icons/clock.svg'
    ];
}
if ($staff) {
    $cards[] = [
        'title' => 'Персонал',
        'descr' => $staff,
        'icon'  => get_template_directory_uri() . '/assets/img/icons/team.svg'
    ];
}

$hint = get_field('case_trust_hint') ?: 'Детали проекта';
$title = get_field('case_trust_title') ?: 'Характеристики';
$bg_class = get_field('case_trust_bg') ?: 'bg-light';
$wrapper_tag = $title ? 'section' : 'div';
?>

<?php require_once(TEMPLATE_PATH . '/components/breadcrumbs.php'); ?>

<section class="heading">
    <div class="heading__container container">
        <div class="heading__offer">
            <h1 class="heading__title title-lg">
                <?php the_title(); ?>
            </h1>
            <div class="heading__subtitle subtitle">
                <?php the_excerpt(); ?>
            </div>
            <div class="heading__btns">
                <?php if ($phone): ?>
                    <a href="tel:<?php echo $phone_clean; ?>" class="heading__btn btn btn-secondary">Срочный вызов</a>
                <?php endif; ?>
                <a href="" class="heading__btn btn btn-outline">Оставить заявку</a>
            </div>
        </div>
        <?php if ($is_slider && $before && $after): ?>
            <div class="heading__images">
                <div class="heading__images-block heading__images-block--before">
                    <img src="<?php echo esc_url($before['url']); ?>" class="cover-image" alt="До">
                    <span class="before-slider__label before-slider__label--before">До</span>
                </div>
                <div class="heading__images-block heading__images-block--after">
                    <img src="<?php echo esc_url($after['url']); ?>" class="cover-image" alt="После">
                    <span class="before-slider__label before-slider__label--after">После</span>
                </div>
            </div>
        <?php elseif ($single_img): ?>
            <div class="heading__image">
                <img src="<?php echo esc_url($single_img['url']); ?>"
                    class="cover-image"
                    alt="<?php echo esc_attr($single_img['alt']); ?>">
            </div>
        <?php endif; ?>
    </div>
</section>


<?php require_once(TEMPLATE_PATH . '_results.php'); ?>
<<?php echo $wrapper_tag; ?> class="trust trust--small <?php echo esc_attr($bg_class); ?> case-study-details">
    <div class="container">

        <?php if ($hint): ?>
            <div class="trust__hint hint"><?php echo esc_html($hint); ?></div>
        <?php endif; ?>

        <?php if ($title): ?>
            <h2 class="trust__title title"><?php echo $title; ?></h2>
        <?php endif; ?>

        <?php if (!empty($cards)): ?>
            <div class="trust__slider swiper">
                <ul class="swiper-wrapper">
                    <?php foreach ($cards as $card):
                        $icon = $card['icon'];
                        $card_title = $card['title'];
                        $descr = $card['descr'];

                        $icon_url = '';
                        if (is_array($icon)) {
                            $icon_url = $icon['url'];
                        } else {
                            $icon_url = $icon;
                        }
                    ?>
                        <li class="trust__card swiper-slide">
                            <?php if ($icon_url): ?>
                                <div class="trust__card-icon">
                                    <img
                                        width="24"
                                        height="24"
                                        src="<?php echo esc_url($icon_url); ?>"
                                        alt="<?php echo esc_attr($card_title); ?>">
                                </div>
                            <?php endif; ?>

                            <?php if ($card_title): ?>
                                <h4 class="trust__card-caption"><?php echo esc_html($card_title); ?></h4>
                            <?php endif; ?>

                            <?php if ($descr): ?>
                                <p class="trust__card-description"><strong><?php echo esc_html($descr); ?></strong></p>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <div class="trust__slider-pagination swiper-pagination"></div>
            </div>
        <?php endif; ?>
    </div>
</<?php echo $wrapper_tag; ?>>

<?php if (!empty(get_the_content())): ?>
    <article class="article">
        <div class="container">
            <div class="article__content typography-block">
                <?php the_content(); ?>
            </div>
        </div>
    </article>
<?php endif; ?>

<?php require_once(TEMPLATE_PATH . '_cta.php'); ?>

<?php get_footer(); ?>