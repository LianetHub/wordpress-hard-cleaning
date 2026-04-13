<?php
$price_title = get_field('price_title') ?: 'Цены на услуги';
$price_table = get_field('price_table');
?>

<?php if ($price_table): ?>
    <section class="price">
        <div class="container">
            <div class="price__hint hint">Прайс-лист</div>
            <h2 class="price__title title">
                <?php echo wp_kses($price_title, ['span' => ['class' => []]]); ?>
            </h2>

            <div class="price__table-wrapper custom-table">
                <table>
                    <thead>
                        <tr>
                            <th>Наименование</th>
                            <th>Стоимость</th>
                            <th>Комментарий</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($price_table as $row): ?>
                            <tr>
                                <td data-label="Наименование">
                                    <?php echo esc_html($row['price_name']); ?>
                                </td>
                                <td data-label="Стоимость" class="price__value">
                                    <?php echo esc_html($row['price_value']); ?>
                                </td>
                                <td data-label="Комментарий" class="price__comment">
                                    <?php echo esc_html($row['price_comment']); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
<?php endif; ?>