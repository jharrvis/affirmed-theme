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

// Customizer sections
function affirmed_customizer_sections() {
    if (!class_exists('Kirki')) return;

    // Author Section
    Kirki::add_section('author_section', array(
        'title'    => esc_html__('Author Section', 'affirmed-theme'),
        'priority' => 30,
    ));

    Kirki::add_field('affirmed_theme', array(
        'type'     => 'textarea',
        'settings' => 'author_bio',
        'label'    => esc_html__('Author Bio', 'affirmed-theme'),
        'section'  => 'author_section',
        'default'  => 'With the goal of infusing your life with confidence and gratitude, Pastor Tony Ray Smith has created a collection of positive affirmations enhanced with inspirational quotes and scriptures.',
    ));

    // (Seluruh kode untuk Kirki::add_section dan add_field Features, Sample, Contact... tetap sama)
    
    // Masukkan semua field "features_section", "sample_section", dan "contact_section" seperti sebelumnya.
    // Anda tidak perlu ubah bagian tersebut karena sudah benar.
}
add_action('init', 'affirmed_customizer_sections');

// Get theme option
function affirmed_get_option($option, $default = '') {
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
        echo '<div class="notice notice-warning is-dismissible">';
        echo '<p>' . esc_html__('The Affirmed theme requires the Kirki Customizer Framework plugin to be installed and activated for full functionality.', 'affirmed-theme') . '</p>';
        echo '</div>';
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
