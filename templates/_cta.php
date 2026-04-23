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
                <a href="#" class="cta__btn btn btn-white">Отправить фото в мессенджер</a>
                <a href="#" class="cta__btn btn btn-secondary">Заказать СпецУборку</a>
            </div>
        </div>
    </div>
</section>