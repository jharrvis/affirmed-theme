<?php
/**
 * Affirmed Theme Functions
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Theme setup
function affirmed_theme_setup() {
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));

    register_nav_menus(array(
        'primary' => esc_html__('Primary Menu', 'affirmed-theme'),
    ));
}
add_action('after_setup_theme', 'affirmed_theme_setup');

// Enqueue styles and scripts
function affirmed_theme_scripts() {
    wp_enqueue_style('affirmed-style', get_stylesheet_uri(), array(), '1.0.0');
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css', array(), '6.4.0');
    wp_enqueue_script('jquery');
    wp_enqueue_script('affirmed-script', get_template_directory_uri() . '/js/script.js', array('jquery'), '1.0.0', true);

    wp_localize_script('affirmed-script', 'affirmed_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('affirmed_nonce')
    ));
}
add_action('wp_enqueue_scripts', 'affirmed_theme_scripts');

// Include Kirki customizer configuration
if (file_exists(get_template_directory() . '/inc/customizer.php')) {
    require_once get_template_directory() . '/inc/customizer.php';
}

// Include Kirki installer helper
if (file_exists(get_template_directory() . '/inc/kirki-installer.php')) {
    require_once get_template_directory() . '/inc/kirki-installer.php';
}

// Include Stripe payment handler
if (file_exists(get_template_directory() . '/inc/stripe-simple-handler.php')) {
    require_once get_template_directory() . '/inc/stripe-simple-handler.php';
}

// Include debug helper (optional - for development)
if (file_exists(get_template_directory() . '/inc/debug-customizer.php')) {
    require_once get_template_directory() . '/inc/debug-customizer.php';
}

// Get theme option helper function
function affirmed_get_option($option, $default = '') {
    // First check if we're using Kirki with prefixed options
    $kirki_options = get_theme_mod('affirmed_theme_options', array());
    
    if (!empty($kirki_options) && isset($kirki_options[$option])) {
        return $kirki_options[$option];
    }
    
    // Fallback to individual theme_mod for backward compatibility
    return get_theme_mod($option, $default);
}

// AJAX form handler
function affirmed_handle_form_submission() {
    if (!wp_verify_nonce($_POST['nonce'], 'affirmed_nonce')) {
        wp_die('Security check failed');
    }

    $name    = sanitize_text_field($_POST['name']);
    $email   = sanitize_email($_POST['email']);
    $phone   = sanitize_text_field($_POST['phone']);
    $address = sanitize_text_field($_POST['address']);
    $city    = sanitize_text_field($_POST['city']);
    $state   = sanitize_text_field($_POST['state']);
    $zip     = sanitize_text_field($_POST['zip']);
    $country = sanitize_text_field($_POST['country']);

    wp_send_json_success(array(
        'message' => 'Form submitted successfully!'
    ));
}
add_action('wp_ajax_affirmed_form_submit', 'affirmed_handle_form_submission');
add_action('wp_ajax_nopriv_affirmed_form_submit', 'affirmed_handle_form_submission');

// Custom image sizes
function affirmed_image_sizes() {
    add_image_size('book-cover', 400, 600, true);
    add_image_size('author-portrait', 256, 320, true);
    add_image_size('feature-image', 400, 300, true);
    add_image_size('testimonial-image', 128, 128, true);
}
add_action('after_setup_theme', 'affirmed_image_sizes');

// Admin notice
function affirmed_admin_notice() {
    if (!class_exists('Kirki') && current_user_can('install_plugins')) {
        $screen = get_current_screen();
        
        // Show notice on themes page and in customizer
        if ($screen && ($screen->id === 'themes' || $screen->id === 'customize')) {
            echo '<div class="notice notice-warning is-dismissible">';
            echo '<p><strong>' . esc_html__('Affirmed Theme Notice:', 'affirmed-theme') . '</strong> ';
            echo esc_html__('The Kirki Customizer Framework plugin is recommended for full theme functionality. ', 'affirmed-theme');
            echo '<a href="' . admin_url('plugin-install.php?s=kirki&tab=search&type=term') . '">' . esc_html__('Install Kirki Plugin', 'affirmed-theme') . '</a></p>';
            echo '</div>';
        }
    }
}
add_action('admin_notices', 'affirmed_admin_notice');

// Widgets
function affirmed_widgets_init() {
    register_sidebar(array(
        'name'          => esc_html__('Footer Widget Area', 'affirmed-theme'),
        'id'            => 'footer-widgets',
        'description'   => esc_html__('Widgets in this area will be shown in the footer.', 'affirmed-theme'),
        'before_widget' => '<div class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'affirmed_widgets_init');

// Add custom CSS from customizer
function affirmed_custom_css() {
    $custom_css = affirmed_get_option('custom_css', '');
    
    if (!empty($custom_css)) {
        wp_add_inline_style('affirmed-style', $custom_css);
    }
}
add_action('wp_enqueue_scripts', 'affirmed_custom_css', 20);

// Add custom header code
function affirmed_custom_header_code() {
    $header_code = affirmed_get_option('custom_header_code', '');
    $analytics = affirmed_get_option('google_analytics', '');
    
    if (!empty($header_code)) {
        echo $header_code;
    }
    
    if (!empty($analytics)) {
        echo $analytics;
    }
}
add_action('wp_head', 'affirmed_custom_header_code', 100);

// Add custom footer code
function affirmed_custom_footer_code() {
    $footer_code = affirmed_get_option('custom_footer_code', '');
    
    if (!empty($footer_code)) {
        echo $footer_code;
    }
}
add_action('wp_footer', 'affirmed_custom_footer_code', 100);

// Back to top button
function affirmed_back_to_top() {
    if (affirmed_get_option('enable_back_to_top', true)) {
        echo '<button id="back-to-top" style="display:none;position:fixed;bottom:20px;right:20px;z-index:999;background:#10b981;color:white;border:none;border-radius:50%;width:50px;height:50px;cursor:pointer;"><i class="fas fa-arrow-up"></i></button>';
        echo '<script>
            jQuery(document).ready(function($) {
                $(window).scroll(function() {
                    if ($(this).scrollTop() > 300) {
                        $("#back-to-top").fadeIn();
                    } else {
                        $("#back-to-top").fadeOut();
                    }
                });
                $("#back-to-top").click(function() {
                    $("html, body").animate({ scrollTop: 0 }, 600);
                    return false;
                });
            });
        </script>';
    }
}
add_action('wp_footer', 'affirmed_back_to_top');