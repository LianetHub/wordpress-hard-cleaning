<?php

/**
 * Theme functions and definitions
 */

require_once('includes/admin-custom.php');
require_once('includes/acf-custom.php');

// =========================================================================
// 1. CONSTANTS & ENV CONFIG
// =========================================================================

define('TEMPLATE_PATH', dirname(__FILE__) . '/templates/');


// =========================================================================
// 2. THEME SETUP & SUPPORT
// =========================================================================

function cleaning_theme_setup()
{
    add_theme_support('title-tag');

    add_action('after_setup_theme', function () {
        add_theme_support('post-thumbnails');
    });

    add_theme_support('custom-logo', [
        'height'      => 81,
        'width'       => 168,
        'flex-width'  => true,
        'flex-height' => true,
    ]);
    register_nav_menus([
        'header_menu'   => 'Меню в шапке',
    ]);
}
add_action('after_setup_theme', 'cleaning_theme_setup');

// =========================================================================
// 3. ENQUEUE STYLES
// =========================================================================

function theme_enqueue_styles()
{
    $theme_dir = get_template_directory();
    $theme_uri = get_template_directory_uri();

    wp_enqueue_style('swiper', $theme_uri . '/assets/css/libs/swiper-bundle.min.css');
    wp_enqueue_style('fancybox', $theme_uri . '/assets/css/libs/fancybox.css');
    wp_enqueue_style('reset', $theme_uri . '/assets/css/reset.min.css');

    $main_css_ver = filemtime($theme_dir . '/assets/css/style.min.css');
    wp_enqueue_style('main-style', $theme_uri . '/assets/css/style.min.css', array(), $main_css_ver);


    // temp test path
    // $style_path = get_template_directory() . '/style.css';
    // wp_enqueue_style(
    //     'cleaning-style',
    //     get_template_directory_uri() . '/style.css',
    //     array(),
    //     file_exists($style_path) ? (string) filemtime($style_path) : wp_get_theme()->get('Version')
    // );
    // wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Manrope:wght@300;500;600;700&family=Unbounded:wght@400;600;700;800&display=swap', array(), null);
}

add_action('wp_enqueue_scripts', 'theme_enqueue_styles');

add_filter('style_loader_tag', 'theme_styles_add_attributes', 10, 2);
function theme_styles_add_attributes($tag, $handle)
{
    $async_styles = array('swiper', 'fancybox');

    if (in_array($handle, $async_styles)) {
        return str_replace(
            " media='all'",
            " media='print' onload=\"this.media='all'; this.onload=null;\"",
            $tag
        );
    }
    return $tag;
}

// =========================================================================
// 4. ENQUEUE SCRIPTS
// =========================================================================

function theme_enqueue_scripts()
{
    $theme_dir = get_template_directory();
    $theme_uri = get_template_directory_uri();

    wp_deregister_script('jquery');
    wp_enqueue_script('jquery', $theme_uri . '/assets/js/libs/jquery-4.0.0.min.js', array(), '4.0.0', true);

    wp_enqueue_script('swiper-js', $theme_uri . '/assets/js/libs/swiper-bundle.min.js', array(), null, true);
    wp_enqueue_script('fancybox-js', $theme_uri . '/assets/js/libs/fancybox.umd.js', array(), null, true);

    $app_js_ver = filemtime($theme_dir . '/assets/js/app.min.js');
    wp_enqueue_script(
        'app-js',
        $theme_uri . '/assets/js/app.min.js',
        array('jquery', 'swiper-js', 'fancybox-js'),
        $app_js_ver,
        true
    );
}
add_action('wp_enqueue_scripts', 'theme_enqueue_scripts');

add_filter('script_loader_tag', 'theme_scripts_add_attributes', 10, 2);

function theme_scripts_add_attributes($tag, $handle)
{
    $deferred_scripts = array(
        'swiper-js',
        'fancybox-js',
        'app-js'
    );

    if (in_array($handle, $deferred_scripts)) {
        return str_replace(' src', ' defer src', $tag);
    }
    return $tag;
}


/**
 * Подключение SVG из assets/svg/{name}.svg с уникализацией id/url(#…)/href="#…" на каждый вывод (без конфликтов на странице).
 *
 * @param string $name Имя файла без .svg
 * @param array  $attr Атрибуты корневого тега <svg>, нап. array( 'class' => 'x', 'aria-hidden' => 'true' )
 * @return string
 */
function cleaning_inline_svg($name, $attr = array())
{
    $base = basename((string) $name, '.svg');
    $path = get_template_directory() . '/assets/svg/' . $base . '.svg';
    if (! is_readable($path)) {
        return '';
    }
    $svg = file_get_contents($path);
    if (false === $svg) {
        return '';
    }
    $svg = preg_replace("/\r\n|\r/", "\n", $svg);
    $svg = trim($svg);

    $sid = wp_unique_id('i');
    $svg = preg_replace_callback(
        '/\bid="([^"]+)"/',
        static function ($m) use ($sid) {
            return 'id="' . esc_attr($m[1] . '-' . $sid) . '"';
        },
        $svg
    );
    $svg = preg_replace_callback(
        '/url\(\s*#([^)]+)\s*\)/',
        static function ($m) use ($sid) {
            return 'url(#' . $m[1] . '-' . $sid . ')';
        },
        $svg
    );
    $svg = preg_replace_callback(
        '/href="#([^"]+)"/',
        static function ($m) use ($sid) {
            return 'href="#' . $m[1] . '-' . $sid . '"';
        },
        $svg
    );

    if (! empty($attr) && is_array($attr)) {
        $inject = '';
        foreach ($attr as $k => $v) {
            $inject .= ' ' . esc_attr($k) . '="' . esc_attr(is_bool($v) ? ($v ? 'true' : 'false') : (string) $v) . '"';
        }
        $svg = preg_replace('/<svg\s/i', '<svg' . $inject . ' ', $svg, 1);
    }

    return $svg;
}


// function cleaning_theme_scripts()
// {
//     $style_path = get_template_directory() . '/style.css';
//     wp_enqueue_style(
//         'cleaning-style',
//         get_template_directory_uri() . '/style.css',
//         array(),
//         file_exists($style_path) ? (string) filemtime($style_path) : wp_get_theme()->get('Version')
//     );
//     wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Manrope:wght@300;500;600;700&family=Unbounded:wght@400;600;700;800&display=swap', array(), null);

//     wp_enqueue_script(
//         'cleaning-header-nav',
//         get_template_directory_uri() . '/js/header-nav.js',
//         array(),
//         wp_get_theme()->get('Version'),
//         true
//     );

//     if (is_front_page()) {
//         wp_enqueue_script(
//             'cleaning-process-carousel',
//             get_template_directory_uri() . '/js/process-carousel.js',
//             array(),
//             wp_get_theme()->get('Version'),
//             true
//         );

//         $trust_js = get_template_directory() . '/js/trust-slider.js';
//         wp_enqueue_script(
//             'cleaning-trust-slider',
//             get_template_directory_uri() . '/js/trust-slider.js',
//             array(),
//             file_exists($trust_js) ? (string) filemtime($trust_js) : wp_get_theme()->get('Version'),
//             true
//         );
//     }
// }
// add_action('wp_enqueue_scripts', 'cleaning_theme_scripts');
