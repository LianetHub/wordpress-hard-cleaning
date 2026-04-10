<?php
$work_title = get_field('work_title') ?: 'Что входит <span class="color-accent">в уборку</span>';
$work_subtitle = get_field('work_subtitle');
$work_list = get_field('work_list');
?>

<?php if ($work_list): ?>
    <section class="work">
        <div class="container">
            <div class="work__hint hint">Состав работ</div>

            <h2 class="work__title title">
                <?php echo highlight_accent_words(wp_kses($work_title, array('span' => array('class' => array())))); ?>
            </h2>

            <?php if ($work_subtitle): ?>
                <p class="work__subtitle subtitle"><?php echo esc_html($work_subtitle); ?></p>
            <?php endif; ?>

            <ul class="work__list">
                <?php foreach ($work_list as $item): ?>
                    <?php if (!empty($item['text'])): ?>
                        <li class="work__item icon-check-circle">
                            <?php echo esc_html($item['text']); ?>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </div>
    </section>
<?php endif; ?>