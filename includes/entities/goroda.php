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
 * Мета записи города (register_post_meta):
 * - gorod_distance, gorod_price_from, gorod_kicker, gorod_stats_suffix
 *
 * Связь услуг/портфолио: мета gorod_city (ID записи города).
 *
 * Опционально ACF на странице-хабе (шаблон «Города — хаб»):
 * - goroda_hub_subtitle — подзаголовок в hero (если пусто — цитата / дефолт).
 * - goroda_directory_hint, goroda_directory_title (HTML), goroda_directory_subtitle — блок каталога городов.
 */

defined('ABSPATH') || exit;

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
        'gorod_distance'     => [
            'description' => 'Подпись расстояния (напр. «45 км от СПб»)',
            'type'        => 'string',
        ],
        'gorod_price_from'   => [
            'description' => 'Цена «от …» для карточки и шапки',
            'type'        => 'string',
        ],
        'gorod_kicker'       => [
            'description' => 'Верхняя строка шапки города (если пусто — генерируется)',
            'type'        => 'string',
        ],
        'gorod_stats_suffix' => [
            'description' => 'Фрагмент подзаголовка после числа услуг',
            'type'        => 'string',
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
 * Число для блока «от N ₽»: мета записи города или расчёт по услугам с gorod_city.
 */
function theme_gorod_display_min_price($city_post_id)
{
    $raw = get_post_meta((int) $city_post_id, 'gorod_price_from', true);
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
 * Жёстко задаёт ЧПУ записей города: /uborka-v-gorodah/{slug}/
 */
add_filter('post_type_link', 'theme_gorod_permalink', 10, 2);
function theme_gorod_permalink($post_link, $post)
{
    if (!($post instanceof WP_Post) || $post->post_type !== 'gorod') {
        return $post_link;
    }
    if ($post->post_status !== 'publish' || $post->post_name === '') {
        return $post_link;
    }

    return home_url(user_trailingslashit('uborka-v-gorodah/' . $post->post_name));
}
