<?php

add_action('init', 'register_theme_entities');

function register_theme_entities()
{

    register_post_type('reviews', [
        'labels' => [
            'name'               => 'Отзывы',
            'singular_name'      => 'Отзыв',
            'add_new'            => 'Добавить отзыв',
            'add_new_item'       => 'Добавить новый отзыв',
            'edit_item'          => 'Редактировать отзыв',
            'menu_name'          => 'Отзывы'
        ],
        'public'             => true,
        'show_in_rest'       => true,
        'exclude_from_search' => true,
        'publicly_queryable'  => false,
        'show_ui'            => true,
        'menu_icon'          => 'dashicons-testimonial',
        'supports'           => ['title', 'editor', 'thumbnail'],
        'has_archive'        => false,
        'rewrite'            => false,
        'query_var'          => true,
    ]);

    register_taxonomy('service_cat', 'services', [
        'labels' => [
            'name'          => 'Категории услуг',
            'singular_name' => 'Категория',
            'menu_name'     => 'Категории услуг',
        ],
        'public'             => true,
        'hierarchical'       => true,
        'show_in_rest'       => true,
        'show_admin_column'  => true,
        'query_var'          => true,
        'rewrite'            => [
            'slug'         => 'uslugi',
            'with_front'   => false,
            'hierarchical' => true
        ],
    ]);


    register_post_type('services', [
        'labels' => [
            'name'          => 'Услуги',
            'singular_name' => 'Услуга',
            'add_new'       => 'Добавить услугу',
            'menu_name'     => 'Услуги'
        ],
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'has_archive'        => 'services-list',
        'show_in_rest'       => true,
        'menu_icon'          => 'dashicons-admin-tools',
        'supports'           => ['title', 'editor', 'thumbnail', 'excerpt'],
        'rewrite'            => [
            'slug'       => 'uslugi',
            'with_front' => false
        ],
    ]);
}

add_filter('wpseo_breadcrumb_links', 'add_services_parent_breadcrumb');
function add_services_parent_breadcrumb($links)
{
    if (is_tax('service_cat') || is_singular('services')) {
        $services_hub_link = [
            'url' => home_url('/uslugi/'),
            'text' => 'Услуги',
        ];

        array_splice($links, 1, 0, [$services_hub_link]);
    }
    return $links;
}
