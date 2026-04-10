<?php

/**
 * Theme functions and definitions
 */

// =========================================================================
// 1. ПОДКЛЮЧЕНИЕ МОДУЛЕЙ
// =========================================================================

$includes = [
    'includes/admin-custom.php',
    'includes/acf-custom.php',
    'includes/custom-posts.php',
];

foreach ($includes as $file) {
    if (!$filepath = locate_template($file)) {
        trigger_error(sprintf('Ошибка: файл %s не найден', $file), E_USER_ERROR);
    }
    require_once $filepath;
}

define('TEMPLATE_PATH', get_template_directory() . '/templates/');


// =========================================================================
// 2. НАСТРОЙКИ ТЕМЫ
// =========================================================================

function cleaning_theme_setup()
{
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');

    add_theme_support('custom-logo', [
        'height'      => 81,
        'width'       => 168,
        'flex-width'  => true,
        'flex-height' => true,
    ]);

    register_nav_menus([
        'header_menu' => 'Меню в шапке',
    ]);
}
add_action('after_setup_theme', 'cleaning_theme_setup');


// =========================================================================
// 3. ПОДКЛЮЧЕНИЕ СКРИПТОВ И СТИЛЕЙ
// =========================================================================

add_action('wp_enqueue_scripts', function () {
    $theme_dir = get_template_directory();
    $theme_uri = get_template_directory_uri();

    // Styles
    wp_enqueue_style('swiper', $theme_uri . '/assets/css/libs/swiper-bundle.min.css');
    wp_enqueue_style('fancybox', $theme_uri . '/assets/css/libs/fancybox.css');
    wp_enqueue_style('reset', $theme_uri . '/assets/css/reset.min.css');

    $main_css_ver = filemtime($theme_dir . '/assets/css/style.min.css');
    wp_enqueue_style('main-style', $theme_uri . '/assets/css/style.min.css', array(), $main_css_ver);

    // Scripts
    wp_deregister_script('jquery');
    wp_enqueue_script('jquery', $theme_uri . '/assets/js/libs/jquery-4.0.0.min.js', array(), '4.0.0', true);
    wp_enqueue_script('yandex-maps', 'https://api-maps.yandex.ru/2.1/?apikey=496cd84c-0a7a-4b7e-a9d5-bd9261e5f0a6&lang=ru_RU', array(), null, true);
    wp_enqueue_script('swiper-js', $theme_uri . '/assets/js/libs/swiper-bundle.min.js', array(), null, true);
    wp_enqueue_script('fancybox-js', $theme_uri . '/assets/js/libs/fancybox.umd.js', array(), null, true);

    $app_js_ver = filemtime($theme_dir . '/assets/js/app.min.js');
    wp_enqueue_script('app-js', $theme_uri . '/assets/js/app.min.js', array('jquery', 'yandex-maps', 'swiper-js', 'fancybox-js'), $app_js_ver, true);
});


// =========================================================================
// 4. ОПТИМИЗАЦИЯ ЗАГРУЗКИ (ASYNC / DEFER)
// =========================================================================

add_filter('style_loader_tag', function ($tag, $handle) {
    if (in_array($handle, ['swiper', 'fancybox'])) {
        return str_replace(" media='all'", " media='print' onload=\"this.media='all'; this.onload=null;\"", $tag);
    }
    return $tag;
}, 10, 2);

add_filter('script_loader_tag', function ($tag, $handle) {
    $defer = ['swiper-js', 'fancybox-js', 'app-js'];
    if (in_array($handle, $defer)) return str_replace(' src', ' defer src', $tag);
    if ($handle === 'yandex-maps') return str_replace(' src', ' async defer src', $tag);
    return $tag;
}, 10, 2);


// =========================================================================
// 5. БЕЗОПАСНОСТЬ И ОЧИСТКА
// =========================================================================

add_action('init', function () {
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
    remove_action('wp_head', 'rel_canonical');
    remove_action('wp_head', 'feed_links_extra', 3);
    remove_action('wp_head', 'feed_links', 2);
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wlwmanifest_link');
    add_filter('xmlrpc_enabled', '__return_false');
});

add_filter('upload_mimes', function ($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
});


// =========================================================================
// 6. ТИПОГРАФИКА (НЕРАЗРЫВНЫЕ ПРОБЕЛЫ)
// =========================================================================

function fix_widows_after_prepositions($text)
{
    if (empty($text) || !is_string($text)) return $text;

    $prepositions = [
        'в',
        'и',
        'или',
        'к',
        'с',
        'на',
        'у',
        'о',
        'от',
        'для',
        'за',
        'по',
        'без',
        'из',
        'над',
        'под',
        'при',
        'про',
        'через',
        'об',
        'со',
        'ко'
    ];

    foreach ($prepositions as $prep) {
        $pattern = '/(?<=\s|^)(' . preg_quote($prep, '/') . ')\s+/iu';
        $text = preg_replace($pattern, '$1&nbsp;', $text);
    }

    return $text;
}

foreach (['the_content', 'the_title', 'the_excerpt', 'widget_text_content'] as $hook) {
    add_filter($hook, 'fix_widows_after_prepositions', 99);
}

add_filter('acf/format_value', function ($value, $post_id, $field) {
    return fix_widows_after_prepositions($value);
}, 99, 3);


function highlight_accent_words($text)
{
    return preg_replace('/\{(.+?)\}/', '<span class="color-accent">$1</span>', $text);
}
function clean_yoast_header_from_accents($title)
{
    return preg_replace('/\{(.+?)\}/', '$1', $title);
}

add_filter('wpseo_title', 'clean_yoast_header_from_accents');
add_filter('wpseo_opengraph_title', 'clean_yoast_header_from_accents');
add_filter('wpseo_twitter_title', 'clean_yoast_header_from_accents');
