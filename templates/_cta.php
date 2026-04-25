<?php
$phone = get_field('phone', 'option');
$phone_clean = $phone ? preg_replace('/[^\d+]/', '', $phone) : '';
?>
<section class="cta">
    <div class="cta__container container">
        <div class="cta__content">
            <?php if (get_field('cta_title', 'option')): ?>
                <h2 class="cta__title title"><?php echo get_field('cta_title', 'option'); ?></h2>
            <?php endif; ?>

            <?php if (get_field('cta_descr', 'option')): ?>
                <p class="cta__description"><?php echo get_field('cta_descr', 'option'); ?></p>
            <?php endif; ?>

            <div class="cta__btns">
                <a href="#callback" data-fancybox class="cta__btn btn btn-white">Заказать СпецУборку</a>
                <?php if ($phone): ?>
                    <a href="tel:<?php echo $phone_clean; ?>" class="cta__btn btn btn-secondary">Срочный вызов</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>