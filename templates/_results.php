<?php
$results_title = get_field('results_title') ?: 'Что выполнено';
$results_subtitle = get_field('results_subtitle');
$results_list = get_field('results_list');
?>

<?php if ($results_list): ?>
    <section class="work">
        <div class="container">
            <div class="work__hint hint">Состав работ</div>

            <h2 class="work__title title">
                <?php echo wp_kses($results_title, ['span' => ['class' => []]]); ?>
            </h2>
            <?php if ($results_subtitle): ?>
                <p class="work__subtitle subtitle"><?php echo esc_html($results_subtitle); ?></p>
            <?php endif; ?>

            <ul class="work__list">
                <?php foreach ($results_list as $item): ?>
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