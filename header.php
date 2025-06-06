<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    
    <?php wp_head(); ?>
    
    <style>
        :root {
            --hero-bg-color: <?php echo esc_attr(affirmed_get_option('hero_bg_color', '#000000')); ?>;
        }
    </style>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e('Skip to content', 'affirmed-theme'); ?></a>

    <header id="masthead" class="site-header">
        <?php
        // You can add a navigation menu here if needed
        if (has_nav_menu('primary')) {
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'menu_id'        => 'primary-menu',
                'container'      => 'nav',
                'container_class' => 'main-navigation',
            ));
        }
        ?>
    </header><!-- #masthead -->

    <main id="primary" class="site-main">