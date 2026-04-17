<?php

function theme_register_staff()
{
    register_post_type('staff', [
        'labels' => [
            'name'               => 'Сотрудники',
            'singular_name'      => 'Сотрудник',
            'add_new'            => 'Добавить сотрудника',
            'add_new_item'       => 'Добавить нового сотрудника',
            'edit_item'          => 'Редактировать сотрудника',
            'new_item'           => 'Новый сотрудник',
            'view_item'          => 'Посмотреть сотрудника',
            'search_items'       => 'Найти сотрудника',
            'not_found'          => 'Сотрудников не найдено',
            'not_found_in_trash' => 'В корзине сотрудников не найдено',
            'parent_item_colon'  => '',
            'menu_name'          => 'Команда',
            'all_items'          => 'Все сотрудники',
        ],
        'public'             => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_rest'       => false,
        'publicly_queryable' => false,
        'exclude_from_search' => true,
        'supports'           => ['title', 'thumbnail'],
        'has_archive'        => false,
        'rewrite'            => false,
        'query_var'          => false,
        'menu_icon'          => 'dashicons-businessperson',
    ]);
}
