<?php

function theme_register_reviews()
{
    register_post_type('reviews', [
        'labels' => [
            'name'          => 'Отзывы',
            'singular_name' => 'Отзыв',
            'menu_name'     => 'Отзывы'
        ],
        'public'             => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_rest'       => false,
        'publicly_queryable' => false,
        'exclude_from_search' => true,
        'supports'           => ['title', 'editor', 'thumbnail'],
        'has_archive'        => false,
        'rewrite'            => false,
        'query_var'          => false,
    ]);
}
