<?php
$phone = get_field('phone', 'option');
$phone_clean = $phone ? preg_replace('/[^\d+]/', '', $phone) : '';
$email = get_field('email', 'option');
$address = get_field('address', 'option');
$company_name = get_field('company_name', 'option');
$post_index_number = get_field('post_index_number', 'option');
$inn_number = get_field('inn_number', 'option');
$kpp_number = get_field('kpp_number', 'option');
$ogrn_number = get_field('ogrn_number', 'option');
?>

</main>

<footer class="footer">
    <div class="footer__top">
        <div class="footer__top-container container">
            <div class="footer__column">
                <h4 class="footer__caption">Частным лицам</h4>
                <nav class="footer__menu" aria-label="Меню услуг частным лицам в подвале">
                    <?php
                    wp_nav_menu([
                        'theme_location' => 'footer_individuals_menu',
                        'container'      => false,
                        'menu_class'     => 'footer__menu-list',
                        'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                    ]);
                    ?>
                </nav>
            </div>

            <div class="footer__column">
                <h4 class="footer__caption">Компаниям</h4>
                <nav class="footer__menu" aria-label="Меню услуг компаниям в подвале">
                    <?php
                    wp_nav_menu([
                        'theme_location' => 'footer_companies_menu',
                        'container'      => false,
                        'menu_class'     => 'footer__menu-list',
                        'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                    ]);
                    ?>
                </nav>
            </div>

            <div class="footer__column">
                <h4 class="footer__caption">Навигация</h4>
                <nav class="footer__menu" aria-label="Меню навигации в подвале">
                    <?php
                    wp_nav_menu([
                        'theme_location' => 'footer_navigation_menu',
                        'container'      => false,
                        'menu_class'     => 'footer__menu-list',
                        'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                    ]);
                    ?>
                </nav>
            </div>

            <div class="footer__column footer__column--cta">
                <h4 class="footer__caption">Нужна оценка по вашему случаю?</h4>
                <p>Пришлите фото или опишите ситуацию <br>— скажем план работ и стоимость.</p>
                <div class="footer__btns">
                    <a href="#" class="btn btn-primary btn-footer">Отправить фото</a>
                    <a href="#" class="btn btn-outline-white btn-footer">Позвонить</a>
                </div>
            </div>
        </div>
    </div>
    <div class="footer__middle">
        <div class="footer__middle-container container">
            <div class="footer__column">
                <h4 class="footer__caption">Компания</h4>
                <div class="footer__reqs">
                    <p>
                        <?php if ($company_name): ?>
                            <span class="text-uppercase"><?php echo $company_name; ?></span>
                        <?php endif; ?>
                        <br>
                        Клининг в сложных ситуациях <br>
                        в Санкт-Петербурге и Ленинградской области
                    </p>
                    <p>
                        Юридический и фактический адрес:
                        <?php if ($post_index_number): ?>
                            <?php echo $post_index_number; ?>,
                        <?php endif; ?>
                        <?php if ($address): ?>
                            <?php echo nl2br($address); ?>
                        <?php endif; ?>
                    </p>
                    <p>
                        <?php if ($inn_number): ?>
                            ИНН <?php echo $inn_number; ?><br>
                        <?php endif; ?>
                        <?php if ($kpp_number): ?>
                            КПП <?php echo $kpp_number; ?><br>
                        <?php endif; ?>
                        <?php if ($ogrn_number): ?>
                            ОГРН <?php echo $ogrn_number; ?><br>
                        <?php endif; ?>
                    </p>
                </div>
            </div>
            <div class="footer__middle-side">
                <div class="footer__column">
                    <h4 class="footer__caption">Полезная информация</h4>
                    <nav aria-label="Меню информации в подвале">
                        <?php
                        wp_nav_menu([
                            'theme_location' => 'footer_information_menu',
                            'container'      => false,
                            'menu_class'     => 'footer__menu-list',
                            'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                        ]);
                        ?>
                    </nav>
                </div>
                <div class="footer__column">
                    <h4 class="footer__caption">Контакты</h4>
                    <ul class="footer__contacts">
                        <?php if ($phone): ?>
                            <li class="footer__contacts-item icon-phone-fill">
                                <a href="tel:<?php echo $phone_clean; ?>"
                                    class="footer__contacts-link">
                                    <?php echo $phone; ?>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php if ($email): ?>
                            <li class="footer__contacts-item icon-envelope-fill">
                                <a href="mailto:<?php echo antispambot($email); ?>"
                                    class="footer__contacts-link">
                                    <?php echo antispambot($email); ?>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php if ($address): ?>
                            <li class="footer__contacts-item icon-location">
                                <address><?php echo nl2br($address); ?></address>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
                <div class="footer__column">
                    <h4 class="footer__caption">Мы в социальных сетях</h4>
                    <?php if (have_rows('socials', 'option')): ?>
                        <div class="footer__socials socials">
                            <?php while (have_rows('socials', 'option')): the_row();
                                $icon = get_sub_field('icon');
                                $link = get_sub_field('link');

                                if ($link):
                                    $link_url    = $link['url'];
                                    $link_title  = !empty($link['title']) ? $link['title'] : false;
                                    $link_target = $link['target'] ? $link['target'] : '_self';
                            ?>
                                    <a href="<?php echo esc_url($link_url); ?>"
                                        class="socials__item"
                                        target="<?php echo esc_attr($link_target); ?>"
                                        <?php if ($link_title): ?>aria-label="<?php echo esc_attr($link_title); ?>" <?php endif; ?>>

                                        <?php if ($icon): ?>
                                            <img src="<?php echo esc_url($icon['url']); ?>" alt="<?php echo $icon['alt'] ?>">
                                        <?php endif; ?>

                                    </a>
                            <?php endif;
                            endwhile; ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="footer__column">
                    <h4 class="footer__caption">Способы оплаты</h4>
                    <div class="footer__payments">
                        <div class="footer__payments-item">
                            <img src="<?php echo get_template_directory_uri() ?>/assets/img/payments/visa.svg" alt="Логотип Visa">
                        </div>
                        <div class="footer__payments-item">
                            <img src="<?php echo get_template_directory_uri() ?>/assets/img/payments/mastercard.svg" alt="Логотип Mastercard">
                        </div>
                        <div class="footer__payments-item">
                            <img src="<?php echo get_template_directory_uri() ?>/assets/img/payments/cash.svg" alt="Рука с долларом">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer__bottom">
        <div class="footer__bottom-container container">
            <p>Используя формы обратной связи на сайте, вы соглашаетесь <br>с правилами обработки персональных данных.</p>
            <p>Информация на сайте носит исключительно информационный характер и ни при каких <br>условиях не является публичной офертой, определяемой положением Статьи 437 ГК РФ.</p>
        </div>
    </div>
</footer>
<?php require_once(TEMPLATE_PATH . '_modals.php'); ?>
<?php wp_footer(); ?>
</body>

</html>