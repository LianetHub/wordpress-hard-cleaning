<?php

function theme_register_portfolio()
{
    register_post_type('portfolio', [
        'labels' => [
            'name'               => 'Портфолио',
            'singular_name'      => 'Работа',
            'menu_name'          => 'Портфолио',
            'all_items'          => 'Все работы',
            'add_new'            => 'Добавить работу',
            'add_new_item'       => 'Добавить новую работу',
            'edit_item'          => 'Редактировать работу',
            'new_item'           => 'Новая работа',
            'view_item'          => 'Посмотреть работу',
            'search_items'       => 'Искать в портфолио',
            'not_found'          => 'Работ не найдено',
            'not_found_in_trash' => 'В корзине работ не найдено',
        ],
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_rest'       => true,
        'has_archive'        => 'portfolio',
        'rewrite'            => [
            'slug'       => 'portfolio',
            'with_front' => false
        ],
        'supports'           => ['title', 'editor',  'excerpt'],
        'menu_icon'          => 'dashicons-portfolio',
    ]);
}
