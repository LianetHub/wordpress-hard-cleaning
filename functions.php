<?php

/**
 * Theme functions and definitions
 */

define('TEMPLATE_PATH', dirname(__FILE__) . '/templates/');






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

function cleaning_theme_setup()
{
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'cleaning_theme'),
    ));
}
add_action('after_setup_theme', 'cleaning_theme_setup');

function cleaning_theme_scripts()
{
    $style_path = get_template_directory() . '/style.css';
    wp_enqueue_style(
        'cleaning-style',
        get_template_directory_uri() . '/style.css',
        array(),
        file_exists($style_path) ? (string) filemtime($style_path) : wp_get_theme()->get('Version')
    );
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Manrope:wght@300;500;600;700&family=Unbounded:wght@400;600;700;800&display=swap', array(), null);

    wp_enqueue_script(
        'cleaning-header-nav',
        get_template_directory_uri() . '/js/header-nav.js',
        array(),
        wp_get_theme()->get('Version'),
        true
    );

    if (is_front_page()) {
        wp_enqueue_script(
            'cleaning-process-carousel',
            get_template_directory_uri() . '/js/process-carousel.js',
            array(),
            wp_get_theme()->get('Version'),
            true
        );

        $trust_js = get_template_directory() . '/js/trust-slider.js';
        wp_enqueue_script(
            'cleaning-trust-slider',
            get_template_directory_uri() . '/js/trust-slider.js',
            array(),
            file_exists($trust_js) ? (string) filemtime($trust_js) : wp_get_theme()->get('Version'),
            true
        );
    }
}
add_action('wp_enqueue_scripts', 'cleaning_theme_scripts');
