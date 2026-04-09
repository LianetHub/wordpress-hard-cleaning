<?php

add_action('init', 'register_theme_entities');

function register_theme_entities()
{
    register_post_type('reviews', [
        'labels' => [
            'name'          => 'Отзывы',
            'singular_name' => 'Отзыв',
            'menu_name'     => 'Отзывы'
        ],
        'public'       => true,
        'show_in_rest' => true,
        'supports'     => ['title', 'editor', 'thumbnail'],
        'has_archive'  => false,
        'rewrite'      => ['slug' => 'reviews-items'],
    ]);

    register_taxonomy('service_cat', 'services', [
        'labels' => [
            'name'          => 'Категории услуг',
            'singular_name' => 'Категория услуги',
            'menu_name'     => 'Категории услуг',
        ],
        'public'            => true,
        'hierarchical'      => true,
        'show_in_rest'      => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => [
            'slug'         => 'uslugi',
            'with_front'   => false,
            'hierarchical' => true
        ],
    ]);

    register_post_type('services', [
        'labels' => [
            'name'               => 'Услуги',
            'singular_name'      => 'Услуга',
            'menu_name'          => 'Услуги',
            'add_new'            => 'Добавить услугу',
            'add_new_item'       => 'Добавить новую услугу',
            'edit_item'          => 'Редактировать услугу',
            'new_item'           => 'Новая услуга',
            'view_item'          => 'Посмотреть услугу',
            'search_items'       => 'Искать услуги',
            'not_found'          => 'Услуг не найдено',
            'not_found_in_trash' => 'В корзине услуг не найдено',
        ],
        'public'       => true,
        'has_archive'  => 'uslugi-all',
        'show_in_rest' => true,
        'menu_icon'    => 'dashicons-admin-tools',
        'supports'     => ['title', 'editor', 'thumbnail', 'excerpt'],
        'rewrite'      => [
            'slug'       => 'uslugi',
            'with_front' => false,
        ],
    ]);
}

add_filter('request', 'reorder_services_request_priority');
function reorder_services_request_priority($query)
{
    if (isset($query['service_cat']) && !empty($query['service_cat'])) {
        $path_parts = explode('/', $query['service_cat']);
        $last_segment = end($path_parts);

        $post = get_page_by_path($last_segment, OBJECT, 'services');

        if ($post) {
            unset($query['service_cat']);
            $query['services'] = $last_segment;
            $query['post_type'] = 'services';
            $query['name'] = $last_segment;
        }
    }
    return $query;
}
