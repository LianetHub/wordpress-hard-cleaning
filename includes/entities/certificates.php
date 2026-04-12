<?php

function theme_register_certificates()
{
    register_post_type('certificates', [
        'labels'             => [
            'name'               => 'Документы',
            'singular_name'      => 'Документ',
            'add_new'            => 'Добавить документ',
            'add_new_item'       => 'Добавить новый документ',
            'edit_item'          => 'Редактировать документ',
            'new_item'           => 'Новый документ',
            'view_item'          => 'Посмотреть документ',
            'search_items'       => 'Найти документ',
            'not_found'          => 'Документов не найдено',
            'not_found_in_trash' => 'В корзине документов не найдено',
            'parent_item_colon'  => '',
            'menu_name'          => 'Документы',
        ],
        'public'             => true,
        'has_archive'        => true,
        'publicly_queryable' => false,
        'query_var'          => true,
        'menu_icon'          => 'dashicons-media-document',
        'supports'           => ['title'],
        'rewrite'            => ['slug' => 'docs'],
        'show_in_rest'       => true,
    ]);
}
