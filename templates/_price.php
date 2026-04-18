<?php
$prices_group = get_field('all_services_prices_list', 'option');
$service_data = $prices_group['service_data_' . get_the_ID()] ?? null;

if ($service_data && !empty($service_data['additional_services'])) :
    $price_table = $service_data['additional_services'];
?>
    <section class="price">
        <div class="container">
            <div class="price__hint hint">Прайс-лист</div>
            <h2 class="price__title title">Цены на услуги</h2>

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
                                    <?php echo nl2br(esc_html($row['name'])); ?>
                                </td>
                                <td data-label="Стоимость" class="price__value">
                                    <?php echo esc_html($row['price']); ?>
                                </td>
                                <td data-label="Комментарий" class="price__comment">
                                    <?php echo nl2br(esc_html($row['comment'])); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
<?php endif; ?>