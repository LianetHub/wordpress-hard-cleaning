<?php

require_once __DIR__ . '/entities/reviews.php';
require_once __DIR__ . '/entities/services.php';

add_action('init', 'register_theme_entities');

function register_theme_entities()
{
    theme_register_reviews();
    theme_register_services();
}
