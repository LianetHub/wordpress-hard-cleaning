<section class="cta">
    <div class="cta__container container">
        <div class="cta__content">
            <?php if (get_field('cta_title')): ?>
                <h2 class="cta__title"><?php echo get_field('cta_title'); ?></h2>
            <?php endif; ?>

            <?php if (get_field('cta_descr')): ?>
                <p class="cta__description"><?php echo get_field('cta_descr'); ?></p>
            <?php endif; ?>

            <div class="cta__btns">
                <a href="#" class="cta__btn btn btn-white-solid">Отправить фото в мессенджер</a>
                <a href="#" class="cta__btn btn btn-outline-white">Заказать СпецУборку</a>
            </div>
        </div>
    </div>
</section>