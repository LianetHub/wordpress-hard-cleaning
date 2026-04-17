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
        'header_menu'             => 'Меню в шапке',
        'footer_navigation_menu'  => 'Меню навигации в подвале',
        'footer_information_menu' => 'Меню информации в подвале',
        'footer_individuals_menu' => 'Меню услуг частным лицам в подвале',
        'footer_companies_menu'   => 'Меню услуг компаниям в подвале',
    ]);
}
add_action('after_setup_theme', 'cleaning_theme_setup');

add_action('init', function () {
    unregister_taxonomy_for_object_type('category', 'post');
    unregister_taxonomy_for_object_type('post_tag', 'post');
});

add_action('admin_menu', function () {
    remove_submenu_page('edit.php', 'edit-tags.php?taxonomy=category');
    remove_submenu_page('edit.php', 'edit-tags.php?taxonomy=post_tag');
});


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

    wp_localize_script('app-js', 'admin_ajax', [
        'url' => admin_url('admin-ajax.php')
    ]);

    if (is_singular('post')) {
        wp_enqueue_script(
            'post-scripts',
            get_template_directory_uri() . '/assets/js/article-actions.min.js',
            array('app-js'),
            null,
            true
        );
    }
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


function get_processed_svg($url, $new_color)
{
    if (!$url) return '';

    $path = str_replace(site_url('/'), ABSPATH, $url);

    if (!file_exists($path)) {
        return '<img src="' . esc_url($url) . '" alt="">';
    }

    $svg_code = file_get_contents($path);

    $svg_code = preg_replace('/fill="((?!none)[^"]+)"/i', 'fill="' . $new_color . '"', $svg_code);
    $svg_code = preg_replace('/stroke="((?!none)[^"]+)"/i', 'stroke="' . $new_color . '"', $svg_code);

    return $svg_code;
}


add_filter('the_content', function ($content) {
    if (!is_singular() || strpos($content, '<table') === false) {
        return $content;
    }

    $dom = new DOMDocument();
    $html_encoded = mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8');
    @$dom->loadHTML('<div>' . $html_encoded . '</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

    $tables = $dom->getElementsByTagName('table');

    foreach ($tables as $table) {
        $headers = [];
        $th_nodes = $table->getElementsByTagName('th');

        foreach ($th_nodes as $th) {
            $headers[] = trim($th->nodeValue);
        }

        if (!empty($headers)) {
            $rows = $table->getElementsByTagName('tr');
            foreach ($rows as $row) {
                $cells = $row->getElementsByTagName('td');
                $index = 0;
                foreach ($cells as $cell) {
                    if (isset($headers[$index])) {
                        $cell->setAttribute('data-label', $headers[$index]);
                    }
                    $index++;
                }
            }
        }
    }

    $new_content = '';
    $wrapper = $dom->documentElement;

    if ($wrapper) {
        foreach ($wrapper->childNodes as $child) {
            $new_content .= $dom->saveHTML($child);
        }
    } else {
        $new_content = $content;
    }

    return $new_content;
}, 20);

// pagination
function hard_cleaning_theme_pagination_class_filter($template)
{
    $template = str_replace('page-numbers', 'pagination__item', $template);
    $template = str_replace('current', 'active', $template);

    $template = str_replace('prev pagination__item', 'pagination__prev icon-arrow-left', $template);
    $template = str_replace('next pagination__item', 'pagination__next icon-arrow-right', $template);

    return $template;
}
add_filter('paginate_links', 'hard_cleaning_theme_pagination_class_filter');

add_filter('next_posts_link_attributes', 'posts_link_attributes');
add_filter('previous_posts_link_attributes', 'posts_link_attributes');

function posts_link_attributes()
{
    return 'class="pagination__item"';
}

function custom_prev_class($format)
{
    return str_replace('href=', 'class="pagination__prev icon-arrow-left" href=', $format);
}
add_filter('previous_posts_link_attributes', function () {
    return 'class="pagination__prev icon-arrow-left"';
});
add_filter('next_posts_link_attributes', function () {
    return 'class="pagination__next icon-arrow-right"';
});


// время чтения в минутах для поста
function hard_cleaning_theme_reading_time($post_id = null, $wpm = 10, $seconds_per_image = 5)
{
    $post_id = $post_id ?: get_the_ID();
    $html = apply_filters('the_content', get_post_field('post_content', $post_id));
    $words = str_word_count(wp_strip_all_tags($html));
    preg_match_all('/<img\b[^>]*>/i', $html, $matches);
    $images = count($matches[0]);
    $words += ($images * $seconds_per_image) * $wpm / 60;

    return max(1, (int) ceil($words / $wpm));
}

function hard_cleaning_theme_the_reading_time($before = '', $after = ' мин. читать')
{
    printf(
        '%s%d%s',
        $before,
        hard_cleaning_theme_reading_time(),
        $after
    );
}

// Просмотры статьи
function hard_cleaning_theme_set_post_views($postID)
{
    $count_key = 'hard_cleaning_theme_post_views';
    $count     = get_post_meta($postID, $count_key, true);

    if ($count == '') {
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, 1);
    } else {
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}

function hard_cleaning_theme_get_post_views($postID)
{
    $count = get_post_meta($postID, 'hard_cleaning_theme_post_views', true);
    return $count ? (int) $count : 0;
}

function hard_cleaning_theme_increment_views_ajax()
{
    if (isset($_POST['post_id']) && is_numeric($_POST['post_id'])) {
        hard_cleaning_theme_set_post_views((int)$_POST['post_id']);
        wp_send_json_success();
    }
    wp_send_json_error();
}
add_action('wp_ajax_hard_cleaning_theme_increment_views', 'hard_cleaning_theme_increment_views_ajax');
add_action('wp_ajax_nopriv_hard_cleaning_theme_increment_views', 'hard_cleaning_theme_increment_views_ajax');


// Лайки статьи
function hard_cleaning_theme_add_like()
{
    if (! isset($_POST['post_id']) || ! is_numeric($_POST['post_id'])) {
        wp_send_json_error();
    }

    $post_id = (int) $_POST['post_id'];

    $current_likes = (int) get_post_meta($post_id, 'hard_cleaning_theme_likes', true);
    $current_likes++;
    update_post_meta($post_id, 'hard_cleaning_theme_likes', $current_likes);

    wp_send_json_success(['likes' => $current_likes]);
}

add_action('wp_ajax_hard_cleaning_theme_add_like', 'hard_cleaning_theme_add_like');
add_action('wp_ajax_nopriv_hard_cleaning_theme_add_like', 'hard_cleaning_theme_add_like');

function hard_cleaning_theme_remove_like()
{
    if (!isset($_POST['post_id']) || !is_numeric($_POST['post_id'])) {
        wp_send_json_error();
    }

    $post_id = (int)$_POST['post_id'];
    $current_likes = (int)get_post_meta($post_id, 'hard_cleaning_theme_likes', true);

    if ($current_likes > 0) {
        $current_likes--;
        update_post_meta($post_id, 'hard_cleaning_theme_likes', $current_likes);
    }

    wp_send_json_success(['likes' => $current_likes]);
}
add_action('wp_ajax_hard_cleaning_theme_remove_like', 'hard_cleaning_theme_remove_like');
add_action('wp_ajax_nopriv_hard_cleaning_theme_remove_like', 'hard_cleaning_theme_remove_like');


add_action('wp_footer', function () {
    if (!isset($_COOKIE['cookie_notice'])) : ?>
        <div id="cookie-notice" class="cookie cookie--hidden">
            <div class="cookie__text">
                Мы используем файлы cookie, чтобы сайт работал&nbsp;лучше. Оставаясь с нами, вы соглашаетесь на
                <a href="<?php echo esc_url(get_privacy_policy_url() . '#cookies'); ?>" target="_blank">использование файлов cookie</a>.
            </div>
            <button type="button" class="cookie__accept btn btn-primary btn-sm">Хорошо</button>
        </div>

        <script>
            (function() {
                function setCookie(name, value, options) {
                    options = options || {};
                    var expires = options.expires;

                    if (typeof expires == "number" && expires) {
                        var d = new Date();
                        d.setTime(d.getTime() + expires * 1000);
                        expires = options.expires = d;
                    }
                    if (expires && expires.toUTCString) {
                        options.expires = expires.toUTCString();
                    }
                    value = encodeURIComponent(value);
                    var updatedCookie = name + "=" + value;

                    for (var propName in options) {
                        updatedCookie += "; " + propName;
                        var propValue = options[propName];
                        if (propValue !== true) {
                            updatedCookie += "=" + propValue;
                        }
                    }
                    document.cookie = updatedCookie;
                }

                var noticeDiv = document.getElementById('cookie-notice');
                if (noticeDiv) {
                    setTimeout(function() {
                        noticeDiv.classList.remove('cookie--hidden');
                    }, 3000);

                    noticeDiv.querySelector('.cookie__accept').addEventListener('click', function() {
                        setCookie('cookie_notice', 1, {
                            expires: 180 * 24 * 60 * 60,
                            path: '/'
                        });
                        noticeDiv.classList.add('cookie--hidden');

                        setTimeout(function() {
                            noticeDiv.remove();
                        }, 500);
                    });
                }
            })();
        </script>
<?php endif;
});
