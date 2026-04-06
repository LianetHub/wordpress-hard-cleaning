<?php
$phone = get_field('phone', 'option');
$phone_clean = $phone ? preg_replace('/[^\d+]/', '', $phone) : '';
$email = get_field('email', 'option');
$address = get_field('address', 'option');
?>

<div class="top-bar">
    <div class="container top-bar-content">
        <div class="tb-left">
            <?php if ($address): ?>
                <span class="tb-address"><?php echo $address; ?></span>
            <?php endif; ?>

            <?php if ($address && $email): ?>
                <?php echo cleaning_inline_svg('tb-address-sep', array('class' => 'tb-address-sep', 'aria-hidden' => 'true')); ?>
            <?php endif; ?>

            <?php if ($email): ?>
                <a class="tb-email" href="mailto:<?php echo antispambot($email); ?>">
                    <?php echo antispambot($email); ?>
                </a>
            <?php endif; ?>
        </div>
        <div class="tb-right">
            <div class="tb-socials">
                <a href="#" class="tb-icon-circle" aria-label="Telegram">
                    <?php echo cleaning_inline_svg('tb-social-telegram', array('aria-hidden' => 'true')); ?>
                </a>
                <a href="#" class="tb-icon-circle" aria-label="Messenger">
                    <?php echo cleaning_inline_svg('tb-social-max', array('aria-hidden' => 'true')); ?>
                </a>
            </div>

            <?php if ($phone): ?>
                <a href="tel:<?php echo $phone_clean; ?>" class="tb-phone"><?php echo $phone; ?></a>
            <?php endif; ?>
        </div>
    </div>
</div>

<header class="main-header">
    <div class="nav-drawer-backdrop" id="nav-drawer-backdrop" aria-hidden="true"></div>
    <div class="container header-content">
        <div class="logo">
            <a href="<?php echo esc_url(home_url('/')); ?>">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/logo.svg" alt="<?php bloginfo('name'); ?>">
            </a>
        </div>

        <nav class="main-nav" id="site-navigation" aria-label="Основное меню">
            <button type="button" class="nav-drawer-close" aria-label="Закрыть меню">
                <span aria-hidden="true">×</span>
            </button>
            <ul class="nav-list">
                <li><a href="<?php echo esc_url(home_url('/')); ?>">Главная</a></li>
                <li>
                    <a href="#about">
                        О нас
                        <?php echo cleaning_inline_svg('nav-chevron-down', array('aria-hidden' => 'true')); ?>
                    </a>
                </li>
                <li>
                    <a href="#private">
                        Частным лицам
                        <?php echo cleaning_inline_svg('nav-chevron-down', array('aria-hidden' => 'true')); ?>
                    </a>
                </li>
                <li>
                    <a href="#business">
                        Компаниям
                        <?php echo cleaning_inline_svg('nav-chevron-down', array('aria-hidden' => 'true')); ?>
                    </a>
                </li>
                <li><a href="#contacts">Контакты</a></li>
            </ul>
        </nav>

        <div class="header-actions">
            <a href="#contacts" class="btn btn-primary header-urgent-btn">
                <span>Срочный вызов</span>
            </a>
            <a href="#contacts" class="btn btn-primary header-help-btn">
                <span class="header-help-btn__desktop">Задать вопрос</span>
                <span class="header-help-btn__mobile">Задать вопрос</span>
            </a>
            <button type="button" class="header-burger" aria-expanded="false" aria-controls="site-navigation" aria-label="Открыть меню">
                <?php echo cleaning_inline_svg('header-burger', array('aria-hidden' => 'true')); ?>
            </button>
        </div>
    </div>
</header>