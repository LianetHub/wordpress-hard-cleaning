<?php
$service = get_field('case_service_link');
$before = get_field('case_before_img');
$after = get_field('case_after_img');
$case_area = get_field('case_area');
$case_duration = get_field('case_duration');
$case_staff = get_field('case_staff');
$case_title = get_the_title();
$case_link = get_permalink();

$case_excerpt = has_excerpt() ? get_the_excerpt() : get_the_content();
?>

<div class="case-card">
    <?php if ($before && $after): ?>
        <div class="case-card__slider before-slider">
            <div class="before-slider__layer before-slider__layer--after">
                <img class="before-slider__image"
                    src="<?php echo esc_url($after['url']); ?>"
                    alt="<?php echo esc_attr($after['alt'] ?: 'После'); ?>"
                    loading="lazy"
                    decoding="async">
            </div>

            <div class="before-slider__layer before-slider__layer--before">
                <img class="before-slider__image"
                    src="<?php echo esc_url($before['url']); ?>"
                    alt="<?php echo esc_attr($before['alt'] ?: 'До'); ?>"
                    loading="lazy"
                    decoding="async">
            </div>

            <span class="before-slider__label before-slider__label--before">До</span>
            <span class="before-slider__label before-slider__label--after">После</span>

            <div class="before-slider__divider icon-arrows"></div>
        </div>
    <?php endif; ?>

    <div class="case-card__details">
        <?php if ($service) : ?>
            <a href="<?php echo get_permalink($service->ID); ?>" class="case-card__category">
                <?php echo get_the_title($service->ID); ?>
            </a>
        <?php endif; ?>

        <ul class="case-card__meta">
            <?php if ($case_area) : ?>
                <li class="case-card__meta-item icon-size"><?php echo esc_html($case_area); ?></li>
            <?php endif; ?>

            <?php if ($case_duration) : ?>
                <li class="case-card__meta-item icon-clock"><?php echo esc_html($case_duration); ?></li>
            <?php endif; ?>

            <?php if ($case_staff) : ?>
                <li class="case-card__meta-item icon-team"><?php echo esc_html($case_staff); ?></li>
            <?php endif; ?>
        </ul>

        <h3 class="case-card__title">
            <a href="<?php echo esc_url($case_link); ?>">
                <?php echo esc_html($case_title); ?>
            </a>
        </h3>

        <?php if ($case_excerpt) : ?>
            <p class="case-card__desc">
                <?php echo wp_trim_words($case_excerpt, 20); ?>
            </p>
        <?php endif; ?>

        <a href="<?php echo esc_url($case_link); ?>"
            class="case-card__btn btn btn-primary">Подробнее</a>
    </div>
</div>