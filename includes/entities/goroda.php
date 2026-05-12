<?php

/**
 * Сущность «Города» — CPT `gorod`.
 *
 * URL и хаб:
 * - Хаб «все города»: страница WordPress с шаблоном page-gorod.php (рекомендуемый ярлык `uborka-v-gorodah` → /uborka-v-gorodah/).
 *   Заголовок, контент и ACF привязаны к этой странице.
 * - Запись города: /uborka-v-gorodah/{slug}/ — шаблон single-gorod.php.
 * - Архив типа записей отключён (has_archive false), чтобы не пересекаться с страницей-хабом по URL.
 *
 * Мета записи города (register_post_meta + ACF):
 * - gorod_distance_km (number) — километры до СПб; вёрстка: «{N} км от Санкт-Петербурга».
 * - gorod_price_from (number) — цена «от …» в карточке и шапке; иначе расчёт по услугам gorod_city.
 * - gorod_kicker, gorod_stats_suffix
 *
 * Связь услуг/портфолио: мета gorod_city (ID записи города).
 *
 * Опционально ACF на странице-хабе (шаблон «Города — хаб»):
 * - goroda_hub_subtitle — подзаголовок в hero (если пусто — цитата / дефолт).
 * - goroda_directory_hint, goroda_directory_title (HTML), goroda_directory_subtitle — блок каталога городов.
 *
 * После смены ЧПУ: Настройки → Постоянные ссылки → Сохранить.
 */

defined('ABSPATH') || exit;

/** Увеличивать при смене ЧПУ у CPT gorod, чтобы один раз сбросить rewrite_rules в БД. */
if (!defined('HC_THEME_GOROD_REWRITE_VER')) {
    define('HC_THEME_GOROD_REWRITE_VER', 4);
}

function theme_register_goroda()
{
    register_post_type('gorod', [
        'labels' => [
            'name'               => 'Города',
            'singular_name'      => 'Город',
            'menu_name'          => 'Города',
            'add_new'            => 'Добавить город',
            'add_new_item'       => 'Добавить новый город',
            'edit_item'          => 'Редактировать город',
            'new_item'           => 'Новый город',
            'view_item'          => 'Посмотреть город',
            'search_items'       => 'Искать города',
            'not_found'          => 'Городов не найдено',
            'not_found_in_trash' => 'В корзине городов нет',
            'all_items'          => 'Все города',
        ],
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_rest'        => true,
        'has_archive'         => false,
        'menu_icon'           => 'dashicons-location-alt',
        'supports'            => ['title', 'editor', 'excerpt', 'thumbnail'],
        'rewrite'             => [
            'slug'       => 'uborka-v-gorodah',
            'with_front' => false,
        ],
    ]);

    $city_meta = [
        'gorod_distance_km'  => [
            'description' => 'Расстояние до Санкт-Петербурга, км (число)',
            'type'        => 'number',
        ],
        'gorod_price_from'   => [
            'description' => 'Минимальная цена «от …», ₽ (число)',
            'type'        => 'number',
        ],
        'gorod_kicker'       => [
            'description' => 'Верхняя строка шапки города (если пусто — генерируется)',
            'type'        => 'string',
        ],
        'gorod_stats_suffix' => [
            'description' => 'Фрагмент подзаголовка после числа услуг',
            'type'        => 'string',
        ],
        'gorod_first_letter' => [
            'description' => 'Первая буква названия города (для фильтров)',
            'type'        => 'string',
            'single'      => true,
            'show_in_rest' => true,
        ],
    ];

    foreach ($city_meta as $key => $cfg) {
        register_post_meta(
            'gorod',
            $key,
            [
                'description'   => $cfg['description'],
                'type'          => $cfg['type'],
                'single'        => true,
                'show_in_rest'  => true,
                'auth_callback' => function () {
                    return current_user_can('edit_posts');
                },
            ]
        );
    }

    register_post_meta(
        'services',
        'gorod_city',
        [
            'description'   => 'ID записи города (CPT gorod), если услуга относится к городу',
            'type'          => 'integer',
            'single'        => true,
            'show_in_rest'  => true,
            'auth_callback' => function () {
                return current_user_can('edit_posts');
            },
        ]
    );

    register_post_meta(
        'portfolio',
        'gorod_city',
        [
            'description'   => 'ID записи города (CPT gorod) для привязки работы',
            'type'          => 'integer',
            'single'        => true,
            'show_in_rest'  => true,
            'auth_callback' => function () {
                return current_user_can('edit_posts');
            },
        ]
    );
}

/**
 * Минимальная цена по услугам, у которых gorod_city = ID записи города.
 */
function theme_gorod_min_price_from_services($city_post_id)
{
    $city_post_id = (int) $city_post_id;
    if ($city_post_id <= 0) {
        return 0;
    }

    $prices_group = function_exists('get_field') ? get_field('all_services_prices_list', 'option') : null;
    if (!is_array($prices_group)) {
        $prices_group = [];
    }

    $q = new WP_Query([
        'post_type'              => 'services',
        'post_status'            => 'publish',
        'posts_per_page'         => -1,
        'fields'                 => 'ids',
        'no_found_rows'          => true,
        'update_post_meta_cache' => false,
        'update_post_term_cache' => false,
        'meta_query'             => [
            [
                'key'     => 'gorod_city',
                'value'   => $city_post_id,
                'compare' => '=',
                'type'    => 'NUMERIC',
            ],
        ],
    ]);

    $min = PHP_INT_MAX;
    foreach ($q->posts as $sid) {
        $sid = (int) $sid;
        $data = $prices_group['service_data_' . $sid] ?? null;
        if (!empty($data['service_price'])) {
            $p = (int) preg_replace('/[^\d]/', '', (string) $data['service_price']);
            if ($p > 0 && $p < $min) {
                $min = $p;
            }
        }
    }

    return ($min === PHP_INT_MAX) ? 0 : $min;
}

/**
 * Строка вида «45 км от Санкт-Петербурга» из числа километров.
 */
function theme_gorod_format_km_label($km)
{
    $km = (float) $km;
    if ($km <= 0) {
        return '';
    }
    $display = (floor($km) == $km)
        ? (string) (int) $km
        : rtrim(rtrim(number_format($km, 1, '.', ''), '0'), '.');

    return $display . ' км от Санкт-Петербурга';
}

/**
 * Километры до СПб из ACF/мета (get_field('gorod_distance_km', ...) и post_meta).
 */
function theme_gorod_get_distance_km($post_id)
{
    $post_id = (int) $post_id;
    if ($post_id <= 0) {
        return null;
    }
    if (function_exists('get_field')) {
        $v = get_field('gorod_distance_km', $post_id);
        if ($v !== null && $v !== '' && is_numeric($v)) {
            $f = (float) $v;
            return $f > 0 ? $f : null;
        }
    }
    $v = get_post_meta($post_id, 'gorod_distance_km', true);
    if ($v !== '' && $v !== null && is_numeric($v)) {
        $f = (float) $v;
        return $f > 0 ? $f : null;
    }

    return null;
}

/**
 * Подпись расстояния для карточки и шапки: из gorod_distance_km. Если не задан, возвращает пустую строку.
 */
function theme_gorod_distance_label($post_id)
{
    $post_id = (int) $post_id;
    $km = theme_gorod_get_distance_km($post_id);
    if ($km !== null) {
        return theme_gorod_format_km_label($km);
    }

    return '';
}

/**
 * Число для блока «от N ₽»: ACF/мета gorod_price_from или расчёт по услугам с gorod_city.
 */
function theme_gorod_display_min_price($city_post_id)
{
    $city_post_id = (int) $city_post_id;
    $raw = null;
    if (function_exists('get_field')) {
        $raw = get_field('gorod_price_from', $city_post_id);
    }
    if ($raw === null || $raw === '') {
        $raw = get_post_meta($city_post_id, 'gorod_price_from', true);
    }
    if ($raw !== '' && $raw !== null) {
        $n = (int) preg_replace('/[^\d]/', '', (string) $raw);
        if ($n > 0) {
            return $n;
        }
    }

    return theme_gorod_min_price_from_services($city_post_id);
}

/**
 * URL хаба «все города» — страница с шаблоном page-gorod.php (или ярлык uborka-v-gorodah).
 */
function theme_get_goroda_catalog_url()
{
    $pages = get_posts([
        'post_type'      => 'page',
        'post_status'    => 'publish',
        'posts_per_page' => 1,
        'orderby'        => 'date',
        'order'          => 'ASC',
        'meta_key'       => '_wp_page_template',
        'meta_value'     => 'page-gorod.php',
    ]);
    if (!empty($pages[0])) {
        return get_permalink($pages[0]->ID);
    }

    $by_slug = get_page_by_path('uborka-v-gorodah');
    if ($by_slug instanceof WP_Post) {
        return get_permalink($by_slug);
    }

    return home_url('/');
}

/**
 * ID страницы-хаба (для ACF location и т.п.).
 */
function theme_get_gorod_hub_page_id()
{
    $pages = get_posts([
        'post_type'      => 'page',
        'post_status'    => 'publish',
        'posts_per_page' => 1,
        'fields'         => 'ids',
        'meta_key'       => '_wp_page_template',
        'meta_value'     => 'page-gorod.php',
    ]);
    if (!empty($pages[0])) {
        return (int) $pages[0];
    }

    $by_slug = get_page_by_path('uborka-v-gorodah');
    if ($by_slug instanceof WP_Post) {
        return (int) $by_slug->ID;
    }

    return 0;
}

/**
 * При сохранении поста CPT gorod, сохраняет его первую букву в мета-поле gorod_first_letter.
 */
add_action('save_post_gorod', function ($post_id, $post, $update) {
    if (wp_is_post_revision($post_id) || wp_is_post_autosave($post_id)) {
        return;
    }

    if ($post->post_status === 'publish' && !empty($post->post_title)) {
        $first_letter = mb_strtoupper(mb_substr($post->post_title, 0, 1, 'UTF-8'), 'UTF-8');
        update_post_meta($post_id, 'gorod_first_letter', $first_letter);
    }
}, 10, 3);

/**
 * Возвращает массив уникальных первых букв названий городов (CPT gorod), отсортированных по алфавиту.
 */
function theme_get_unique_city_first_letters(): array
{
    $letters = [];
    $cities = get_posts([
        'post_type'        => 'gorod',
        'post_status'      => 'publish',
        'posts_per_page'   => -1,
        'orderby'          => 'title',
        'order'            => 'ASC',
        'suppress_filters' => true,
    ]);

    foreach ($cities as $city_post) {
        if (!$city_post instanceof WP_Post) {
            continue;
        }
        $title = (string) $city_post->post_title;
        if ($title === '') {
            continue;
        }
        $first_letter = mb_strtoupper(mb_substr($title, 0, 1, 'UTF-8'), 'UTF-8');
        if ($first_letter !== '' && preg_match('/^[А-ЯЁ]$/u', $first_letter)) {
            $letters[$first_letter] = $first_letter;
        }
    }

    ksort($letters, SORT_STRING);

    return array_values($letters);
}

/**
 * Возвращает название города в предложном падеже (например, "в Санкт-Петербурге").
 */
function theme_gorod_decline_in_prepositional(string $city_name): string
{
    // Простые правила для известных городов. Можно расширить при необходимости.
    switch (mb_strtolower($city_name, 'UTF-8')) {
        case 'всеволожск':
            return 'Всеволожске';
        case 'гатчина':
            return 'Гатчине';
        case 'зеленогорск':
            return 'Зеленогорске';
        case 'колпино':
            return 'Колпине';
        case 'коммунар':
            return 'Коммунаре';
        case 'красное село':
            return 'Красном Селе';
        case 'кронштадт':
            return 'Кронштадте';
        case 'кудрово':
            return 'Кудрово'; // Не склоняется
        case 'мурино':
            return 'Мурино'; // Не склоняется
        case 'петергоф':
            return 'Петергофе';
        case 'пушкин':
            return 'Пушкине';
        case 'сертолово':
            return 'Сертолово'; // Не склоняется
        case 'сестрорецк':
            return 'Сестрорецке';
        case 'тосно':
            return 'Тосно'; // Не склоняется
        default:
            // Для остальных городов можно добавить более сложную логику или оставить как есть
            return $city_name;
    }
}
