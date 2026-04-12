<?php
$phone = get_field('phone', 'option');
$phone_clean = $phone ? preg_replace('/[^\d+]/', '', $phone) : '';
$email = get_field('email', 'option');
$address = get_field('address', 'option');
$company_name = get_field('company_name', 'option');
$inn = get_field('inn_number', 'option');
$kpp = get_field('kpp_number', 'option');
$ogrn = get_field('ogrn_number', 'option');
?>
<section class="requisites">
    <div class="container">
        <div class="requisites__hint hint">Юридическая информация</div>
        <h2 class="requisites__title title">Реквизиты <span class="color-accent">компании</span></h2>
        <ul class="requisites__list">
            <?php if ($company_name): ?>
                <li class="requisites__item">
                    <div class="requisites__item-caption">организация</div>
                    <div class="requisites__item-value"><?php echo esc_html($company_name); ?></div>
                    <div class="requisites__item-subtitle">Официальное наименование</div>
                </li>
            <?php endif; ?>

            <?php if ($phone): ?>
                <li class="requisites__item">
                    <div class="requisites__item-caption">Телефон</div>
                    <a href="tel:<?php echo esc_attr($phone_clean); ?>" class="requisites__item-value">
                        <?php echo esc_html($phone); ?>
                    </a>
                    <div class="requisites__item-subtitle">Основной номер для связи</div>
                </li>
            <?php endif; ?>

            <?php if ($email): ?>
                <li class="requisites__item">
                    <div class="requisites__item-caption">Email</div>
                    <a href="mailto:<?php echo esc_attr($email); ?>" class="requisites__item-value">
                        <?php echo esc_html($email); ?>
                    </a>
                    <div class="requisites__item-subtitle">Для официальных запросов</div>
                </li>
            <?php endif; ?>

            <?php if ($address): ?>
                <li class="requisites__item">
                    <div class="requisites__item-caption">Юридический адрес</div>
                    <address class="requisites__item-value"><?php echo esc_html($address); ?></address>
                    <div class="requisites__item-subtitle">Место нахождения организации</div>
                </li>
            <?php endif; ?>

            <?php if ($inn || $kpp || $ogrn): ?>
                <li class="requisites__item">
                    <div class="requisites__item-caption">ИНН / КПП / ОГРН</div>
                    <div class="requisites__item-value">
                        <?php if ($inn) echo esc_html($inn) . '<br>'; ?>
                        <?php if ($kpp) echo esc_html($kpp) . '<br>'; ?>
                        <?php if ($ogrn) echo esc_html($ogrn); ?>
                    </div>
                    <div class="requisites__item-subtitle">Основные государственные регистраторы</div>
                </li>
            <?php endif; ?>

            <li class="requisites__item">
                <div class="requisites__item-caption">Способы оплаты</div>
                <div class="requisites__item-value">Наличные · Карта · Безнал</div>
                <div class="requisites__item-subtitle">Работаем с НДС для юр. лиц</div>
            </li>
        </ul>
    </div>
</section>