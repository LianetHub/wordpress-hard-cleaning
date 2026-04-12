<?php
$logo = get_field('logo', 'option');
$logo_mobile = get_field('logo_mobile', 'option');
$phone = get_field('phone', 'option');
$phone_clean = $phone ? preg_replace('/[^\d+]/', '', $phone) : '';
$email = get_field('email', 'option');
$address = get_field('address', 'option');

?>
<header class="header">
    <div class="header__top">
        <div class="header__top-container container">
            <button
                type="button"
                aria-label="Открыть меню"
                class="header__menu-toggler icon-menu">
                <span></span><span></span><span></span>
            </button>
            <a href="<?php echo esc_url(home_url('/')); ?>" class="header__logo">
                <img
                    src="<?php echo esc_url($logo_mobile['url']); ?>"
                    alt="<?php echo esc_attr($logo_mobile['alt']) ?: 'Логотип '; ?>">
            </a>
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
                    class="header__phone icon-phone">
                    <span class="header__phone-desktop"><?php echo $phone; ?></span>
                    <span class="header__phone-mobile">Вызвать бригаду</span>
                </a>
            <?php endif; ?>
        </div>
    </div>
    <div class="header__menu menu" id="site-navigation">
        <div class="menu__container container">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="menu__logo">
                <img
                    src="<?php echo esc_url($logo['url']); ?>"
                    alt="<?php echo esc_attr($logo['alt']) ?: 'Логотип '; ?>">
            </a>
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
            <div class="menu__actions">
                <?php if ($phone): ?>
                    <a href="tel:<?php echo $phone_clean; ?>" class="menu__actions-btn btn btn-sm btn-primary">Срочный вызов</a>
                <?php endif; ?>
                <a href="#contacts" class="menu__actions-btn btn btn-sm btn-primary">
                    Задать вопрос
                </a>
            </div>
        </div>
    </div>
</header>