<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="format-detection" content="telephone=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- favicon -->
    <link rel="icon" type="image/png" href="<?php echo get_template_directory_uri() ?>/assets/favicon-96x96.png" sizes="96x96">
    <link rel="icon" type="image/svg+xml" href="<?php echo get_template_directory_uri() ?>/assets/favicon.svg">
    <link rel="shortcut icon" href="<?php echo get_template_directory_uri() ?>/assets/favicon.ico">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo get_template_directory_uri() ?>/assets/apple-touch-icon.png">
    <meta name="apple-mobile-web-app-title" content="Сложная уборка">
    <link rel="manifest" href="<?php echo get_template_directory_uri() ?>/assets/site.webmanifest">
    <!-- favicon -->

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    <div class="wrapper">
        <?php require_once(TEMPLATE_PATH . '_header-main.php'); ?>
        <main id="primary" class="main">