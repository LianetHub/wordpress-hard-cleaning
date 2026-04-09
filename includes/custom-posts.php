<?php

add_action('init', 'register_theme_entities');

function register_theme_entities()
{
    // 1. ОТЗЫВЫ
    register_post_type('reviews', [
        'labels' => [
            'name'          => 'Отзывы',
            'singular_name' => 'Отзыв',
            'menu_name'     => 'Отзывы'
        ],
        'public'             => true,
        'show_in_rest'       => true,
        'supports'           => ['title', 'editor', 'thumbnail'],
        'has_archive'        => false,
        'rewrite'            => ['slug' => 'reviews-items'],
    ]);

    // 2. КАТЕГОРИИ УСЛУГ 
    register_taxonomy('service_cat', 'services', [
        'labels' => [
            'name'          => 'Категории услуг',
            'singular_name' => 'Категория услуги',
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

    // 3. УСЛУГИ
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
        'public'             => true,
        'has_archive'        => 'uslugi',
        'show_in_rest'       => true,
        'menu_icon'          => 'dashicons-admin-tools',
        'supports'           => ['title', 'editor', 'thumbnail', 'excerpt'],
        'rewrite'            => [
            'slug'       => 'uslugi/%service_cat%',
            'with_front' => false,
            'hierarchical' => true
        ],
    ]);
}

/**
 * Обработка структуры URL для записей
 */
add_filter('post_type_link', 'services_permalink_structure', 10, 2);
function services_permalink_structure($post_link, $post)
{
    if ($post->post_type === 'services' && false !== strpos($post_link, '%service_cat%')) {
        $terms = get_the_terms($post->ID, 'service_cat');
        if ($terms && !is_wp_error($terms)) {
            $current_term = $terms[0];
            foreach ($terms as $term) {
                if ($term->parent != 0) {
                    $current_term = $term;
                    break;
                }
            }

            $hierarchical_slug = get_term_parents_list($current_term->term_id, 'service_cat', [
                'separator' => '/',
                'link'      => false,
                'inclusive' => true,
                'format'    => 'slug',
            ]);
            $hierarchical_slug = trim($hierarchical_slug, '/');

            $post_link = str_replace('%service_cat%', $hierarchical_slug, $post_link);
        } else {
            $post_link = str_replace('%service_cat%', 'uncategorized', $post_link);
        }
    }
    return $post_link;
}
