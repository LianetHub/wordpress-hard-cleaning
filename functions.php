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
    add_theme_support('post-thumbnails');

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

    wp_enqueue_script('yandex-maps', 'https://api-maps.yandex.ru/2.1/?apikey=496cd84c-0a7a-4b7e-a9d5-bd9261e5f0a6&lang=ru_RU', array(), null, true);
    wp_enqueue_script('swiper-js', $theme_uri . '/assets/js/libs/swiper-bundle.min.js', array(), null, true);
    wp_enqueue_script('fancybox-js', $theme_uri . '/assets/js/libs/fancybox.umd.js', array(), null, true);

    $app_js_ver = filemtime($theme_dir . '/assets/js/app.min.js');
    wp_enqueue_script(
        'app-js',
        $theme_uri . '/assets/js/app.min.js',
        array('jquery', 'yandex-maps', 'swiper-js', 'fancybox-js'),
        $app_js_ver,
        true
    );
}
add_action('wp_enqueue_scripts', 'theme_enqueue_scripts');

add_filter('script_loader_tag', 'theme_scripts_add_attributes', 10, 2);

function theme_scripts_add_attributes($tag, $handle)
{
    $scripts_to_defer = array(
        'swiper-js',
        'fancybox-js',
        'app-js'
    );

    if (in_array($handle, $scripts_to_defer)) {
        return str_replace(' src', ' defer src', $tag);
    }

    if ($handle === 'yandex-maps') {
        return str_replace(' src', ' async defer src', $tag);
    }

    return $tag;
}

// =========================================================================
// 6. SECURITY & CLEANUP
// =========================================================================

remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
remove_action('wp_head', 'rel_canonical');
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'parent_post_rel_link', 10, 0);

add_filter('xmlrpc_enabled', '__return_false');

function remove_admin_bar_links()
{
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('wp-logo');
    $wp_admin_bar->remove_menu('updates');
}
add_action('wp_before_admin_bar_render', 'remove_admin_bar_links');

add_filter('disable_wpseo_json_ld_search', '__return_true');

function allow_svg_uploads($mimes)
{
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'allow_svg_uploads');



// запрет висячих строк
function fix_widows_after_prepositions($text)
{
    if (empty($text) || !is_string($text)) {
        return $text;
    }

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
        'со'
    ];

    $pattern = implode('|', array_map('preg_quote', $prepositions));
    $regex = '/\b(' . $pattern . ')\s+/iu';

    return preg_replace_callback($regex, function ($matches) {
        return $matches[1] . "\xC2\xA0";
    }, $text);
}

add_filter('the_content', 'fix_widows_after_prepositions', 99);
add_filter('the_title', 'fix_widows_after_prepositions', 99);
add_filter('the_excerpt', 'fix_widows_after_prepositions', 99);
add_filter('widget_text_content', 'fix_widows_after_prepositions', 99);
add_filter('acf/format_value', 'fix_widows_after_prepositions', 99, 3);



add_action('init', 'register_reviews_post_type');
function register_reviews_post_type()
{
    register_post_type('reviews', [
        'labels' => [
            'name'               => 'Отзывы',
            'singular_name'      => 'Отзыв',
            'add_new'            => 'Добавить отзыв',
            'add_new_item'       => 'Добавить новый отзыв',
            'edit_item'          => 'Редактировать отзыв',
            'new_item'           => 'Новый отзыв',
            'view_item'          => 'Посмотреть отзыв',
            'search_items'       => 'Найти отзывы',
            'not_found'          => 'Отзывов не найдено',
            'parent_item_colon'  => '',
            'menu_name'          => 'Отзывы'
        ],
        'public'             => false,
        'show_ui'            => true,
        'menu_icon'          => 'dashicons-testimonial',
        'supports'           => ['title', 'editor', 'thumbnail'],
        'has_archive'        => false,
        'rewrite'            => false,
        'query_var'          => true,
    ]);
}
