<?php
$logo = get_field('logo', 'option');
$phone = get_field('phone', 'option');
$phone_clean = $phone ? preg_replace('/[^\d+]/', '', $phone) : '';
$email = get_field('email', 'option');
$address = get_field('address', 'option');

?>
<header class="header">
    <div class="header__top">
        <div class="header__top-container container">
            <?php if ($address): ?>
                <address class="header__address"><?php echo $address; ?></address>
            <?php endif; ?>
            <?php if ($email): ?>
                <a class="header__email"
                    href="mailto:<?php echo antispambot($email); ?>"
                    target="_blank">
                    <?php echo antispambot($email); ?>
                </a>
            <?php endif; ?>
            <?php if (have_rows('socials', 'option')): ?>
                <div class="header__socials socials">
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

            <?php if ($phone): ?>
                <a href="tel:<?php echo $phone_clean; ?>"
                    class="header__phone"><?php echo $phone; ?></a>
            <?php endif; ?>
        </div>
    </div>
    <div class="header__content">
        <div class="header__content-container container">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="header__logo">
                <img
                    src="<?php echo esc_url($logo['url']); ?>"
                    alt="<?php echo esc_attr($logo['alt']) ?: 'Логотип '; ?>">
            </a>
            <div id="site-navigation" class="header__menu menu">
                <div class="menu__logo">
                    <img
                        src="<?php echo esc_url($logo['url']); ?>"
                        alt="<?php echo esc_attr($logo['alt']) ?: 'Логотип '; ?>">
                </div>
                <nav class="menu__content" aria-label="Меню в шапке">
                    <?php
                    wp_nav_menu([
                        'theme_location' => 'header_menu',
                        'container'      => false,
                        'menu_class'     => 'menu__list',
                        'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                    ]);
                    ?>
                </nav>
                <?php if (have_rows('socials', 'option')): ?>
                    <div class="menu__socials socials">
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
            <div class="header__actions">
                <a href="#contacts" class="header__actions-btn btn btn-primary header-urgent-btn">
                    Срочный вызов
                </a>
                <a href="#contacts" class="header__actions-btn btn btn-primary header-help-btn">
                    Задать вопрос
                </a>

                <button type="button"
                    class="header__menu-toggler"
                    aria-controls="site-navigation"
                    aria-label="Открыть меню">
                    <span></span><span></span><span></span>
                </button>
            </div>
        </div>
    </div>
</header>

<!-- <header class="main-header">
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
                <?php if (have_rows('socials', 'option')): ?>
                    <div class="tb-socials">
                        <?php while (have_rows('socials', 'option')): the_row();
                            $icon = get_sub_field('icon');
                            $link = get_sub_field('link');

                            if ($link):
                                $link_url    = $link['url'];
                                $link_title  = !empty($link['title']) ? $link['title'] : false;
                                $link_target = $link['target'] ? $link['target'] : '_self';
                        ?>
                                <a href="<?php echo esc_url($link_url); ?>"
                                    class="tb-icon-circle"
                                    target="<?php echo esc_attr($link_target); ?>"
                                    <?php if ($link_title): ?>aria-label="<?php echo esc_attr($link_title); ?>" <?php endif; ?>>

                                    <?php if ($icon): ?>
                                        <img src="<?php echo esc_url($icon['url']); ?>" alt="">
                                    <?php endif; ?>

                                </a>
                        <?php endif;
                        endwhile; ?>
                    </div>
                <?php endif; ?>

                <?php if ($phone): ?>
                    <a href="tel:<?php echo $phone_clean; ?>" class="tb-phone"><?php echo $phone; ?></a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="main-header__content">
        <div class="nav-drawer-backdrop"
            id="nav-drawer-backdrop"
            aria-hidden="true"></div>
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
    </div>
</header> -->